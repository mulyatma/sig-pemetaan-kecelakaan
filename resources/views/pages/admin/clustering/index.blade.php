@extends('layouts.admin')

@section('title', 'Clustering K-Means')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Clustering K-Means</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Input Keterangan Cluster dan Centroid Awal</h4>
                    <form action="{{ route('admin.cluster.destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua cluster?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Hapus Semua Cluster
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.clustering.proses') }}" method="POST">
                        @csrf

                        <div id="clusters">
                            @if(isset($centroids) && count($centroids) > 0)
                            @foreach($centroids as $i => $c)
                            <div class="border p-3 mb-3 cluster-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Cluster {{ $i + 1 }}</h5>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeCluster(this)">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label>Nama Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan[]" value="{{ $c['nama_klaster'] }}" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Warna Cluster</label>
                                        <input type="color" class="form-control form-control-color" name="warna[]" value="{{ $c['warna'] ?? '#000000' }}" title="Pilih warna cluster">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Jumlah Kasus</label>
                                        <input type="number" class="form-control" name="centroids[{{ $i }}][jumlah_kasus]" value="{{ $c['jumlah_kasus'] }}" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Total MD</label>
                                        <input type="number" class="form-control" name="centroids[{{ $i }}][total_md]" value="{{ $c['total_md'] }}" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Total Luka</label>
                                        <input type="number" class="form-control" name="centroids[{{ $i }}][total_luka]" value="{{ $c['total_luka'] }}" required>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="border p-3 mb-3 cluster-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Cluster 1</h5>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeCluster(this)">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label>Nama Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan[]" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Warna Cluster</label>
                                        <input type="color" class="form-control form-control-color" name="warna[]" value="#${Math.floor(Math.random()*16777215).toString(16)}" title="Pilih warna cluster">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Jumlah Kasus</label>
                                        <input type="number" class="form-control" name="centroids[0][jumlah_kasus]" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Total MD</label>
                                        <input type="number" class="form-control" name="centroids[0][total_md]" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Total Luka</label>
                                        <input type="number" class="form-control" name="centroids[0][total_luka]" required>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="addCluster()">Tambah Cluster</button>
                        <button type="submit" class="btn btn-primary ml-2">Proses Clustering</button>
                    </form>
                </div>
            </div>

            @if(isset($iterations) && count($iterations) > 0)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Hasil Clustering</h4>
                    <form action="{{ route('admin.clustering.destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus hasil clustering?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Hapus Hasil
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    @foreach($iterations as $step)
                    <h5 class="mt-4">Iterasi ke-{{ $step['iterasi'] }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kecamatan</th>
                                    @php
                                    $firstRow = $step['hasil']->first();
                                    $allKeys = collect($firstRow->getAttributes())
                                    ->keys()
                                    ->filter(function($k) {
                                    return \Illuminate\Support\Str::startsWith($k, 'jarak_klaster_');
                                    });

                                    $jarakKeys = [];
                                    foreach ($allKeys as $key) {
                                    $hasValue = false;
                                    foreach ($step['hasil'] as $r) {
                                    if (!is_null($r->$key)) {
                                    $hasValue = true;
                                    break;
                                    }
                                    }
                                    if ($hasValue) {
                                    $jarakKeys[] = $key;
                                    }
                                    }
                                    @endphp

                                    @foreach($jarakKeys as $key)
                                    <th>{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}</th>
                                    @endforeach
                                    <th>Cluster</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($step['hasil'] as $row)
                                <tr>
                                    <td>{{ $row->kecamatan }}</td>
                                    @foreach($jarakKeys as $key)
                                    <td>
                                        @if(!is_null($row->$key))
                                        {{ number_format($row->$key, 4) }}
                                        @endif
                                    </td>
                                    @endforeach
                                    <td>{{ $row->nama_klaster }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif


        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    let clusterIndex = @json(count($centroids) > 0 ? count($centroids) : 1);

    function removeCluster(button) {
        const container = document.getElementById('clusters');
        const cluster = button.closest('.cluster-item');
        cluster.remove();

        const clusterItems = container.querySelectorAll('.cluster-item');
        clusterItems.forEach((item, i) => {
            item.querySelector('h5').textContent = `Cluster ${i + 1}`;

            const inputs = item.querySelectorAll('input');
            inputs.forEach(input => {
                if (input.name.includes('centroids')) {
                    const nameParts = input.name.split(']');
                    // Ubah index ke i
                    const field = nameParts[1];
                    input.name = `centroids[${i}]${field}]`;
                }
            });
        });
    }

    function addCluster() {
        const container = document.getElementById('clusters');
        const clusterItems = container.querySelectorAll('.cluster-item');
        if (clusterItems.length >= 5) {
            alert("Maksimal 5 cluster diizinkan.");
            return;
        }
        const index = clusterItems.length;

        const div = document.createElement('div');
        div.classList.add('border', 'p-3', 'mb-3', 'cluster-item');

        div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
    <h5>Cluster ${index + 1}</h5>
    <button type="button" class="btn btn-danger btn-sm" onclick="removeCluster(this)">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>

<div class="form-row">
    <div class="form-group col-md-8">
        <label>Nama Keterangan</label>
        <input type="text" class="form-control" name="keterangan[]" required>
    </div>
    <div class="form-group col-md-4">
        <label>Warna Cluster</label>
        <input type="color" class="form-control form-control-color" name="warna[]" value="#${Math.floor(Math.random()*16777215).toString(16)}" title="Pilih warna cluster">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label>Jumlah Kasus</label>
        <input type="number" class="form-control" name="centroids[${index}][jumlah_kasus]" required>
    </div>
    <div class="form-group col-md-4">
        <label>Total MD</label>
        <input type="number" class="form-control" name="centroids[${index}][total_md]" required>
    </div>
    <div class="form-group col-md-4">
        <label>Total Luka</label>
        <input type="number" class="form-control" name="centroids[${index}][total_luka]" required>
    </div>
</div>
    `;

        container.appendChild(div);
    }
</script>
@endpush