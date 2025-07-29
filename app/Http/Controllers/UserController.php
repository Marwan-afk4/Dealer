<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;


use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'ASC');
        $users = User::with(['plan'])
			->when(request('plan_id'), function ($query) {
				$query->where('plan_id', request('plan_id'));
			})
			->orderBy($sortField, $sortOrder)->paginate(30);

        $plans = Plan::orderBy('name')->pluck('name', 'id')->toArray();
        
        return view('users.index', compact('users','sortField','sortOrder','plans'));
    }

    public function create()
    {
        $plans = Plan::orderBy('name')->pluck('name', 'id')->toArray();
        return view('users.create', compact('plans'));
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('users.index')->with('success', 'Created successfully');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $plans = Plan::orderBy('name')->pluck('name', 'id')->toArray();
        return view('users.edit', compact('user','plans'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('users.index')->with('success', 'Updated successfully.');
    }
}
