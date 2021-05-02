<?php

namespace App\Mail\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportStudent extends Mailable
{
    use Queueable, SerializesModels;
    
    public $student;
    public $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student,$description)
    {
        $this->student=$student;
        $this->description=$description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Student Report')->view('email.teacher.report-student');

    }
}
