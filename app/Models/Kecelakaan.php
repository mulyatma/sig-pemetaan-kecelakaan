<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $table = 'kecelakaan';

    protected $fillable = [
        'tanggal_dilaporkan',
        'tingkat_kecelakaan',
        'md',
        'lb',
        'lr',
        'latitude',
        'longitude',
        'nama_jalan',
        'status_jalan',
        'penyebab',
        'rumat',
        'kecamatan'
    ];
}
