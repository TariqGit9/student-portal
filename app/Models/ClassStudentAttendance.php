<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClassStudentAttendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo('App\Models\User', 'student_id', 'id')->withTrashed();
    }
    public function class_attendance()
    {
        return $this->belongsTo('App\Models\ClassAttendance', 'attendance_id', 'id');
    }
}
