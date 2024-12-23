<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\BrokerLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrokerController extends Controller
{


    public function addLeadtoBroker(Request $request, $id)
    {
        $broker = Brocker::find($id);
        $validation = Validator::make($request->all(), [
            'lead_id' => 'required|array',
            'lead_id.*.lead_id' => 'required|exists:leads,id|unique:broker_leads,lead_id',
            'lead_id.*.brocker_end_date' => 'required|date',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        foreach ($request->lead_id as $lead_id) {
            BrokerLead::create([
                'brocker_id' => $broker->id,
                'lead_id' => $lead_id['lead_id'],
                'brocker_end_date' => $lead_id['brocker_end_date']
            ]);
        }
        return response()->json(['message' => 'lead assigned successfully']);
    }
}
