<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function grade()
    {
        return $this->belongsTo('App\Models\ClassGrade');
    }
    public function teacher_subject()
    {
        return $this->belongsTo('App\Models\TeacherSubject', 'id', 'subject_id');
    }


}
