<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAssessment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    public function student_marks()
    {
        return $this->hasMany('App\Models\StudentMarks', 'assesment_id', 'id');
    }
    public function subject_details()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id')->withTrashed();
    }
    public function class_details()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id')->withTrashed();
    }
    public function assessments_type()
    {
        return $this->belongsTo('App\Models\ResultType', 'type_id', 'id');
    }
    public function grade()
    {
        return $this->belongsTo('App\Models\ClassGrade');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\ResultType');
    }
    public function student_obt_marks()
    {
        return $this->hasOne('App\Models\StudentMarks', 'assesment_id', 'id')->first();
    }
}
