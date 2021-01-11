<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TeacherDetails extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];


    
}
