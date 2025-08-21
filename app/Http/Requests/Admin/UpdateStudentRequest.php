<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
        $studentId = $this->route('student_id') ?? $this->input('student_id');
        
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($studentId)
            ],
            'user_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'user_name')->ignore($studentId)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'registration_id' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('student_details', 'registration_id')->where(function ($query) use ($studentId) {
                    return $query->where('user_id', '!=', $studentId);
                })
            ],
            'roll_no' => 'sometimes|required|string|max:50',
            'father_name' => 'sometimes|required|string|max:255',
            'father_cnic' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/',
                Rule::unique('student_details', 'father_cnic')->where(function ($query) use ($studentId) {
                    return $query->where('user_id', '!=', $studentId);
                })
            ],
            'date_of_birth' => 'sometimes|required|date|before:today',
            'gender' => 'sometimes|required|in:male,female,other',
            'phone' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[0-9]{11}$/',
                Rule::unique('student_details', 'phone')->where(function ($query) use ($studentId) {
                    return $query->where('user_id', '!=', $studentId);
                })
            ],
            'father_phone' => 'nullable|string|regex:/^[0-9]{11}$/',
            'address' => 'sometimes|required|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'class_id' => 'sometimes|required|exists:classes,id',
            'monthly_fee' => 'sometimes|required|numeric|min:0|max:999999.99',
            'emergency_contact' => 'nullable|string|regex:/^[0-9]{11}$/',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'medical_conditions' => 'nullable|string|max:1000',
            'status' => 'sometimes|required|in:0,1'
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
            'email.unique' => 'This email address is already registered',
            'user_name.unique' => 'This username is already taken',
            'registration_id.unique' => 'This registration ID is already assigned',
            'father_cnic.regex' => 'Father CNIC must be in format: 12345-1234567-1',
            'father_cnic.unique' => 'This father CNIC is already registered',
            'phone.regex' => 'Phone number must be 11 digits',
            'phone.unique' => 'This phone number is already registered',
            'date_of_birth.before' => 'Date of birth must be in the past',
            'class_id.exists' => 'Selected class does not exist',
            'avatar.max' => 'Avatar image must not exceed 2MB'
        ];
    }
}