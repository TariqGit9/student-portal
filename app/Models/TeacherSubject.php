<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherSubject extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    public function teacher_details()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

}
