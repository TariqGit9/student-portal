<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Classes extends Model
{
    use HasFactory;
    protected $guarded = [];
    use SoftDeletes;
//These Two are Same you know why cuz i am a Shit Coder...
    public function grade()
    {
        return $this->belongsTo('App\Models\ClassGrade');
    }
    public function class()
    {
        return $this->belongsTo('App\Models\ClassGrade', 'grade_id', 'id');
    }
//These Two are Same you know why cuz i am a Shit Coder...
}
