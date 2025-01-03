<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\BrokerLead;
use App\Models\Compound;
use App\Models\Developer;
use App\Models\TransactionDeal;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealsController extends Controller
{

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
        if($Validation->fails()){
            return response()->json(['errors'=>$Validation->errors()], 401);
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

        return response()->json(['message'=>'Deal Added Successfully']);
    }

    public function getalldeals(){
        $deals = TransactionDeal::all();
        return response()->json(['deals'=>$deals]);
    }

    public function approveDeal($dealid, $brokerId, $developerId, $unitId){

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

        $developer->deals_done += 1;
        $developer->profit = $totalProfit;
        $developer->save();

        // Update Uptown's Status
        $deal->status = 'approved';
        $deal->save();

        return response()->json(['message' => 'Deal Approved Successfully']);

    }

}
//lsa y5lih y7ot 60 yom aw aktr
