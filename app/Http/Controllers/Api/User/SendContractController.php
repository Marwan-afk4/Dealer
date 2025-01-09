<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\File;
use App\Models\TrainingSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendContractController extends Controller
{


    public function getfiles(){
        $files = File::all();
        $data =[
            'files'=>$files
        ];

        return response()->json($data);
    }
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


    public function sendTrainingRequest(Request $request){
        $user = $request->user();
        $validation = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|integer',
            'age' => 'required|integer',
            'qualification' => 'nullable|string',
            'governate' => 'nullable|string',
            'experience_year' => 'nullable|integer',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 422);
        }
        $new_training = TrainingSubscription::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'qualification' => $request->qualification,
            'governate' => $request->governate,
            'experience_year' => $request->experience_year,
        ]);

        return response()->json(['message' => 'Training Request Sent Successfully']);
    }
}
