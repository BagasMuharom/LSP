<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Mahasiswa;

class EmailVerifikasi extends Mailable
{
    use Queueable, SerializesModels;

    private $mahasiswa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mahasiswa $mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verifikasi Akun')
                    ->view('mail.verifikasi', [
                        'token' => encrypt($this->mahasiswa->nim)
                    ]);
    }
}
