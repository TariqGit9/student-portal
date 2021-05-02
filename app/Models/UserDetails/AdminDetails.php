<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDetails extends Model
{
    use HasFactory;
    public function school_session(){
        return $this->hasOne(SchoolSession::class, 'username', 'username');
    }
}
