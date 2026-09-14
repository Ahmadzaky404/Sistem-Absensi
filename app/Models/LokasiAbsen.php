<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiAbsen extends Model
{
    protected $table = 'lokasi_absens';

    protected $fillable = ['nama_lokasi', 'latitude', 'longitude', 'radius'];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'radius' => 'integer',
        ];
    }
}
