<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Donasi;

class DonasiCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $donasi;

    public function __construct(Donasi $donasi)
    {
        $this->donasi = $donasi;
    }

    public function build()
    {
        return $this->view('emails.donasicreated')
            ->subject('Konfirmasi Donasi');
    }
}

