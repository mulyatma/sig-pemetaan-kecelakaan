@extends('layouts.admin')

@section('title', 'List Data ISPA')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Kecelakaan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">List Data Kecelakaan</h4>
                    <div class="d-flex align-items-center">
                        <form method="GET" action="{{ route('admin.kecelakaan.index') }}" id="perPageForm" class="form-inline pr-4">
                            <label for="per_page" class="mr-2">Tampilkan</label>
                            <select name="per_page" id="per_page" class="form-control form-control-sm" onchange="document.getElementById('perPageForm').submit();">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </form>
                        <form action="{{ route('admin.kecelakaan.destroyAll') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data?');" class="pr-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Hapus Semua Data
                            </button>
                        </form>

                        <div>
                            <a href="{{ route('admin.kecelakaan.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Tingkat</th>
                                <th>Nama Jalan</th>
                                <th>Penyebab</th>
                                <th>Koordinat</th>
                                <th>MD / LB / LR</th>
                                <th>Rumat</th>
                                <th>Kecamatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kecelakaan as $index => $data)
                            <tr>
                                <td class="text-center">{{ $kecelakaan->firstItem() + $index }}</td>
                                <td class="text-center">{{ $data->tanggal_dilaporkan }}</td>
                                <td class="text-center">{{ $data->tingkat_kecelakaan }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($data->nama_jalan, 30) }}</td>
                                <td>{{ $data->penyebab }}</td>
                                <td class="text-center">{{ $data->latitude }}, {{ $data->longitude }}</td>
                                <td class="text-center">{{ $data->md }} / {{ $data->lb }} / {{ $data->lr }}</td>
                                <td class="text-center">{{ $data->rumat }}</td>
                                <td class="text-center">{{ $data->kecamatan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kecelakaan.edit', $data->id) }}" class="btn btn-sm btn-warning mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.kecelakaan.destroy', $data->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Data kecelakaan belum tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 d-flex justify-content-center">
                        {{ $kecelakaan->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection



@push('scripts')
<!-- JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush