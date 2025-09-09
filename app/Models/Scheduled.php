<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class Scheduled extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $date;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $date)
    {
        $this->name = $name;
        $this->date = $date;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.voyager.mail.scheduled',
            with: [
                'name' => $this->name,
                'date' => $this->date,
            ]
        );
    }
}
