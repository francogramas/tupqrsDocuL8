<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\DetalleExpediente;

class expedienteMail extends  Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $detalle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DetalleExpediente $detalle)
    {
        $this->detalle = $detalle;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Actualización de expediente')->markdown('emails.expedienteMail');
    }
}
