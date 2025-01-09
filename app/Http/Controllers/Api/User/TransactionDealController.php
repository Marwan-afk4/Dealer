<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Compound;
use App\Models\Developer;
use App\Models\Lead;
use App\Models\SalesDeveloper;
use App\Models\TransactionDeal;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionDealController extends Controller
{


    public function sendTransactionDeals(Request $request){
        $user = $request->user();
        $brocker = Brocker::where('user_id', $user->id)->first();
        $validation = Validator::make($request->all(), [
            'developer_id'=>'required|exists:developers,id',
            'sales_developer_id'=>'required|exists:sales_developers,id',
            'uptown_id'=>'required|exists:uptowns,id',
            'lead_id'=>'required|exists:leads,id',
            'compound_id'=>'required|exists:compounds,id',
            'fullname'=>'required',
            'phone' => 'required|integer',
            'deal_value' => 'required',
            'image' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 422);
        }
        $new_deal = TransactionDeal::create([
            'brocker_id' => $brocker->id,
            'developer_id' => $request->developer_id,
            'compound_id' => $request->compound_id,
            'sales_developer_id' => $request->sales_developer_id,
            'uptown_id' => $request->uptown_id,
            'lead_id' => $request->lead_id,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'deal_value' => $request->deal_value,
            'image' => $request->image,
        ]);

        return response()->json(['message' => 'Transaction Deal Sent Successfully','deal_id'=>$new_deal]);
    }

    public function leadid(){
        $leads = Lead::where('status', 'pending')->get();
        return response()->json(['leads'=>$leads]);
    }

    public function developerid(){
        $developers = Developer::all();
        $data= $developers->map(function ($developer) {
            return [
                'id' => $developer->id,
                'name' => $developer->name,
            ];
        });
        return response()->json(['developers'=>$data]);
    }

    public function salesdeveloperid($developer_id){
        $sales_developers = SalesDeveloper::where('developer_id', $developer_id)->get();
        $data = $sales_developers->map(function ($sales_developer) {
            return [
                'id' => $sales_developer->id,
                'name' => $sales_developer->sale_name,
            ];
        });
        return response()->json(['sales_developers'=>$data]);
    }

    public function compoundid($developer_id){
        $compounds = Compound::where('developer_id', $developer_id)->get();
        $data = $compounds->map(function ($compound) {
            return [
                'id' => $compound->id,
                'compound_name' => $compound->compound_name,
            ];
        });
        return response()->json(['compounds'=>$data]);
    }

    public function uptownid($compound_id){
        $uptowns = Uptown::where('compound_id', $compound_id)->get();
        $data = $uptowns->map(function ($uptown) {
            return [
                'id' => $uptown->id,
                'uptown_name' => $uptown->name,
            ];
        });
        return response()->json(['uptowns'=>$data]);
    }
}
