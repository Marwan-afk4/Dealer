<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class FavouritesController extends Controller
{


    public function getFavourites(Request $request){
    $user = $request->user();

    $unitsFavourite = Favourite::with('uptown.unitimages')
        ->where('type', 'unit')
        ->where('user_id', $user->id)
        ->get()
        ->map(function ($favourite) {
            return [
                'id' => $favourite->id,
                'unit_id' => $favourite->uptown->id,
                'compound_id' => $favourite->uptown->compound_id,
                'name' => $favourite->uptown->name,
                'description' => $favourite->uptown->description,
                'space' => $favourite->uptown->space,
                'bathroom' => $favourite->uptown->bathroom,
                'bed' => $favourite->uptown->bed,
                'price' => $favourite->uptown->strat_price,
                'commission_price' => $favourite->uptown->commission_price,
                'sale_type' => $favourite->uptown->sale_type,
                'master_plan_image' => $favourite->uptown->master_plan_image,
                'images' => $favourite->uptown->unitimages->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'uptown_id' => $image->uptown_id,
                        'image' => $image->image
                    ];
                }),
                'floor_plan_image' => $favourite->uptown->floor_plan_image,
                'status' => $favourite->uptown->status,
            ];
        });

    $compoundsFavourite = Favourite::with('compound')
        ->where('type', 'compound')
        ->where('user_id', $user->id)
        ->get()
        ->map(function ($favourite) {
            return [
                'id' => $favourite->id,
                'compound_id' => $favourite->compound->id,
                'developer_id' => $favourite->compound->developer_id,
                'name' => $favourite->compound->compound_name,
                'units' => $favourite->compound->units,
                'image' => $favourite->compound->image,
                'commission_percentage' => $favourite->compound->commission_percentage,
            ];
        });

    $data = [
        'units' => $unitsFavourite,
        'compounds' => $compoundsFavourite,
    ];

    return response()->json($data);
}


    public function addFavourite(Request $request){
        $user = $request->user();
        $validation = Validator::make($request->all(), [
            'uptown_id' => 'nullable|exists:uptowns,id',
            'compound_id' => 'nullable|exists:compounds,id',
        ]);
        if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $type = null;
        if($request->uptown_id){
            $type = 'unit';
        }else if($request->compound_id){
            $type = 'compound';
        }

        if(is_null($type)){
            return response()->json(['errors' => 'uptown_id or compound_id is required'], 422);
        }

        $favourite = Favourite::create([
            'user_id' => $user->id,
            'uptown_id' => $request->uptown_id ?? null,
            'compound_id' => $request->compound_id ?? null,
            'type'=>$type
        ]);
        return response()->json(['message' => 'Favourite Added Successfully']);
    }

    public function deleteFavourite($id){
        $favourite = Favourite::find($id);
        $favourite->delete();
        return response()->json(['message' => 'Favourite Deleted Successfully']);
    }
}
