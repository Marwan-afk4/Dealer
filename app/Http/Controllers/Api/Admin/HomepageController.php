<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function homepage() {
        $developers = Developer::all();
        $requests = ModelsRequest::all();
        $users = User::where('role','user')->get();
        $brockers=User::where('role','brocker')->get();
        $admins=User::where('role','admin')->get();
        $trianers=User::where('role','trainer')->get();

        $developers_count = $developers->count();
        $requests_count = $requests->count();
        $users_count = $users->count();
        $brockers_count=$brockers->count();
        $admins_count=$admins->count();
        $trianers_count=$trianers->count();

        $data=[
            'developers_count'=>$developers_count,
            'requests_count'=>$requests_count,
            'users_count'=>$users_count,
            'brockers_count'=>$brockers_count,
            'admins_count'=>$admins_count,
            'trianers_count'=>$trianers_count,
        ];

        return response()->json($data);

    }
}
