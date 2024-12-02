<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function deleteuser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getAdmins()
    {
        $admins = User::where('role', 'admin')->get();
        return response()->json(['admins' => $admins]);
    }

    public function deleteadmin($id){
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }
}
