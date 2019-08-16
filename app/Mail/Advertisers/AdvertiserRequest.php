<?php

namespace App\Mail\Advertisers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdvertiserRequest extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $phone;

    /**
     * Create a new message instance.
     *
     * @param $email
     * @param $phone
     */
    public function __construct($email, $phone)
    {
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * Build the message.
     *
     * @return AdvertiserRequest
     */
    public function build()
    {
        return $this->subject("NEW ADVERTISER!")
            ->from("powershareweb@gmail.com")
            ->view('emails.AdvertiserRequest', ["email" => $this->email, "phone" => $this->phone]);
    }
}
