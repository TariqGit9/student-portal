<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class TeacherAttendance extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    public function teacher_attendance_details()
    {
        return $this->hasMany(TeacherAttendanceDetail::class, 'teacher_attendance_id', 'id');
    }

    public function login_teacher_attendance()
    {
        return $this->hasOne(TeacherAttendanceDetail::class, 'teacher_attendance_id', 'id')
            ->where('teacher_id', Auth::user()->id);
    }

    public function marked_by_user()
    {
        return $this->belongsTo(User::class, 'marked_by', 'id')->withTrashed();
    }
}
