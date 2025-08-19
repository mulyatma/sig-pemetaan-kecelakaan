@extends('layouts.admin')

@section('title', 'Edit Data Kecelakaan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Kecelakaan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('admin.kecelakaan.update', $kecelakaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tanggal Dilaporkan</label>
                            <input type="date" name="tanggal_dilaporkan" class="form-control" value="{{ $kecelakaan->tanggal_dilaporkan }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tingkat Kecelakaan</label>
                            <input type="text" name="tingkat_kecelakaan" class="form-control" value="{{ $kecelakaan->tingkat_kecelakaan }}" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Jalan</label>
                            <input type="text" name="nama_jalan" class="form-control" value="{{ $kecelakaan->nama_jalan }}" required>
                        </div>
                        <div class="form-group">
                            <label>Penyebab</label>
                            <input type="text" name="penyebab" class="form-control" value="{{ $kecelakaan->penyebab }}">
                        </div>
                        <div class="form-group">
                            <label>Rumat</label>
                            <input type="text" name="rumat" class="form-control" value="{{ $kecelakaan->rumat }}">
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="{{ $kecelakaan->kecamatan }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control" value="{{ $kecelakaan->latitude }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control" value="{{ $kecelakaan->longitude }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>MD / LB / LR</label>
                            <div class="form-row">
                                <div class="col">
                                    <input type="number" name="md" class="form-control" value="{{ $kecelakaan->md }}" placeholder="MD">
                                </div>
                                <div class="col">
                                    <input type="number" name="lb" class="form-control" value="{{ $kecelakaan->lb }}" placeholder="LB">
                                </div>
                                <div class="col">
                                    <input type="number" name="lr" class="form-control" value="{{ $kecelakaan->lr }}" placeholder="LR">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.kecelakaan.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection