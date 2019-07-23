<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyExportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $file;
    private $filename;
    private $title;
    private $num_filled;

    /**
     * Create a new message instance.
     *
     * @param $file
     * @param $filename
     * @param $title
     * @param $num_filled
     */
    public function __construct($file, $filename, $title, $num_filled)
    {
        $this->file = $file;
        $this->filename = $filename;
        $this->num_filled = $num_filled;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("თქვენი გამოკითხვის შედეგები!")
            ->from("powershareweb@gmail.com")
            ->view('emails.SurveyDataExport', ["title" => $this->title, "num_filled" => $this->num_filled])
            ->attach($this->file, ["as" => $this->filename]);
    }
}
