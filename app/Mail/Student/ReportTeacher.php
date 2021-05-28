<?php

namespace App\Mail\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportTeacher extends Mailable
{
    use Queueable, SerializesModels;
    
    public $student;
    public $teacher;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student,$teacher,$data)
    {
        $this->student=$student;
        $this->teacher=$teacher;
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Teacher Report')->view('email.student.report-teacher');

    }
}
