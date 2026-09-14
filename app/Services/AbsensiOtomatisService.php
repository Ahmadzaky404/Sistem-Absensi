<?php

namespace App\Services;



class AbsensiOtomatisService
{
    /**
     * Jam pulang dicatat manual oleh pengguna melalui tombol Absen Pulang.
     */
    public function tutupAbsensiYangBelumPulang(): int
    {
        return 0;
    }
}
