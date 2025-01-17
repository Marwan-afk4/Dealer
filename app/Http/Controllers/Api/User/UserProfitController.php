<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Lead;
use Illuminate\Http\Request;

class UserProfitController extends Controller
{

    public function ProfitwithLeads(Request $request){
        $user = $request->user();
        $brocker = Brocker::where('user_id', $user->id)->first();
        $leads = Lead::where('brocker_id', $brocker->id)->get();

        return response()->json(['message' => 'Success', 'data' => $leads], 200);
    }
}
