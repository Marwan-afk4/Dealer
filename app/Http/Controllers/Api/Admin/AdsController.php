<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function getAds() {
        $Ad=Ad::all();
        return response()->json(['Ads'=>$Ad]);
    }

    public function addAdds(Request $request) {
        $validate=Validator::make($request->all(),[
            'title'=>'nullable',
            'image'=>'required'
        ]);
        if($validate->fails()){
            return response()->json(['error'=>$validate->errors()],401);
        }

        $Ad=Ad::create([
            'title'=>$request->title,
            'image'=>$request->image
        ]);
        return response()->json(['message'=>'Ad added successfully','Ad'=>$Ad]);
    }

    public function deleteAds($id){
        $Ad=Ad::find($id);
        $Ad->delete();
        return response()->json(['message'=>'Ad deleted successfully']);
    }
}
