<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{

    public function getContracts(){
        $contracts = Contract::with('user')->get();
        return response()->json(['contracts'=>$contracts]);
    }


    public function createContract(Request $request){
        $validation = Validator::make($request->all(), [
            'contract_name'=>'required',
            'user_id'=>'required|exists:users,id',
            'file_id'=>'required|exists:files,id',
            'whatsapp_number'=>'required|integer',
        ]);
        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],401);
        }

        $contract = Contract::create([
            'user_id'=>$request->user_id,
            'file_id'=>$request->file_id,
            'whatsapp_number'=>$request->whatsapp_number,
        ]);
        return response()->json(['message'=>'Contract Created Successfully']);
    }

    public function deleteContract($id){
        $contract = Contract::find($id);
        $contract->delete();
        return response()->json(['message'=>'Contract deleted successfully']);
    }

    public function approveContract($id,$user_id){
        $contract = Contract::findOrFail($id);
        $user = User::findOrFail($user_id);

        $contract->update([
            'status' => 'accepted',
        ]);

        $user->update([
            'role' => 'brocker',
        ]);

        $brocker = Brocker::create([
            'user_id' => $user_id,
            'plan_id' =>$user->plan_id,
            'profit' => 0,
            'number_of_deals'=>0,
            'deals_done'=>0,
        ]);

        return response()->json(['message'=>'Contract approved successfully']);
    }
}
