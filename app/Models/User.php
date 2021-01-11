<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];
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
    public function deleted_teacher_details()
    {
        return $this->belongsTo('App\Models\UserDetails\TeacherDetails', 'id', 'user_id')->withTrashed();
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
