<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentRequest extends FormRequest
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
            'registration_id' => 'required|string|max:50|unique:student_details,registration_id',
            'roll_no' => 'required|string|max:50',
            'father_name' => 'required|string|max:255',
            'father_cnic' => 'required|string|regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/|unique:student_details,father_cnic',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|string|regex:/^[0-9]{11}$/|unique:student_details,phone',
            'father_phone' => 'nullable|string|regex:/^[0-9]{11}$/',
            'address' => 'required|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'class_id' => 'required|exists:classes,id',
            'admission_date' => 'required|date|before_or_equal:today',
            'monthly_fee' => 'required|numeric|min:0|max:999999.99',
            'emergency_contact' => 'nullable|string|regex:/^[0-9]{11}$/',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'medical_conditions' => 'nullable|string|max:1000'
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
            'name.required' => 'Student name is required',
            'email.unique' => 'This email address is already registered',
            'user_name.unique' => 'This username is already taken',
            'registration_id.unique' => 'This registration ID is already assigned',
            'father_cnic.regex' => 'Father CNIC must be in format: 12345-1234567-1',
            'father_cnic.unique' => 'This father CNIC is already registered',
            'phone.regex' => 'Phone number must be 11 digits',
            'phone.unique' => 'This phone number is already registered',
            'date_of_birth.before' => 'Date of birth must be in the past',
            'class_id.required' => 'Please select a class',
            'class_id.exists' => 'Selected class does not exist',
            'admission_date.before_or_equal' => 'Admission date cannot be in the future',
            'avatar.max' => 'Avatar image must not exceed 2MB'
        ];
    }
}