<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
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
        $teacherId = $this->route('teacher_id') ?? $this->input('teacher_id');
        
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($teacherId)
            ],
            'user_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'user_name')->ignore($teacherId)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'cnic' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/',
                Rule::unique('teacher_details', 'cnic')->where(function ($query) use ($teacherId) {
                    return $query->where('user_id', '!=', $teacherId);
                })
            ],
            'qualification' => 'sometimes|required|string|max:255',
            'experience' => 'sometimes|required|integer|min:0|max:50',
            'phone' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[0-9]{11}$/',
                Rule::unique('teacher_details', 'phone')->where(function ($query) use ($teacherId) {
                    return $query->where('user_id', '!=', $teacherId);
                })
            ],
            'address' => 'sometimes|required|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subject_ids' => 'sometimes|required|array|min:1',
            'subject_ids.*' => 'exists:subjects,id',
            'class_ids' => 'sometimes|required|array|min:1',
            'class_ids.*' => 'exists:classes,id',
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