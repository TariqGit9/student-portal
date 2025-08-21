<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'user_name',
        'password',
        'avatar',
        'role_id',
        'school_information_id',
        'status',
        'email_verified_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function teacher_details()
    {
        return $this->belongsTo('App\Models\UserDetails\TeacherDetails', 'id', 'user_id')->withTrashed();
    }
    public function student_details()
    {
        return $this->belongsTo('App\Models\UserDetails\StudentDetails', 'id', 'user_id')->withTrashed();
    }
    public function admin_details()
    {
        return $this->belongsTo('App\Models\UserDetails\AdminDetails', 'id', 'user_id');
    }
    public function deleted_teacher_details()
    {
        return $this->belongsTo('App\Models\UserDetails\TeacherDetails', 'id', 'user_id')->withTrashed();
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function school()
    {
        return $this->belongsTo('App\Models\SchoolInformation');
    }
}
