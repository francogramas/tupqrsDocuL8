<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\mailEmpresa;

class adminEmpresasMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $mailEmpresa;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(mailEmpresa $mailEmpresa)
    {
        $this->mailEmpresa = $mailEmpresa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailEmpresa->asunto)->markdown('emails.adminEmpresasMail');
    }
}
