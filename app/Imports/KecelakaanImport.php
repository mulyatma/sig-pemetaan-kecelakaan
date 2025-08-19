<?php

namespace App\Imports;

use App\Models\Kecelakaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KecelakaanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Kecelakaan([
            'tanggal_dilaporkan'   => $row['tanggal_dilaporkan'],
            'tingkat_kecelakaan'   => $row['tingkat_kecelakaan'],
            'md'                   => $row['md'],
            'lb'                   => $row['lb'],
            'lr'                   => $row['lr'],
            'latitude'             => $row['koordinat_gps_lintang'],
            'longitude'            => $row['koordinat_gps_bujur'],
            'nama_jalan'           => $row['nama_jalan'],
            'status_jalan'         => $row['status_jalan'],
            'penyebab'             => $row['penyebab'],
            'rumat'                => $row['rumat'],
            'kecamatan'            => $row['kecamatan'],
        ]);
    }
}
