<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterTeacher extends Mailable
{
    use Queueable, SerializesModels;
    
    public $pass;
    public $user_name;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name,$pass, $user)
    {
        $this->user_name=$user_name;
        $this->pass=$pass;
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Teacher Register')->view('email.register-teacher');
    }
}
