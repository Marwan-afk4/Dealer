<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    protected $updatePlans=['name','count_of_leads','period_in_days','price','discount_type','discount_value'];

    public function plans(){
        $plas= Plan::all();
        $data=[
            'plans'=>$plas
        ];
        return response()->json($data);
    }


    public function addplan(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'count_of_leads' => 'required|integer',
            'period_in_days' => 'required|integer',
            'price' => 'required',
            'discount_type' => 'nullable|in:fixed,percentage',
            'discount_value' => 'nullable|numeric',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 401);
        }
        $price_after_discount = $request->price_after_discount;
        if($request->discount_type == 'fixed') {
            $price_after_discount = $request->price - $request->discount_value;
        }elseif($request->discount_type == 'percentage') {
            $price_after_discount = $request->price - ($request->price * $request->discount_value / 100);
        }

        $plan = Plan::create([
            'name' => $request->name,
            'count_of_leads' => $request->count_of_leads,
            'period_in_days' => $request->period_in_days,
            'price' => $request->price,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'price_after_discount' => $price_after_discount
        ]);

        return response()->json(['message'=>'Plan Added Successfully']);

    }

    public function updateplan(Request $request,$id){
        $plan = Plan::find($id);
        $plan->update($request->only($this->updatePlans));
        return response()->json(['message'=>'Plan Updated Successfully']);
    }

    public function deleteplan($id){
        $plan = Plan::find($id);
        $plan->delete();
        return response()->json(['message'=>'Plan Deleted Successfully']);
    }


}
