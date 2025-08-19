<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapKecamatan extends Model
{
    use HasFactory;

    protected $table = 'rekap_kecamatan';

    protected $fillable = [
        'kecamatan',
        'jumlah_kasus',
        'total_md',
        'total_luka',
    ];
}
