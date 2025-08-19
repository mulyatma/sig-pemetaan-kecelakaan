@extends('layouts.admin')

@section('title', 'Peta Hasil Clustering')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Peta Hasil Clustering Kecelakaan</h1>
        </div>

        <div class="section-body">
            @if (empty($rekap))
            <div class="alert alert-warning">
                Belum ada data clustering untuk ditampilkan.
            </div>
            @else
            <div id="map" style="height: 600px;"></div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
@if (!empty($rekap))
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([-6.9, 109.0], 10); // Sesuaikan koordinat awal

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap',
    }).addTo(map);


    fetch("{{ asset('storage/geojson/kabupaten.geojson') }}")
        .then(response => response.json())
        .then(geojson => {
            const clusteringData = @json($rekap);

            const clusterColors = @json($colors);

            function getColor(kecamatan) {
                const data = clusteringData.find(d =>
                    d.kecamatan && kecamatan &&
                    d.kecamatan.toLowerCase() === kecamatan.toLowerCase()
                );
                return data ? (clusterColors[data.nama_klaster] || '#95a5a6') : '#95a5a6';
            }

            function onEachFeature(feature, layer) {
                const kecamatan =
                    feature.properties['district'] ||
                    feature.properties['Kecamatan'] ||
                    feature.properties['kecamatan'] ||
                    feature.properties['nama'] ||
                    '';

                const data = clusteringData.find(d =>
                    d.kecamatan &&
                    kecamatan &&
                    d.kecamatan.toLowerCase().trim() === kecamatan.toLowerCase().trim()
                );

                let content = `<strong>${kecamatan}</strong><br>`;
                if (data) {
                    content += `Klaster: <strong>${data.nama_klaster}</strong><br>`;
                    content += `Jumlah Kasus: ${data.jumlah_kasus}<br>`;
                    content += `Total MD: ${data.total_md}<br>`;
                    content += `Total Luka: ${data.total_luka}`;
                } else {
                    content += 'Tidak ada data clustering';
                }

                layer.bindPopup(content);
                layer.setStyle({
                    fillColor: getColor(kecamatan),
                    fillOpacity: 0.6,
                    color: '#333',
                    weight: 1
                });
            }

            L.geoJSON(geojson, {
                onEachFeature: onEachFeature
            }).addTo(map);
        });
</script>
@endif
@endpush