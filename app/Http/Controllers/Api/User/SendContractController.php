<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendContractController extends Controller
{


    public function sendContract(Request $request){
        $user = $request->user();
        $validation = Validator::make($request->all(), [
            'whatsapp_number' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 422);
        }
        $new_contract = Contract::create([
            'contract_name' => 'contract',
            'user_id' => $user->id,
            'whatsapp_number' => $request->whatsapp_number
        ]);

        return response()->json(['message' => 'Contract Sent Successfully']);
    }


    public function sendTrainingRequest(Request $request){}
}
