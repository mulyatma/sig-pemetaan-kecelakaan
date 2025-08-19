<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusteringCentroid extends Model
{
    use HasFactory;

    protected $table = "clustering_centroids";

    protected $fillable = [
        'nama_klaster',
        'jumlah_kasus',
        'total_md',
        'total_luka',
        'warna'
    ];
}
