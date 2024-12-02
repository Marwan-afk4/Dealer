<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperControlelr extends Controller
{
    public function Developes_excist(){
        $developer =Developer::all();
        return response()->json(['developer'=>$developer]);
    }
}
