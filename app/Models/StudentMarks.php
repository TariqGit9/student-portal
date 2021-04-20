<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentMarks extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo('App\Models\User', 'student_id', 'id')->withTrashed();
    }
}
