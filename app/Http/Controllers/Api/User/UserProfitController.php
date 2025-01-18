<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Lead;
use App\Models\TransactionDeal;
use Illuminate\Http\Request;

class UserProfitController extends Controller
{

    public function ProfitwithLeads(Request $request){
        $user = $request->user();
        $brocker = Brocker::where('user_id', $user->id)->first();
        $leads = Lead::where('brocker_id', $brocker->id)->get();

        return response()->json(['leads' => $leads], 200);
    }

    public function dealsDone(Request $request){
        $user = $request->user();
        $brocker = Brocker::where('user_id', $user->id)->first();
        if (!$brocker) {
            return response()->json(['message' => 'Brocker not found'], 404);
        }
        $dealsDone = TransactionDeal::with(['lead'])
        ->where('brocker_id', $brocker->id)
        ->where('status', 'approved')
        ->get();

        $dealwithProfit = $dealsDone->map(function ($deal) use ($brocker) {
            $unit = $deal->uptown;
            $profit = $brocker->comission_percentage * $unit->commission_price / 100;
            return [
                'id' => $deal->id,
                'lead' => $deal->lead->lead_name,
                'unit' => $unit->id,
                'profit' => $profit
            ];
        });

        return response()->json(['dealsDone' => $dealwithProfit], 200);

    }

    public function Profit_Sales(Request $request){
    $user = $request->user();
    $brocker = Brocker::where('user_id', $user->id)->first();

    if (!$brocker) {
        return response()->json(['message' => 'Broker not found'], 404);
    }

    $deals = TransactionDeal::where('brocker_id', $brocker->id)->with(['uptown', 'brocker'])->get();
    $totalRevenue = $deals->sum(function ($deal) {
        $unitCommissionPrice = $deal->uptown->commission_price ?? 0;
        $brockercommission = $deal->brocker->comission_percentage ?? 0;
        return $unitCommissionPrice - $brockercommission;
    });

    return response()->json([
        'profit' => $brocker->profit,
        'dealer_profit' => $totalRevenue
    ], 200);
}


}
