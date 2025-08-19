<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // default 10
        $kecelakaan = \App\Models\Kecelakaan::orderBy('tanggal_dilaporkan', 'desc')->paginate($perPage);
        return view('pages.user.kecelakaan', compact('kecelakaan', 'perPage'));
    }
}
