<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Uptown;
use Illuminate\Http\Request;

class UnitController extends Controller
{

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
    //UPTOWN ADD , DELETE , UPDATE
}
