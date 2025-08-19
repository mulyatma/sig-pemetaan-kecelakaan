<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kecelakaan;
use App\Http\Controllers\Controller;
use App\Imports\KecelakaanImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new KecelakaanImport, $request->file('file'));

        return redirect()->route('admin.kecelakaan.index')->with('success', 'Data berhasil diimport!');
    }
}
