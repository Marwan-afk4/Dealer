<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Lead;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function homepage() {
        $developers = Developer::all();
        $requests = ModelsRequest::all();
        $leadPending =Lead::where('status','pending')->get();
        $leadClosed=Lead::where('status','closed')->get();
        $leadInprogress=Lead::where('status','in_progress')->get();
        $leadLost=Lead::where('status','lost')->get();
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
        $leadClosed_count=$leadClosed->count();
        $leadInprogress_count=$leadInprogress->count();
        $leadLost_count=$leadLost->count();
        $leadPending_count=$leadPending->count();

        $data=[
            'developers_count'=>$developers_count,
            'requests_count'=>$requests_count,
            'users_count'=>$users_count,
            'brockers_count'=>$brockers_count,
            'admins_count'=>$admins_count,
            'trianers_count'=>$trianers_count,
            'leadClosed_count'=>$leadClosed_count,
            'leadInprogress_count'=>$leadInprogress_count,
            'leadLost_count'=>$leadLost_count,
            'leadPending_count'=>$leadPending_count
        ];

        return response()->json($data);

    }
}
