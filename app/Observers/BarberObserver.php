<?php

namespace App\Observers;

use App\Mail\StatusChangeNotification;
use App\Models\Barber;
use Illuminate\Support\Facades\Mail;

class BarberObserver
{
    /**
     * Handle the Barber "updated" event.
     */
    public function updated(Barber $barber): void
    {
        // Cek apakah status aktif atau verifikasi berubah menjadi true
        if ($barber->isDirty('aktif') && $barber->aktif) {
            Mail::to($barber->email)->send(new StatusChangeNotification($barber, 'aktif', true));
        }

        if ($barber->isDirty('terverifikasi') && $barber->terverifikasi) {
            Mail::to($barber->email)->send(new StatusChangeNotification($barber, 'terverifikasi', true));
        }
    }
}
