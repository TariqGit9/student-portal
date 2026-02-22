<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherAttendanceDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id')->withTrashed();
    }

    public function teacher_attendance()
    {
        return $this->belongsTo(TeacherAttendance::class, 'teacher_attendance_id', 'id');
    }
}
