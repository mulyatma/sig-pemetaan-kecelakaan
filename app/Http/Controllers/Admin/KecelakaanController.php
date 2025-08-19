<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class KecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $kecelakaan = Kecelakaan::orderBy('tanggal_dilaporkan', 'desc')->paginate($perPage)->withQueryString();

        return view('pages.admin.kecelakaan.index', compact('kecelakaan', 'perPage'));
    }

    public function create()
    {
        return view('pages.admin.kecelakaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_dilaporkan' => 'required|date',
            'tingkat_kecelakaan' => 'required|string',
            'nama_jalan' => 'required|string',
            'status_jalan' => 'required|string',
            'penyebab' => 'required|string',
            'rumat' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'md' => 'nullable|integer',
            'lb' => 'nullable|integer',
            'lr' => 'nullable|integer',
            'kecamatan' => 'required|string',
        ]);

        // Ubah jika null jadi default
        $validated['rumat'] = $validated['rumat'] ?? '0';
        $validated['md'] = $validated['md'] ?? 0;
        $validated['lb'] = $validated['lb'] ?? 0;
        $validated['lr'] = $validated['lr'] ?? 0;

        Kecelakaan::create($validated);

        return redirect()->route('admin.kecelakaan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kecelakaan = Kecelakaan::findOrFail($id);
        return view('pages.admin.kecelakaan.edit', compact('kecelakaan'));
    }

    public function show($id)
    {
        $data = Kecelakaan::findOrFail($id);
        return view('admin.kecelakaan.show', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_dilaporkan' => 'required|date',
            'tingkat_kecelakaan' => 'required',
            'nama_jalan' => 'required',
            'penyebab' => 'nullable',
            'rumat' => 'nullable|string',
            'kecamatan' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'md' => 'nullable|integer',
            'lb' => 'nullable|integer',
            'lr' => 'nullable|integer',
        ]);

        $data = Kecelakaan::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('admin.kecelakaan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Kecelakaan::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.kecelakaan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function destroyAll()
    {

        Kecelakaan::truncate();

        return redirect()->route('admin.kecelakaan.index')->with('success', 'Semua data berhasil dihapus.');
    }
}
