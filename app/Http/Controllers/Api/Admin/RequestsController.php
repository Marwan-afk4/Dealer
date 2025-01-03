<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Complaint;
use App\Models\TrainingSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestsController extends Controller
{

//training contract
public function getTrainingRequests()
{
    // Process expired training subscriptions
    $expiredTrainings = TrainingSubscription::where('status', 'approved')->get();

    foreach ($expiredTrainings as $training) {
        $expirationDate = $training->created_at->addDays($training->training_period);

        // Check if the training period has expired
        if (now()->greaterThanOrEqualTo($expirationDate)) {
            $user = User::findOrFail($training->user_id);

            // Update the user's role to 'brocker'
            $user->role = 'brocker';
            $user->save();

            // Create a new brocker record
            Brocker::create([
                'user_id' => $user->id,
                'plan_id' => null, // Set default or null as appropriate
                'profit' => 0,
                'number_of_deals' => 0,
                'deals_done' => 0,
                'comission_percentage' => 0,
            ]);


            $training->status = 'completed';
            $training->save();
        }
    }


    $training = TrainingSubscription::where('status', 'pending')->get();

    $data = [
        'training' => $training,
    ];

    return response()->json($data);
}


    public function acceptTrainer(Request $request,$id){
        $trainer = TrainingSubscription::findOrFail($id);
        $validarion = Validator::make($request->all(), [
            'training_period' => 'required|integer',
        ]);

        if ($validarion->fails()) {
            return response()->json(['errors' => $validarion->errors()], 422);
        }

        $trainer->training_period = $request->training_period;
        $trainer->status = 'approved';
        $trainer->save();
        return response()->json([
            'message' => 'Trainer accepted successfully, and subscription record created.',
        ]);
    }

//complaint

    public function getComplaints(){
        $complaints = Complaint::with('user:id,first_name,last_name,email,phone')->get();
        return response()->json(['complaints'=>$complaints]);
    }

// lsa el ba2y leads and transactions
}
