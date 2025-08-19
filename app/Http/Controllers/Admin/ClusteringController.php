<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClusteringCentroid;
use App\Models\ClusteringIteration;
use Illuminate\Http\Request;
use App\Models\RekapKecamatan;

class ClusteringController extends Controller
{
    public function index()
    {
        $centroids = ClusteringCentroid::all();
        $stored = \App\Models\ClusteringIteration::orderBy('iterasi')->get();

        $iterations = [];
        if ($stored->count() > 0) {
            $grouped = $stored->groupBy('iterasi');
            foreach ($grouped as $iterasiNum => $rows) {
                $iterations[] = [
                    'iterasi' => $iterasiNum,
                    'hasil' => $rows
                ];
            }
        }

        return view('pages.admin.clustering.index', [
            'iterations' => $iterations,
            'centroids' => $centroids
        ]);
    }

    public function proses(Request $request)
    {
        $centroidsInput = $request->input('centroids');
        $keterangan = $request->input('keterangan');

        ClusteringCentroid::truncate();
        ClusteringIteration::truncate();

        foreach ($centroidsInput as $i => $centroid) {
            ClusteringCentroid::create([
                'nama_klaster' => $keterangan[$i],
                'jumlah_kasus' => $centroid['jumlah_kasus'],
                'total_md' => $centroid['total_md'],
                'total_luka' => $centroid['total_luka'],
                'warna' => $request->warna[$i] ?? '#000000'
            ]);
        }

        $data = RekapKecamatan::all();

        if ($data->count() == 0) {
            return redirect()->back()->with('error', 'Data tidak ditemukan(Anda belum merekap data).');
        }

        // Centroid awal
        $centroids = [];
        foreach ($centroidsInput as $i => $c) {
            $centroids[$keterangan[$i]] = [
                'jumlah_kasus' => $c['jumlah_kasus'],
                'total_md' => $c['total_md'],
                'total_luka' => $c['total_luka'],
            ];
        }

        $maxIterations = 10;
        $iterations = [];
        $clusterAssignments = [];

        for ($iter = 1; $iter <= $maxIterations; $iter++) {
            $changed = false;
            $currentAssignments = [];
            $hasilIterasi = [];

            // Assign cluster
            foreach ($data as $item) {
                $minDistance = null;
                $assignedCluster = null;

                foreach ($centroids as $clusterName => $centroid) {
                    $distance = sqrt(
                        pow($item->jumlah_kasus - $centroid['jumlah_kasus'], 2) +
                            pow($item->total_md - $centroid['total_md'], 2) +
                            pow($item->total_luka - $centroid['total_luka'], 2)
                    );

                    if (is_null($minDistance) || $distance < $minDistance) {
                        $minDistance = $distance;
                        $assignedCluster = $clusterName;
                    }
                }

                $key = $item->kecamatan;
                if (!isset($clusterAssignments[$key]) || $clusterAssignments[$key] !== $assignedCluster) {
                    $changed = true;
                }

                $currentAssignments[$key] = $assignedCluster;

                $hasilIterasi[] = [
                    'kecamatan' => $item->kecamatan,
                    'jumlah_kasus' => $item->jumlah_kasus,
                    'total_md' => $item->total_md,
                    'total_luka' => $item->total_luka,
                    'nama_klaster' => $assignedCluster,
                ];
            }

            // Simpan snapshot centroid iterasi ini
            $centroidSnapshot = $centroids;

            // Update centroid
            foreach ($centroids as $clusterName => &$centroid) {
                $assignedItems = $data->filter(function ($item) use ($currentAssignments, $clusterName) {
                    return $currentAssignments[$item->kecamatan] === $clusterName;
                });

                if ($assignedItems->count() > 0) {
                    $centroid['jumlah_kasus'] = $assignedItems->avg('jumlah_kasus');
                    $centroid['total_md'] = $assignedItems->avg('total_md');
                    $centroid['total_luka'] = $assignedItems->avg('total_luka');
                }
            }

            unset($centroid);

            // Simpan hasil iterasi ke tabel clustering_iterations
            foreach ($hasilIterasi as $row) {
                // Ambil data asli RekapKecamatan
                $item = $data->firstWhere('kecamatan', $row['kecamatan']);

                // Hitung jarak ke semua centroid iterasi ini
                $distances = [];
                foreach ($centroidSnapshot as $clusterName => $centroid) {
                    $distances[$clusterName] = sqrt(
                        pow($item->jumlah_kasus - $centroid['jumlah_kasus'], 2) +
                            pow($item->total_md - $centroid['total_md'], 2) +
                            pow($item->total_luka - $centroid['total_luka'], 2)
                    );
                }

                // Siapkan data insert
                $insertData = [
                    'iterasi' => $iter,
                    'kecamatan' => $row['kecamatan'],
                    'jumlah_kasus' => $row['jumlah_kasus'],
                    'total_md' => $row['total_md'],
                    'total_luka' => $row['total_luka'],
                    'nama_klaster' => $row['nama_klaster'],
                ];

                // Tambahkan kolom jarak_klaster_n secara dinamis
                $i = 1;
                foreach ($distances as $clusterName => $distance) {
                    $insertData['jarak_klaster_' . $i] = $distance;
                    $i++;
                }

                ClusteringIteration::create($insertData);
            }

            $iterations[] = [
                'iterasi' => $iter,
                'assignments' => $hasilIterasi,
                'centroids' => $centroids,
            ];

            if (!$changed) {
                break;
            }

            $clusterAssignments = $currentAssignments;
        }

        return redirect()->back()->with('Berhasil menghitung clustering');
    }

    public function destroyProcess()
    {
        ClusteringIteration::truncate();
        return redirect()->back()->with('Berhasil menghapus hasil clustering');
    }

    public function destroyCluster()
    {
        ClusteringCentroid::truncate();
        return redirect()->back()->with('Berhasil menghapus hasil cluster');
    }

    public function showMap()
    {
        $lastIterasi = ClusteringIteration::max('iterasi');
        $dataColors = ClusteringCentroid::all();

        $colors = $dataColors->pluck('warna', 'nama_klaster')->toArray();

        $rekap = [];
        if ($lastIterasi) {
            $rekap = ClusteringIteration::where('iterasi', $lastIterasi)->get()->toArray();
        }


        return view('pages.admin.clustering.map', [
            'rekap' => $rekap,
            'colors' => $colors
        ]);
    }
}
