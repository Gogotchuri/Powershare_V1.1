<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyExportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $file;

    /**
     * Create a new message instance.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Survey data!")
            ->view('emails.SurveyDataExport')
            ->attach($this->file, ["as" => "data.xlsx"]);
    }
}
