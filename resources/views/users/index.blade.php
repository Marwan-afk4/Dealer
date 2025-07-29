@extends('layouts.app')
@php
	$currentPage = 'users';
@endphp
@section('title', __('Users'))
@section('content')
<div class="container-fluid">
	<h1 class="mb-3">{{__('Users')}}</h1>
	<div class="mb-3 d-flex justify-content-between align-items-center">
		<a href="{{ route('users.create') }}" class="btn btn-primary btn-sm me-1">{{__('Create User')}} <i class="fa fa-plus"></i></a>
		<div class="search-wrapper">
			<form action="{{ route(Route::currentRouteName(), [], false) }}" method="GET">
				<div class="input-group">
					@if(request()->query()) 
						<a class="btn btn-secondary" href="{{ route(Route::currentRouteName(), [], false) }}">
							<i class="fa fa-times"></i>
						</a>
					@endif

					<select name="plan_id" class="form-select" onchange="this.form.submit()">
						<option value="">-- {{ __('Plans') }} --</option>
						@foreach($plans as $planKey=> $plan)
						<option value="{{ $planKey }}" {{ request('plan_id') == $planKey ? 'selected' : '' }}>{{ $plan }}</option>
						@endforeach
					</select>
					<input type="text" name="keyword" class="form-control" placeholder="{{ __('Keyword...') }}" value="{{ request('keyword') }}">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</div>
	</div>
	<div class='main-card mb-3 card'>
		<div class='card-body'>
			<table class="mb-0 table table-hover">
				<tr>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('id'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Id") }}
							@if($sortField === 'id')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'first_name', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('first_name'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("First Name") }}
							@if($sortField === 'first_name')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'last_name', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('last_name'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Last Name") }}
							@if($sortField === 'last_name')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('email'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Email") }}
							@if($sortField === 'email')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'phone', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('phone'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Phone") }}
							@if($sortField === 'phone')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'age', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('age'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Age") }}
							@if($sortField === 'age')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'provider', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('provider'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Provider") }}
							@if($sortField === 'provider')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'provider_id', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('provider_id'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Provider") }}
							@if($sortField === 'provider_id')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'role', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('role'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Role") }}
							@if($sortField === 'role')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'plan_id', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('plan_id'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Plan") }}
							@if($sortField === 'plan_id')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('status'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Status") }}
							@if($sortField === 'status')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('created_at'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Created At") }}
							@if($sortField === 'created_at')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'qualification', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('qualification'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Qualification") }}
							@if($sortField === 'qualification')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'experience_year', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('experience_year'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Experience Year") }}
							@if($sortField === 'experience_year')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'governce', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('governce'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Governce") }}
							@if($sortField === 'governce')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th>
						<a href="{{ request()->fullUrlWithQuery(['sort' => 'google_id', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
							@if(request()->filled('google_id'))<i class="fas fa-filter text-danger"></i>@endif
							{{ __("Google") }}
							@if($sortField === 'google_id')<i class="text-primary">{{ $sortOrder === 'asc' ? '▼' : '▲' }}</i>@endif
						</a>
					</th>
					<th class="text-center">{{ __('Actions') }}</th>
				</tr>
				@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->first_name }}</td>
					<td>{{ $user->last_name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->phone }}</td>
					<td>{{ $user->age }}</td>
					<td>{{ $user->provider }}</td>
					<td>{{ $user->provider_id }}</td>
					<td>{{ $user->role }}</td>
					<td>
						@if ($user->plan)
							<a href='{{ route('plans.show', $user->plan) }}'>
								{{$user->plan?->name ?? '' }}
							</a>
						@endif
					</td>
					<td>{{ $user->status }}</td>
					<td>{{ $user->created_at }}</td>
					<td>{{ $user->qualification }}</td>
					<td>{{ $user->experience_year }}</td>
					<td>{{ $user->governce }}</td>
					<td>{{ $user->google_id }}</td>
					<td class="text-center">
						<a href='{{ route('users.show', $user) }}' class="btn btn-subtle-primary btn-sm me-1">{{ __("Details") }} <i class="fa fa-eye"></i></a>
						<a href='{{ route('users.edit', $user) }}' class="btn btn-subtle-warning btn-sm me-1">{{ __("Edit") }} <i class="fa fa-edit"></i></a>
						{{-- <form method='POST' action='{{ route('users.destroy', $user) }}' onsubmit='return confirm("Are you sure you want to delete this item?")'>
							<input type='hidden' name='_method' value='DELETE'>
							<button type='submit' class="btn btn-square btn-danger">{{ __('Delete') }}</button>
						</form> --}}
					</td>
				</tr>
				@endforeach
			</table>
			{{ $users->links('pagination::custom') }}
		</div>
	</div>
</div>
@endsection