@extends('layouts.app')

@section('content')
<!-- Banner -->
<section class="relative bg-cover bg-center bg-no-repeat bg-fixed h-screen text-white flex items-center justify-center text-center px-4" style="background-image: url('https://www.djkn.kemenkeu.go.id/files/images/2021/01/SELAMATDATANGBREBES_OK.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="container mx-auto relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold">Kabupaten Brebes</h1>
        <p class="mt-4 text-lg max-w-2xl mx-auto">
            Sistem Informasi ini merupakan aplikasi pemetaan geografis lokasi kejadian kecelakaan lalu lintas di wilayah Kabupaten Brebes. Aplikasi ini memuat informasi dan lokasi persebaran kasus kecelakaan berdasarkan data yang telah dilaporkan.
        </p>
    </div>
</section>

<!-- Pemetaan -->
<section id="map" class="py-20 px-4">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold text-gray-800">Pemetaan Kecelakaan</h2>

        <div class="mt-4 space-x-2">
            <button id="btnShowCluster" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded hidden">
                Lihat Peta Clustering
            </button>
            <button id="btnShowTitik" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Lihat Titik Kecelakaan
            </button>
        </div>

        <div id="mapid" class="h-[550px] mt-8 rounded-lg shadow-md hidden"></div>
        <div id="mapCluster" class="h-[550px] mt-4 rounded-lg shadow-md"></div>
    </div>
</section>

<section id="tentang-ispa" class="py-20 px-4 bg-white">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
        <div class="md:w-1/3 w-full flex justify-center">
            <img src="{{ asset('images/laka.jpg') }}" alt="Gambar Kecelakaan" class="rounded-lg shadow-md">
        </div>
        <div class="md:w-2/3 w-full md:pl-8 mt-6 md:mt-0">
            <h2 class="text-3xl font-bold text-gray-800">Apa Itu Kecelakaan Lalu Lintas?</h2>
            <p class="mt-4 text-gray-600">
                Kecelakaan lalu lintas adalah peristiwa yang terjadi di jalan raya yang melibatkan kendaraan bermotor, pejalan kaki, atau pengguna jalan lainnya, yang dapat mengakibatkan kerugian materi, cedera, atau korban jiwa.
            </p>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-100 text-center">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-gray-800">Cara Mencegah Kecelakaan Lalu Lintas</h2>
        <p class="mt-4 text-gray-600">Beberapa langkah penting untuk meningkatkan keselamatan di jalan.</p>
        <div class="flex flex-wrap justify-center mt-6">
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="https://cdn-icons-png.flaticon.com/512/854/854878.png" alt="Gunakan Helm" class="w-16 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-green-500">Gunakan Helm & Sabuk Pengaman</h3>
                    <p class="text-gray-700">Selalu memakai helm saat berkendara motor dan sabuk pengaman saat mengemudi mobil.</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="Patuh Aturan" class="w-16 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-green-500">Patuhi Aturan Lalu Lintas</h3>
                    <p class="text-gray-700">Ikuti rambu lalu lintas, batas kecepatan, dan hindari pelanggaran.</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="https://cdn-icons-png.flaticon.com/512/929/929426.png" alt="Cek Kondisi Kendaraan" class="w-16 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-green-500">Cek Kondisi Kendaraan</h3>
                    <p class="text-gray-700">Pastikan kendaraan dalam kondisi baik sebelum digunakan untuk berkendara.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    var mymap = L.map('mapid').setView([-6.9848164, 109.0898518], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(mymap);

    $.ajax({
        url: @json(route('get.kecelakaan.locations')),
        method: 'GET',
        success: function(response) {
            response.forEach(function(location) {
                if (!location.latitude || !location.longitude) return;

                var markerColor = 'blue';
                if (location.tingkat_kecelakaan === 'Berat') markerColor = 'red';
                else if (location.tingkat_kecelakaan === 'Sedang') markerColor = 'orange';
                else if (location.tingkat_kecelakaan === 'Ringan') markerColor = 'green';

                var markerIcon = L.icon({
                    iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${markerColor}.png`,
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                var marker = L.marker([location.latitude, location.longitude], {
                    icon: markerIcon
                }).addTo(mymap);

                var popupContent = `
                    <div class="p-2">
                        <h3 class="font-bold mb-1">${location.nama_jalan}</h3>
                        <p><strong>Tanggal:</strong> ${location.tanggal_dilaporkan}</p>
                        <p><strong>Tingkat:</strong> ${location.tingkat_kecelakaan}</p>
                        <p><strong>Penyebab:</strong> ${location.penyebab}</p>
                        <p><strong>MD:</strong> ${location.md}, LB: ${location.lb}, LR: ${location.lr}</p>
                    </div>
                    `;
                marker.bindPopup(popupContent);
            });
        },
        error: function(error) {
            console.error('Error fetching locations:', error);
        }
    });

    var mapCluster = L.map('mapCluster').setView([-6.9848164, 109.0898518], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapCluster);

    Promise.all([
        fetch("{{ asset('storage/geojson/kabupaten.geojson') }}").then(res => res.json()),
        fetch("{{ route('clustering.map.user') }}").then(res => res.json())
    ]).then(([geojson, clusteringResponse]) => {
        const clusteringData = clusteringResponse.data ?? clusteringResponse;

        const clusterColors = clusteringResponse.colors ?? clusteringResponse;

        function getColor(cluster) {
            return clusterColors[cluster] || '#95a5a6';
        }

        function onEachFeature(feature, layer) {
            const kecamatan = feature.properties.district;
            const data = clusteringData.find(d => d.kecamatan && kecamatan && d.kecamatan.toLowerCase() === kecamatan.toLowerCase());

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
                fillColor: data ? getColor(data.nama_klaster) : '#ccc',
                fillOpacity: 0.6,
                color: '#333',
                weight: 1
            });
        }

        L.geoJSON(geojson, {
            onEachFeature: onEachFeature
        }).addTo(mapCluster);
    }).catch(err => {
        console.error('Error loading map data:', err);
    });

    $('#btnShowCluster').click(function() {
        $('#mapid').addClass('hidden');
        $('#mapCluster').removeClass('hidden');
        $('#btnShowCluster').addClass('hidden');
        $('#btnShowTitik').removeClass('hidden');
        mapCluster.invalidateSize();
    });

    $('#btnShowTitik').click(function() {
        $('#mapCluster').addClass('hidden');
        $('#mapid').removeClass('hidden');
        $('#btnShowTitik').addClass('hidden');
        $('#btnShowCluster').removeClass('hidden');
        mymap.invalidateSize();
    });
</script>
@endpush
@endsection