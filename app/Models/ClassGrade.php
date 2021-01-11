<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClassGrade extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    public function subjects()
    {
        return $this->hasMany('App\Models\Subject', 'grade_id', 'id');
    }
}
