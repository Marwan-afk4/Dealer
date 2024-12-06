<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\TrainingSubscription;
use App\Models\User;
use Illuminate\Http\Request;

class RequestsController extends Controller
{

//training contract
    public function getTrainingRequests(){
        $training=TrainingSubscription::all();
        $data=[
            'training'=>$training
        ];
        return response()->json($data);
    }

    public function acceptTrainer($id){
        $training=TrainingSubscription::find($id);
        $user=User::find($training->user_id);
        $user->role='trainer';
        $user->save();
        $training->delete();
        return response()->json(['message' => 'Trainer accepted successfully']);
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
}
