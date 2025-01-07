<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Compound;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{


    public function GetDevloper(){
        $developer = Developer::all();
        return response()->json(['developers'=>$developer]);
    }

    public function getCompounds($developer_id){
        $compounds = Compound::where('developer_id', $developer_id)
        ->with('uptwons.unitimages')
        ->get();

        return response()->json(['compounds'=>$compounds]);
    }
}
