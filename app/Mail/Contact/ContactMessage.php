<?php

namespace App\Mail\Contact;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $info;

    /**
     * Create a new message instance.
     *
     * @param $input
     */
    public function __construct($input)
    {
        $this->info = $input;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->info["subject"])->markdown("emails.ContactMessage", [
            "body" => $this->info["text"],
            "sender_name" => $this->info["name"],
            "sender_email" => $this->info["email"]
        ]);
    }
}
