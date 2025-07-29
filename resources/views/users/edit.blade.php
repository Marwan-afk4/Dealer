@extends('layouts.app')
@php
	$currentPage = 'users';
@endphp
@section('title', __('Edit User'))
@section('content')
<div class="container">
	<h1>{{ __('Edit User') }}</h1>
	<div class="mb-3">
		<a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm me-1"> <i class="fa fa-arrow-right"></i> {{__('Back to')}} {{__('Users')}}</a>
		<a href='{{ route('users.show', $user) }}' class="btn btn-primary btn-sm me-1">{{ __("Details") }} <i class="fa fa-eye"></i></a>
		{{-- <a href="{{ route('users.complaints', $user) }}" class="list-group-item">{{ __('complaint') }}</a> --}}
		{{-- <a href="{{ route('users.brockers', $user) }}" class="list-group-item">{{ __('brocker') }}</a> --}}
		{{-- <a href="{{ route('users.payments', $user) }}" class="list-group-item">{{ __('payment') }}</a> --}}
		{{-- <a href="{{ route('users.trainings', $user) }}" class="list-group-item">{{ __('training') }}</a> --}}
		{{-- <a href="{{ route('users.contracts', $user) }}" class="list-group-item">{{ __('contract') }}</a> --}}
	</div>
	<div class="main-card mb-3 card">
		<div class="card-body">
			<form method='POST' action='{{ route('users.update', $user->id) }}' class='needs-validation' novalidate>
				@csrf
				@method('PUT')
				<x-form-input 
					name="first_name"
					type="text"
					label="{{__('First Name')}}"
					:value="$user->first_name ?? ''"
					required
				/>
				<x-form-input 
					name="last_name"
					type="text"
					label="{{__('Last Name')}}"
					:value="$user->last_name ?? ''"
					required
				/>
				<x-form-input 
					name="email"
					type="text"
					label="{{__('Email')}}"
					:value="$user->email ?? ''"
					required
				/>
				<x-form-input 
					name="phone"
					type="text"
					label="{{__('Phone')}}"
					:value="$user->phone ?? ''"
					required
				/>
				<x-form-input 
					name="age"
					type="text"
					label="{{__('Age')}}"
					:value="$user->age ?? ''"
				/>
				<x-form-input 
					name="provider"
					type="text"
					label="{{__('Provider')}}"
					:value="$user->provider ?? ''"
					required
				/>
				<x-form-select 
					name="provider_id"
					type="select"
					label="{{__('Provider')}}"
					:selected="$user->provider_id ?? ''"
					required
					:options="$providers"
				/>
				<x-form-input 
					name="role"
					type="text"
					label="{{__('Role')}}"
					:value="$user->role ?? ''"
					required
				/>
				<x-form-select 
					name="plan_id"
					type="select"
					label="{{__('Plan')}}"
					:selected="$user->plan_id ?? ''"
					:options="$plans"
				/>
				<x-form-input 
					name="status"
					type="text"
					label="{{__('Status')}}"
					:value="$user->status ?? ''"
					required
				/>
				<x-form-input 
					name="qualification"
					type="text"
					label="{{__('Qualification')}}"
					:value="$user->qualification ?? ''"
				/>
				<x-form-input 
					name="experience_year"
					type="text"
					label="{{__('Experience Year')}}"
					:value="$user->experience_year ?? ''"
					required
				/>
				<x-form-input 
					name="governce"
					type="text"
					label="{{__('Governce')}}"
					:value="$user->governce ?? ''"
				/>
				<x-form-select 
					name="google_id"
					type="select"
					label="{{__('Google')}}"
					:selected="$user->google_id ?? ''"
					:options="$googles"
				/>
				<button type='submit' class="btn btn-warning btn-sm me-1">{{ __('Save') }}</button>
			</form>
		</div>
	</div>
</div>
@endsection