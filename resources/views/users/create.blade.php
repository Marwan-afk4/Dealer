@extends('layouts.app')
@php
	$currentPage = 'users';
@endphp
@section('title', __('Create User'))
@section('content')
<div class="container">
	<h1>{{ __('Create User') }}</h1>
	<div class="mb-3">
		<a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm me-1"> <i class="fa fa-arrow-right"></i> {{__('Back to')}} {{__('Users')}}</a>
	</div>
	<div class="main-card mb-3 card">
		<div class="card-body">
			<form method='POST' action='{{ route('users.store') }}' class='needs-validation' novalidate>
				@csrf
				<x-form-input 
					name="first_name"
					type="text"
					label="{{__('First Name')}}"
					required
				/>
				<x-form-input 
					name="last_name"
					type="text"
					label="{{__('Last Name')}}"
					required
				/>
				<x-form-input 
					name="email"
					type="text"
					label="{{__('Email')}}"
					required
				/>
				<x-form-input 
					name="phone"
					type="text"
					label="{{__('Phone')}}"
					required
				/>
				<x-form-input 
					name="age"
					type="text"
					label="{{__('Age')}}"
				/>
				<x-form-input 
					name="provider"
					type="text"
					label="{{__('Provider')}}"
					required
				/>
				<x-form-select 
					name="provider_id"
					type="select"
					label="{{__('Provider')}}"
					required
					:options="$providers"
				/>
				<x-form-input 
					name="role"
					type="text"
					label="{{__('Role')}}"
					required
				/>
				<x-form-select 
					name="plan_id"
					type="select"
					label="{{__('Plan')}}"
					:options="$plans"
				/>
				<x-form-input 
					name="status"
					type="text"
					label="{{__('Status')}}"
					required
				/>
				<x-form-input 
					name="qualification"
					type="text"
					label="{{__('Qualification')}}"
				/>
				<x-form-input 
					name="experience_year"
					type="text"
					label="{{__('Experience Year')}}"
					required
				/>
				<x-form-input 
					name="governce"
					type="text"
					label="{{__('Governce')}}"
				/>
				<x-form-select 
					name="google_id"
					type="select"
					label="{{__('Google')}}"
					:options="$googles"
				/>
				<button type='submit' class="btn btn-primary btn-sm me-1">{{ __('Add') }}</button>
			</form>
		</div>
	</div>
</div>@endsection