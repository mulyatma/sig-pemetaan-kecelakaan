<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $statistik = Kecelakaan::select('tingkat_kecelakaan')
            ->groupBy('tingkat_kecelakaan')
            ->selectRaw('tingkat_kecelakaan, COUNT(*) as total')
            ->get();

        return view('pages.admin.dashboard', compact('statistik'));
    }

    public function pieChartData()
    {
        try {
            $data = Kecelakaan::select('tingkat_kecelakaan')
                ->groupBy('tingkat_kecelakaan')
                ->selectRaw('tingkat_kecelakaan, COUNT(*) as total_kecelakaan')
                ->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
