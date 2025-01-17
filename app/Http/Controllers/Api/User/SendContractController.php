<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Contract;
use App\Models\File;
use App\Models\Payment;
use App\Models\TrainingSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendContractController extends Controller
{

//contract
    public function getfiles(){
        $files = File::all();
        $data =[
            'files'=>$files
        ];

        return response()->json($data);
    }
    public function sendContract(Request $request){
        $user = $request->user();
        $paymentpending = Payment::where('user_id', $user->id)->where('status', 'pending')->exists();
        if (!$user || $paymentpending) {
            return response()->json(['message' => 'User is not allowed to create a contract due to pending payment or invalid user.'], 403);
        }
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
}
