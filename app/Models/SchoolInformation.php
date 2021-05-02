<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SchoolInformation extends Model
{
    // use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    public function school_session()
    {
        return $this->hasOne('App\Models\SchoolSession','school_id','id')->where('status',1);
    }
}
