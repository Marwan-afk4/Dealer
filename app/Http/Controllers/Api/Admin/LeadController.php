<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brocker;
use App\Models\Lead;
use App\Models\MarketingAgency;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{


    public function getleads(){
        $leads = Lead::all();
        $data = $leads->map(function ($lead) {
            return [
                'lead_id' => $lead->id,
                'lead_name' => $lead->lead_name,
                'lead_phone' => $lead->lead_phone,
                'lead_status' => $lead->status,
                'marketing_agency_id'=> $lead->marketing_agency_id,
                'marketing_agency_name' => $lead->marketing_agency->name,
                'unit_id' => $lead->uptown_id,
                'unit_name' => $lead->uptown->name,
                'brocker_id' => $lead->brocker_id,
                'brocker_name' => $lead->brocker->user->first_name.' '.$lead->brocker->user->last_name,
                'brocker_start_date' => $lead->brocker_start_date,
                'brocker_end_date' => $lead->brocker_end_date,
                'sales_man_name' => $lead->sales_man_name,
                'sales_man_phone' => $lead->sales_man_phone
            ];
        });
        return response()->json(['leads'=>$data]);
    }

    public function deleteLead($id){
        $lead = Lead::find($id);
        $lead->delete();
        return response()->json(['message'=>'Lead deleted successfully']);
    }

    public function AddLead(Request $request){
        $validation = Validator::make($request->all(), [
            'marketing_agency_id' => 'required|exists:marketing_agencies,id',
            'brocker_id' => 'required|exists:brockers,id',
            'uptown_id' => 'required|exists:units,id',
            'lead_name' => 'required',
            'lead_phone' => 'required',
            'brocker_start_date' => 'nullable|date',
            'brocker_end_date' => 'nullable|date',
            'sales_man_name' => 'nullable',
            'sales_man_phone' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 401);
        }
        $lead = Lead::create([
            'marketing_agency_id' => $request->marketing_agency_id,
            'brocker_id' => $request->brocker_id,
            'uptown_id' => $request->uptown_id,
            'lead_name' => $request->lead_name,
            'lead_phone' => $request->lead_phone,
            'brocker_start_date' => $request->brocker_start_date,
            'brocker_end_date' => $request->brocker_end_date,
            'sales_man_name' => $request->sales_man_name,
            'sales_man_phone' => $request->sales_man_phone
        ]);
        return response()->json(['message'=>'Lead added successfully']);
    }

    public function getIDS(){
        $marketing_agencies = MarketingAgency::all();
        $brockers = Brocker::all();
        $units = Uptown::all();

        $data=[
            'marketing_agencies'=>$marketing_agencies,
            'brockers'=>$brockers,
            'units'=>$units
        ];
        return response()->json($data);
    }
}
