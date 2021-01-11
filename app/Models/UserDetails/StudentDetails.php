<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentDetails extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    use HasFactory;
    public function class()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id')->withTrashed();
    }
    public function student()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }
}
