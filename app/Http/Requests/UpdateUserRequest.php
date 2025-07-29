<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'provider' => 'required',
            'provider_id' => 'exists:providers,id',
            'role' => 'required',
            'qualification' => 'required',
            'experience_year' => 'required',
            'governce' => 'required',
            'age' => 'required',
            'plan_id' => 'exists:plans,id',
            'google_id' => 'exists:googles,id'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('The First Name field is required.'),
            'last_name.required' => __('The Last Name field is required.'),
            'email.required' => __('The Email field is required.'),
            'phone.required' => __('The Phone field is required.'),
            'password.required' => __('The Password field is required.'),
            'provider.required' => __('The Provider field is required.'),
            'provider_id.exists' => __('The selected Provider is invalid.'),
            'role.required' => __('The Role field is required.'),
            'qualification.required' => __('The Qualification field is required.'),
            'experience_year.required' => __('The Experience Year field is required.'),
            'governce.required' => __('The Governce field is required.'),
            'age.required' => __('The Age field is required.'),
            'plan_id.exists' => __('The selected Plan is invalid.'),
            'google_id.exists' => __('The selected Google is invalid.')
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new ValidationException($validator, response()->json([
                'status' => 'error',
                'message' => __('Validation failed'),
                'errors' => $validator->errors()
            ]));
        }

        throw new ValidationException($validator);
    }
}
