<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compound;
use App\Models\Developer;
use App\Models\DeveloperSalesman;
use App\Models\Place;
use App\Models\SalesDeveloper;
use App\Models\Uptown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeveloperControlelr extends Controller
{
    protected $updateDeveloper = ['name','email','start_date','end_date','image'];


    public function AllDevelopers(){
        $developer =Developer::all();
        return response()->json(['developers'=>$developer]);
    }

    public function developer($id){
        $developer = Developer::with('place','sales_developer')->findOrFail($id);

        $developerCompounds=Compound::where('developer_id',$id)->get();

        return response()->json([
            'developer'=>$developer,
            'developerCompounds'=>$developerCompounds
        ]);

        // $developer = Developer::with('place')->findOrFail($id);
        // //uptown units with this develpoer
        // $uptownRelated = Uptown::where('developer_id', $id)->get();
        // $uptownTotalprofit = Uptown::where('developer_id', $id)
        // ->where('status', 'sold')
        // ->sum('strat_price');
        // $developer->update(['total_profit'=>$uptownTotalprofit]);
        // return response()->json([
        //     'start_date'=>$developer->start_date,
        //     'end_date'=>$developer->end_date,
        //     'total_profit'=>$uptownTotalprofit,
        //     'deals_done'=>$developer->deals_done,
        //     'total_deals'=>$developer->total_deals,
        //     'places'=>$developer->place->map(function($place){
        //         return [
        //             'id'=>$place->id,
        //             'place'=>$place->place,
        //             'developer_id'=>$place->developer_id
        //         ];
        //     }),
        //     'sales_man'=>$developer->sales_developer->map(function($sales_man){
        //         return [
        //             'id'=>$sales_man->id,
        //             'name'=>$sales_man->sale_name,
        //             'phone'=>$sales_man->sale_phone
        //         ];
        //     }),
        //     'units_list'=>$uptownRelated
        // ]);
    }

    public function addDeveloper(Request $request){
        $Valiation = Validator::make($request->all(),[
            'name'=>'required|unique:developers,name',
            'email'=>'nullable|unique:developers,email',
            'start_date'=>'nullable|date',
            'end_date'=>'required|date',
            'image'=>'nullable',
            'sales_man' =>'required|array',
            'sales_man.*.name'=>'required',
            'sales_man.*.phone'=>'required',
            'places'=>'required|array',
            'places.*.place'=>'required',
        ]);
        if($Valiation->fails()){
            return response()->json(['error'=>$Valiation->errors()],401);
        }
        $developer = Developer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'image'=>$request->image,
        ]);
        foreach($request->places as $place){
            Place::create([
                'place'=>$place['place'],
                'developer_id'=>$developer->id
            ]);
        }
        foreach($request->sales_man as $sales_man){
            SalesDeveloper::create([
                'developer_id'=>$developer->id,
                'sale_name'=>$sales_man['name'],
                'sale_phone'=>$sales_man['phone']
            ]);
        }
        return response()->json(['message'=>'Developer Added Successfully']);
    }

    public function updateDeveloper(Request $request, $id)
{
    $developer = Developer::findOrFail($id);

    // Validate the incoming request
    $validation = Validator::make($request->all(), [
        'name' => 'sometimes|required|unique:developers,name,' . $id,
        'email' => 'sometimes|required|email|unique:developers,email,' . $id,
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'image' => 'nullable',
        'places' => 'nullable|array',
        'places.*.id' => 'nullable|exists:places,id', // Ensure valid place IDs if provided
        'places.*.place' => 'required|string',
        'sales_man' => 'nullable|array',
        'sales_man.*.id' => 'nullable|exists:sales_developers,id', // Ensure valid sales IDs if provided
        'sales_man.*.name' => 'required|string',
        'sales_man.*.phone' => 'required|string',
    ]);

    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors()], 422);
    }

    // Update the developer's basic information
    $developer->update($request->only(['name', 'email', 'start_date', 'end_date', 'image']));

    // Update places
    $existingPlaceIds = [];
    if ($request->has('places')) {
        foreach ($request->places as $placeData) {
            if (isset($placeData['id']) && $placeData['id']) {
                // Update existing place
                $place = $developer->place()->find($placeData['id']);
                if ($place) {
                    $place->update(['place' => $placeData['place']]);
                    $existingPlaceIds[] = $place->id;
                }
            } else {
                // Create new place
                $newPlace = $developer->place()->create(['place' => $placeData['place']]);
                $existingPlaceIds[] = $newPlace->id;
            }
        }
    }
    $developer->place()->whereNotIn('id', $existingPlaceIds)->delete();

    // Update sales developers
    $existingSalesIds = [];
    if ($request->has('sales_man')) {
        foreach ($request->sales_man as $salesMan) {
            if (isset($salesMan['id']) && $salesMan['id']) {
                // Update existing sales developer
                $salesDeveloper = $developer->sales_developer()->find($salesMan['id']);
                if ($salesDeveloper) {
                    $salesDeveloper->update([
                        'sale_name' => $salesMan['name'],
                        'sale_phone' => $salesMan['phone'],
                    ]);
                    $existingSalesIds[] = $salesDeveloper->id;
                }
            } else {
                // Create new sales developer
                $newSales = $developer->sales_developer()->create([
                    'sale_name' => $salesMan['name'],
                    'sale_phone' => $salesMan['phone'],
                ]);
                $existingSalesIds[] = $newSales->id;
            }
        }
    }
    $developer->sales_developer()->whereNotIn('id', $existingSalesIds)->delete();

    return response()->json([
        'message' => 'Developer updated successfully']);
}


    public function deleteDeveloper($id){
        $developer = Developer::find($id);
        $developer->delete();
        return response()->json(['message'=>'Developer Deleted Successfully']);
    }





}
