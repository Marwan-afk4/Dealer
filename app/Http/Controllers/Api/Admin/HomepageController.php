<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Complaint;
use App\Models\Contract;
use App\Models\Developer;
use App\Models\Payment;
use App\Models\Plan;
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

        $totalRevenue = TransactionDeal::all()
        ->sum(function ($deal) {
            $unitCommissionPrice = $deal->uptown->commission_price ?? 0; // Ensure unit exists
            $brockerProfit = $deal->brocker->profit ?? 0; // Ensure brocker exists
            return $unitCommissionPrice - $brockerProfit;
        });





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
            'total_revenue' => $totalRevenue
        ]);
    }

    public function getMostPlan()
    {
        $payments = Payment::where('status', 'approved')->get();
        $countPlanId = $payments->countBy('plan_id');

        $data = [];
        foreach ($countPlanId as $planId => $count) {
            $plan = Plan::find($planId);
            if ($plan) {
                $data[] = [
                    'plan_name' => $plan->name,
                    'plan_price' => $plan->price_after_discount,
                    'total_amount' => $count * $plan->price_after_discount
                ];
            }
        }

        return response()->json(['most_plans' => $data]);
    }
}
