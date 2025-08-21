<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentMarksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->role_id == 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'result_type_id' => 'required|exists:result_types,id',
            'session_id' => 'required|exists:school_sessions,id',
            'marks' => 'required|array|min:1',
            'marks.*.student_id' => 'required|exists:users,id',
            'marks.*.obtained_marks' => 'required|numeric|min:0|max:100',
            'marks.*.total_marks' => 'required|numeric|min:1|max:100',
            'marks.*.remarks' => 'nullable|string|max:255',
            'exam_date' => 'required|date|before_or_equal:today'
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
            'class_id.required' => 'Please select a class',
            'subject_id.required' => 'Please select a subject',
            'result_type_id.required' => 'Please select exam type',
            'session_id.required' => 'Please select academic session',
            'marks.required' => 'Please enter marks for at least one student',
            'marks.*.obtained_marks.max' => 'Obtained marks cannot exceed 100',
            'marks.*.total_marks.max' => 'Total marks cannot exceed 100',
            'exam_date.before_or_equal' => 'Exam date cannot be in the future'
        ];
    }

    /**
     * Custom validation logic
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $marks = $this->input('marks', []);
            
            foreach ($marks as $index => $mark) {
                if (isset($mark['obtained_marks']) && isset($mark['total_marks'])) {
                    if ($mark['obtained_marks'] > $mark['total_marks']) {
                        $validator->errors()->add(
                            "marks.{$index}.obtained_marks",
                            'Obtained marks cannot exceed total marks'
                        );
                    }
                }
            }
        });
    }
}