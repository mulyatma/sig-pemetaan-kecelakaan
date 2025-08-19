@extends('layouts.admin') {{-- Pastikan layout kamu bernama layouts.app sesuai template di atas --}}

@section('title', 'Rekap Data Kecelakaan')

@section('main')
<section class="section">
    <div class="main-content">
        <div class="section-header">
            <h1>Rekap Data Kecelakaan per Kecamatan</h1>
        </div>

        <div class="section-body">
            {{-- Pesan sukses --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            {{-- Tombol Proses --}}
            <div class="mb-3">
                <form action="{{ route('admin.rekap.proses') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt"></i> Proses Rekap Data
                    </button>
                </form>
            </div>

            {{-- Tabel Data --}}
            <div class="card">
                <div class="card-header">
                    <h4>Data Rekapitulasi</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Kecamatan</th>
                                    <th>Jumlah Kasus</th>
                                    <th>Total MD</th>
                                    <th>Total Luka</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekap as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $r->kecamatan }}</td>
                                    <td>{{ $r->jumlah_kasus }}</td>
                                    <td>{{ $r->total_md }}</td>
                                    <td>{{ $r->total_luka }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data rekap.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection