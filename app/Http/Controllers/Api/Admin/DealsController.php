<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\BrokerLead;
use App\Models\Compound;
use App\Models\Developer;
use App\Models\SalesDeveloper;
use App\Models\TransactionDeal;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealsController extends Controller
{

    protected $updatePeriodDays=['days_for_profits'];

    public function getBrokerLeads($brokerId){

        $leads = BrokerLead::where('brocker_id', $brokerId)->get();
        return response()->json(['leads'=>$leads]);
    }

    public function makeDeal(Request $request){
        $Validation = Validator::make($request->all(), [
            'lead_id' => 'required|exists:leads,id',
            'developer_id' => 'required|exists:developers,id',
            'sales_developer_id' => 'required|exists:sales_developers,id',
            'brocker_id' => 'required|exists:brockers,id',
            'uptown_id' => 'required|exists:uptowns,id',
            'fullname' => 'required',
            'phone' => 'required',
            'deal_value' => 'required',
            'image' => 'required',
        ]);

        if ($Validation->fails()) {
            return response()->json(['errors' => $Validation->errors()], 401);
        }

        // Check if the selected sales_developer belongs to the developer
        $salesDeveloperBelongs = SalesDeveloper::where('id', $request->sales_developer_id)
            ->where('developer_id', $request->developer_id)
            ->exists();

        if (!$salesDeveloperBelongs) {
            return response()->json(['errors' => ['sales_developer_id' => 'The selected sales developer does not belong to the specified developer.']], 422);
        }

        $deal = TransactionDeal::create([
            'lead_id' => $request->lead_id,
            'developer_id' => $request->developer_id,
            'sales_developer_id' => $request->sales_developer_id,
            'brocker_id' => $request->brocker_id,
            'uptown_id' => $request->uptown_id,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'deal_value' => $request->deal_value,
            'image' => $request->image,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Deal Added Successfully']);
    }




    public function getalldeals(){
        $deals = TransactionDeal::all();
        return response()->json(['deals'=>$deals]);
    }

    public function approveDeal($dealid , $brokerId , $developerId , $unitId , $leadbrokerId){

        $lead = BrokerLead::findOrFail($leadbrokerId);
        $deal = TransactionDeal::findOrFail($dealid);
        $unit = Uptown::findOrFail($unitId);
        $broker = Brocker::findOrFail($brokerId);
        $developer = Developer::findOrFail($developerId);

        // Update Broker's Deals Done and Profit
        $broker->deals_done += 1;
        $broker->profit += ($broker->comission_percentage * $unit->commission_price / 100);
        $broker->save();

        // Calculate Developer's Total Profit
        $compounds = Compound::where('developer_id', $developerId)->get();
        $totalProfit = 0;

        foreach ($compounds as $compound) {
            $units = Uptown::where('compound_id', $compound->id)->get();
            foreach ($units as $unit) {
                $totalProfit += $unit->commission_price;
            }
        }

        $lead->status = 'done';
        $lead->save();

        $unit->status = 'sold';
        $unit->save();

        $developer->deals_done += 1;
        $developer->total_profit = $totalProfit;
        $developer->save();

        // Update Uptown's Status
        $deal->status = 'approved';
        $deal->save();

        return response()->json(['message' => 'Deal Approved Successfully']);

    }
    public function getleadbrockers(){
        $leadbrockers = BrokerLead::all();
        return response()->json(['leadbrockers'=>$leadbrockers]);
    }

    public function editPeriodDays(Request $request, $id){
        $deal = TransactionDeal::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'days_for_profits' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $deal->update($request->only($this->updatePeriodDays));
        return response()->json(['message'=>'Period Days Updated Successfully']);

    }

    public function rejectdeal($id){
        $deal = TransactionDeal::findOrFail($id);
        $deal->status = 'rejected';
        $deal->save();
        return response()->json(['message'=>'Deal Rejected Successfully']);
    }

}

