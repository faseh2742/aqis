<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class meetingLink extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, $details)
    {
        $this->user = $user;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.client.meetingLink');
    }
}
