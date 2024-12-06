<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\UnitsImage;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    protected $updateUptown =['name','apparment','space','bathroom','bed','strat_price','delivery_date','sale_type'];

    public function unitDeveloper($developer_id){
        $developer = Developer::find($developer_id);
        $developerUptownCount = Uptown::where('developer_id', $developer_id)->count();
        $units = Uptown::where('developer_id', $developer_id)->get();
        $developer->update(['units'=>$developerUptownCount]);

        $data = [
            'units'=>$developerUptownCount,
            'units_data'=>$units
        ];

        return response()->json($data);

    }

    public function addUptown(Request $request,$developer_id){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'apparment' => 'required',
            'space' => 'required|integer',
            'bathroom' => 'required|integer',
            'bed' => 'required|integer',
            'strat_price' => 'required|integer',
            'delivery_date' => 'nullable|date',
            'sale_type' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        $uptown = Uptown::create([
            'developer_id' => $developer_id,
            'name' => $request->name,
            'apparment' => $request->apparment,
            'space' => $request->space,
            'bathroom' => $request->bathroom,
            'bed' => $request->bed,
            'strat_price' => $request->strat_price,
            'delivery_date' => $request->delivery_date,
            'sale_type' => $request->sale_type,
        ]);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                UnitsImage::create([
                    'uptown_id' => $uptown->id,
                    'image' => $image['image'],
                ]);
            }
        }

        return response()->json(['message' => 'Unit added successfully', 'uptown' => $uptown]);

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
