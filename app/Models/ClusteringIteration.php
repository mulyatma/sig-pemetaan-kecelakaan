<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusteringIteration extends Model
{
    use HasFactory;

    protected $fillable = [
        'iterasi',
        'kecamatan',
        'jumlah_kasus',
        'total_md',
        'total_luka',
        'nama_klaster',
        'jarak_klaster_1',
        'jarak_klaster_2',
        'jarak_klaster_3',
        'jarak_klaster_4',
        'jarak_klaster_5',
    ];
}
