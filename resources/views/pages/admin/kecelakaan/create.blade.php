@extends('layouts.admin')

@section('title', 'Tambah Data Kecelakaan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Kecelakaan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Data Kecelakaan (Manual)</h4>
                </div>
                <form action="{{ route('admin.kecelakaan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tanggal Dilaporkan</label>
                            <input type="date" name="tanggal_dilaporkan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tingkat Kecelakaan</label>
                            <input type="text" name="tingkat_kecelakaan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Jalan</label>
                            <input type="text" name="nama_jalan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status Jalan</label>
                            <input type="text" name="status_jalan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Penyebab</label>
                            <input type="text" name="penyebab" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Rumat</label>
                            <input type="text" name="rumat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>MD / LB / LR</label>
                            <div class="form-row">
                                <div class="col">
                                    <input type="number" name="md" class="form-control" placeholder="MD">
                                </div>
                                <div class="col">
                                    <input type="number" name="lb" class="form-control" placeholder="LB">
                                </div>
                                <div class="col">
                                    <input type="number" name="lr" class="form-control" placeholder="LR">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan Manual</button>
                    </div>
                </form>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Import Data Kecelakaan dari Excel</h4>
                </div>
                <form action="{{ route('admin.kecelakaan.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                            <small class="text-muted">Format file: .xlsx atau .xls</small>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-upload"></i> Import Excel
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection