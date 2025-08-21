<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudentFee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function fee()
    {
        return $this->belongsTo(ClassFee::class, 'fee_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
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
