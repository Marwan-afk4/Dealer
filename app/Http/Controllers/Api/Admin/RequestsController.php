<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\TrainingSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestsController extends Controller
{

//training contract
    public function getTrainingRequests(){
        $training=TrainingSubscription::where('status','pending')->get();
        $data=[
            'training'=>$training
        ];
        return response()->json($data);
    }

    public function acceptTrainer(Request $request,$id){
        $trainer = User::findOrFail($id);
        $validarion = Validator::make($request->all(), [
            'training_period' => 'required|integer',
        ]);
        TrainingSubscription::create([
            'user_id' => $trainer->id,
            'full_name' => $trainer->first_name . ' ' . $trainer->last_name,
            'email' => $trainer->email,
            'phone' => $trainer->phone,
            'age' => $trainer->age,
            'qualification' => $trainer->qualification,
            'governate' => $trainer->governce,
            'experience_year' => $trainer->experience_year,
            'status' => 'accepted',
        ]);

        // Update the trainer's training_period in the users table if needed
        $trainer->training_period = $request->training_period; // Ensure a training_period column exists in the users table
        $trainer->save();                //lsa

        return response()->json([
            'message' => 'Trainer accepted successfully, and subscription record created.',
        ]);
    }

//complaint

    public function getComplaints(){
        $complaints = Complaint::with('user:id,first_name,last_name,email,phone')->get();
        return response()->json($complaints->map(function ($complaint) {
            return [
                'complaint' => $complaint,
            ];
        }));
    }

// lsa el ba2y leads and transactions
}
