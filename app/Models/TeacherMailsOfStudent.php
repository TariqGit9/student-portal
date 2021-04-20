<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherMailsOfStudent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function teacher_details()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id', 'id')->withTrashed();
    }
    public function student_details()
    {
        return $this->belongsTo('App\Models\User', 'student_id', 'id')->withTrashed();
    }
    public function class_details()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id')->withTrashed();
    }
}
