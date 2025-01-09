<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Brocker;
use App\Models\User;
use Illuminate\Http\Request;

class HomePageController extends Controller
{

    public function homepage(Request $request){
        $user =$request->user();
        $ads= Ad::all();
        $brocker = null;
        if($user->role == 'brocker'){
            $brocker = Brocker::where('user_id',$user->id)->first();
        }
        return response()->json([
            'ads'=>$ads,
            'brocker'=>$brocker
        ]);
    }

    public function profile(Request $request){
        $user = $request->user();
        return response()->json([
            'user'=>$user
        ]);
    }
}
