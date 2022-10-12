<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Solicitud;
use Illuminate\Support\Str;


class ColaSolicitudMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $solicitud;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
        $this->seguimiento = $solicitud->seguimiento->last();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(Str::length($this->solicitud->adjuntorespuesta)>0){
            return $this->markdown('emails.emails.colaSolicitud')
            ->attachFromStorage('public/'.$this->solicitud->adjuntorespuesta,
                                'adjuntoRespuesta.pdf', [
                                'mime' => 'application/pdf']);
        }
        else{
            return $this->subject('Respuesta a solicitud')->markdown('emails.colaSolicitud');
        }
    }
}
