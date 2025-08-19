<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use App\Models\RekapKecamatan;
use Illuminate\Http\Request;

class RekapKecelakaanController extends Controller
{
    public function index()
    {
        $rekap = RekapKecamatan::orderBy('kecamatan')->get();

        return view('pages.admin.kecelakaan.recap', compact('rekap'));
    }

    public function proses(Request $request)
    {
        if (RekapKecamatan::count() > 0) {
            RekapKecamatan::truncate();
        }

        $kecelakaan = \App\Models\Kecelakaan::all();

        $rekap = [];

        foreach ($kecelakaan as $k) {
            // Ambil kata pertama dari kolom kecamatan
            $kecamatan = strtoupper(trim(explode(' ', $k->kecamatan ?? 'TIDAK DIKETAHUI')[0]));

            if (!isset($rekap[$kecamatan])) {
                $rekap[$kecamatan] = [
                    'jumlah_kasus' => 0,
                    'total_md' => 0,
                    'total_luka' => 0,
                ];
            }

            $rekap[$kecamatan]['jumlah_kasus'] += 1;
            $rekap[$kecamatan]['total_md'] += $k->md;
            $rekap[$kecamatan]['total_luka'] += ($k->lb + $k->lr);
        }

        foreach ($rekap as $namaKec => $data) {
            RekapKecamatan::create([
                'kecamatan' => $namaKec,
                'jumlah_kasus' => $data['jumlah_kasus'],
                'total_md' => $data['total_md'],
                'total_luka' => $data['total_luka'],
            ]);
        }

        return redirect()->back()->with('success', 'Data rekap berhasil diperbarui.');
    }
}
