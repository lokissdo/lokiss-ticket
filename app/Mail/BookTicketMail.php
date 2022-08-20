<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function build()
    {
        return  $this->subject('Book Tickets Successfully')
            ->view('mails.bookticketnotification', ['data' => $this->data]);
    }
}
