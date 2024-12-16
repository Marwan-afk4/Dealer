<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compound;
use App\Models\Developer;
use App\Models\UnitsImage;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    protected $updateUptown =['name','apparment','space','bathroom','bed','strat_price','delivery_date','sale_type','master_plan_image','floor_plan_image'];

    public function unitDeveloper($compound_id){
        $compound = Compound::find($compound_id);
        $compoundUptownCount = Uptown::where('compound_id', $compound_id)->count();
        $units = Uptown::where('compound_id', $compound_id)
        ->with('unitImages')
        ->get();
        $compound->update(['units'=>$compoundUptownCount]);


        $data = [
            'units'=>$compoundUptownCount,
            'units_data'=>$units
        ];

        return response()->json($data);

    }

    public function addUptown(Request $request,$compound_id){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'apparment' => 'required',
            'space' => 'required|integer',
            'bathroom' => 'required|integer',
            'bed' => 'required|integer',
            'strat_price' => 'required|integer',
            'delivery_date' => 'nullable|date',
            'sale_type' => 'required',
            'master_plan_image' => 'nullable',
            'floor_plan_image' => 'nullable',
            'images' => 'nullable|array',
            'images.*' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        $uptown = Uptown::create([
            'compound_id' => $compound_id,
            'name' => $request->name,
            'apparment' => $request->apparment,
            'space' => $request->space,
            'bathroom' => $request->bathroom,
            'bed' => $request->bed,
            'strat_price' => $request->strat_price,
            'delivery_date' => $request->delivery_date,
            'sale_type' => $request->sale_type,
            'master_plan_image' => $request->master_plan_image,
            'floor_plan_image' => $request->floor_plan_image
        ]);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                UnitsImage::create([
                    'uptown_id' => $uptown->id,
                    'image' => $image['image'],
                ]);
            }
        }
        $this->updatecompoundUnit($compound_id);

        return response()->json(['message' => 'Unit added successfully', 'uptown' => $uptown]);

    }

    public function updatecompoundUnit($compound_id){
        $unitcount=Uptown::where('compound_id', $compound_id)->count();
        $compound=Compound::find($compound_id);
        $compound->update(['units'=>$unitcount]);
    }

    public function deleteUptown($id){
        $uptown = Uptown::find($id);
        $uptown->delete();
        return response()->json(['message'=>'Unit Deleted Successfully']);
    }

    public function updateUptown(Request $request,$id){
        $uptown = Uptown::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => 'nullable',
            'apparment' => 'nullable',
            'space' => 'nullable|integer',
            'bathroom' => 'nullable|integer',
            'bed' => 'nullable|integer',
            'strat_price' => 'nullable|integer',
            'delivery_date' => 'nullable|date',
            'sale_type' => 'nullable',
            'master_plan_image' => 'nullable',
            'floor_plan_image' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $uptown->update($request->only($this->updateUptown));
        return response()->json(['message'=>'Unit Updated Successfully']);
    }

    public function DeleteUptownImage($id){
        $uptownImage = UnitsImage::find($id);
        $uptownImage->delete();
        return response()->json(['message'=>'Unit Image Deleted Successfully']);
    }

    //UPTOWN   , UPDATE
}
