<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassFee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(ClassStudentFee::class, 'fee_id');
    }

    public function school()
    {
        return $this->belongsTo(SchoolInformation::class, 'school_id');
    }

    public function session()
    {
        return $this->belongsTo(SchoolSession::class, 'school_session_id');
    }
}
