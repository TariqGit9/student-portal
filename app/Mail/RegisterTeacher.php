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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name,$pass)
    {
        $this->user_name=$user_name;
        $this->pass=$pass;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {




        return $this->subject('Teacher Registered ')->view('email.register-teacher');
       
    }
}
