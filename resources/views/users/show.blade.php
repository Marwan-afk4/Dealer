@extends('layouts.app')
@php
	$currentPage = 'users';
@endphp
@section('title', $user->name)
@section('content')
<div class="container-fluid">
	<h1>{{ $user->name }}</h1>
	<div class="mb-3">
		<a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm me-1"> <i class="fa fa-arrow-right"></i> {{__('Back to')}} {{__('Users')}}</a>
		<a href='{{ route('users.edit', $user) }}' class="btn btn-warning btn-sm me-1">{{ __('Edit') }} <i class="fa fa-edit"></i></a>
		{{-- <a href="{{ route('users.complaints', $user) }}" class="list-group-item">{{ __('complaint') }}</a> --}}
		{{-- <a href="{{ route('users.brockers', $user) }}" class="list-group-item">{{ __('brocker') }}</a> --}}
		{{-- <a href="{{ route('users.payments', $user) }}" class="list-group-item">{{ __('payment') }}</a> --}}
		{{-- <a href="{{ route('users.trainings', $user) }}" class="list-group-item">{{ __('training') }}</a> --}}
		{{-- <a href="{{ route('users.contracts', $user) }}" class="list-group-item">{{ __('contract') }}</a> --}}
	</div>
	<div class="card">
		<div class="card-body">
			<ul class="list-group list-group-flush">
				<li class="list-group-item">
					<strong>{{ __("Id") }}:</strong> {{ $user->id }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("First Name") }}:</strong> {{ $user->first_name }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Last Name") }}:</strong> {{ $user->last_name }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Email") }}:</strong> {{ $user->email }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Phone") }}:</strong> {{ $user->phone }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Age") }}:</strong> {{ $user->age }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Provider") }}:</strong> {{ $user->provider }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Provider") }}:</strong> {{ $user->provider?->name }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Role") }}:</strong> {{ $user->role }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Plan") }}:</strong> {{ $user->plan?->name }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Status") }}:</strong> {{ $user->status }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Created At") }}:</strong> {{ $user->created_at }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Updated At") }}:</strong> {{ $user->updated_at }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Qualification") }}:</strong> {{ $user->qualification }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Experience Year") }}:</strong> {{ $user->experience_year }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Governce") }}:</strong> {{ $user->governce }}
				</li>
				<li class="list-group-item">
					<strong>{{ __("Google") }}:</strong> {{ $user->google?->name }}
				</li>
			</ul>
		</div>
	</div>
	<div class="mt-3">
		{{-- <form method='POST' action='{{ route('users.destroy', $user) }}' onsubmit='return confirm("Are you sure you want to delete this item?")'>
			<input type='hidden' name='_method' value='DELETE'>
			<button type='submit' class="btn btn-square btn-danger">{{ __('Delete') }}</button>
		</form> --}}
	</div>
</div>
@endsection