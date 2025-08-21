<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->role_id == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_name' => 'required|string|max:255|unique:users,user_name',
            'password' => 'required|string|min:8|confirmed',
            'cnic' => 'required|string|regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/|unique:teacher_details,cnic',
            'qualification' => 'required|string|max:255',
            'experience' => 'required|integer|min:0|max:50',
            'phone' => 'required|string|regex:/^[0-9]{11}$/|unique:teacher_details,phone',
            'address' => 'required|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subject_ids' => 'required|array|min:1',
            'subject_ids.*' => 'exists:subjects,id',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:classes,id'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Teacher name is required',
            'email.unique' => 'This email address is already registered',
            'user_name.unique' => 'This username is already taken',
            'cnic.regex' => 'CNIC must be in format: 12345-1234567-1',
            'cnic.unique' => 'This CNIC is already registered',
            'phone.regex' => 'Phone number must be 11 digits',
            'phone.unique' => 'This phone number is already registered',
            'subject_ids.required' => 'Please select at least one subject',
            'class_ids.required' => 'Please assign at least one class',
            'avatar.max' => 'Avatar image must not exceed 2MB'
        ];
    }
}