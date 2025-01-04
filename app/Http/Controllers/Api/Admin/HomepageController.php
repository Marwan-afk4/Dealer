<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Complaint;
use App\Models\Contract;
use App\Models\Developer;
use App\Models\Request as ModelsRequest;
use App\Models\TrainingSubscription;
use App\Models\TransactionDeal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomepageController extends Controller
{


    public function homepage(Request $request){

        $filter = $request->input('filter', 'monthly');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($filter === 'yearly') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        $totalUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        $users = User::where('role', 'user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $brockers = User::where('role', 'brocker')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $trainers = User::where('role', 'trainer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();



        $totalDeals = TransactionDeal::whereBetween('created_at', [$startDate, $endDate])->count();

        $approvedDeals = TransactionDeal::where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $rejectedDeals = TransactionDeal::where('status', 'rejected')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $semidoneDeals = TransactionDeal::where('status', 'semidone')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pendingDeals = TransactionDeal::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $brocker = Brocker::all()->count();
        $developer = Developer::all()->count();
        $admin = User::where('role', 'admin')->get()->count();
        $complaint = Complaint::where('status', 'open')->get()->count();
        $triningRequest = TrainingSubscription::where('status', 'pending')->get()->count();
        $contracts = Contract::where('status', 'pending')->get()->count();

        return response()->json([
            'brocker' => $brocker,
            'developer' => $developer,
            'admin' => $admin,
            'complaint' => $complaint,
            'triningRequest' => $triningRequest,
            'contracts' => $contracts,
            'deals' => $totalDeals,
            'deals_status' => [
                'approved' => $approvedDeals,
                'rejected' => $rejectedDeals,
                'semidone' => $semidoneDeals,
                'pending' => $pendingDeals,
            ],
            'users' => $totalUsers,
            'user_roles' => [
                'user' => $users,
                'brocker' => $brockers,
                'trainer' => $trainers,
        ],

        ]);
    }
}
