<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class ClassAttendance extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    public function student_attendance()
    {
        return $this->hasMany('App\Models\ClassStudentAttendance', 'attendance_id', 'id');
    }
    public function login_student_attendance()
    {
        return $this->hasOne('App\Models\ClassStudentAttendance', 'attendance_id', 'id')->where('student_id',  Auth::user()->id);
    }

    public function subject_details()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id')->withTrashed();
    }
    public function class_details()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id')->withTrashed();
    }
    public function grade()
    {
        return $this->belongsTo('App\Models\ClassGrade');
    }

  
}
