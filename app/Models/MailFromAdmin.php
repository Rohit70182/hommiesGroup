<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class MailFromAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public $pdfUrl;

    public $view;

    public $subject;

    public $from_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $data, $from,$subject)
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
        $this->from_email = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->from_email)->subject($this->subject)->view($this->view);
    }
}
