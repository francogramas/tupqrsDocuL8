<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Solicitud;
use Illuminate\Support\Str;


class solicitudMail extends Mailable implements ShouldQueue
{    
    use Queueable, SerializesModels;
    public $solicitud, $seguimiento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
        $this->seguimiento = $solicitud->seguimiento->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(Str::length($this->seguimiento->adjunto)>0){
            return $this->subject('Radicación de solicitud')->markdown('emails.solicitudMail')
            ->attachFromStorage('public/'.$this->seguimiento->adjunto, 
                                'adjunto.pdf', [
                                'mime' => 'application/pdf']);
        }
        else{
            return $this->subject('Radicación de solicitud')->markdown('emails.solicitudMail');
        }        
    }
}
