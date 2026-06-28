<?php

namespace App\Mail;

use App\Models\OccupancyPeriod;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationOpenMail extends Mailable
{
    use Queueable, SerializesModels;

    public OccupancyPeriod $period;

    public function __construct(
        OccupancyPeriod $period
    ) {
        $this->period = $period;
    }

    public function build()
    {
        return $this
            ->subject('Registrasi Ulang Rusunawa Dibuka')
            ->view(
                'emails.registration-open'
            );
    }
}
