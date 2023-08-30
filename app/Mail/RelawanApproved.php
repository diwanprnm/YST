<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Relawan;

class RelawanApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $relawan;
    public $programRelawanData;


    public function __construct(Relawan $relawan, $programRelawanData)
    {
        $this->relawan = $relawan;
        $this->programRelawanData = $programRelawanData;
    }

    public function build()
    {
        return $this->view('emails.relawanapproved')
            ->subject('Relawan Telah Diverifikasi');
    }
}
