<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ClusteringCentroid;
use App\Models\ClusteringIteration;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getLocations()
    {
        $data = \App\Models\Kecelakaan::select(
            'id',
            'latitude',
            'longitude',
            'nama_jalan',
            'tanggal_dilaporkan',
            'tingkat_kecelakaan',
            'penyebab',
            'md',
            'lb',
            'lr',
            'kecamatan'
        )->get();

        return response()->json($data);
    }

    public function showMapUser()
    {
        $lastIterasi = ClusteringIteration::max('iterasi');
        $dataColors = ClusteringCentroid::all();

        $colors = $dataColors->pluck('warna', 'nama_klaster')->toArray();

        if (!$lastIterasi) {
            return back()->with('error', 'Belum ada data clustering');
        }

        $rekap = ClusteringIteration::where('iterasi', $lastIterasi)->get()->toArray();

        return response()->json([
            'success' => true,
            'data' => $rekap,
            'colors' => $colors
        ]);
    }
}
