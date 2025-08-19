@extends('layouts.app')

@section('title', 'Data Kecelakaan')

@section('content')
<!-- Hero Section with Image and Overlay -->
<section class="relative bg-cover bg-center h-80 flex items-center justify-center text-center px-4"
    style="background-image: url('https://www.griyasatria.co.id/wp-content/uploads/2022/11/Asal-usul-nama-Brebes.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="container mx-auto relative z-10 text-white">
        <h1 class="text-4xl md:text-5xl font-bold">Sistem Informasi Geografis Pemetaan Kecelakaan</h1>
        <p class="mt-4 text-lg">Informasi dan data kecelakaan di wilayah Kabupaten Brebes</p>
    </div>
</section>

<!-- Data Kecelakaan -->
<section class="text-gray-800 pt-10 pb-20 text-center px-4">
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">
            Data Kecelakaan di Kabupaten Brebes
        </h1>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
            <form method="GET" action="{{ route('kecelakaan.index') }}" class="flex items-center space-x-2">
                <label for="per_page" class="text-sm text-gray-600">Tampilkan</label>
                <select name="per_page" id="per_page"
                    class="border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-200"
                    onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span class="text-sm text-gray-600">data</span>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-xs md:text-sm leading-normal">
                        <th class="py-3 px-4 text-center">No</th>
                        <th class="py-3 px-4 text-center">Tanggal</th>
                        <th class="py-3 px-4 text-center">Tingkat</th>
                        <th class="py-3 px-4 text-center">Nama Jalan</th>
                        <th class="py-3 px-4 text-center">Penyebab</th>
                        <th class="py-3 px-4 text-center">MD / LB / LR</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs md:text-sm font-light">
                    @forelse ($kecelakaan as $index => $data)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $kecelakaan->firstItem() + $index }}</td>
                        <td class="py-3 px-4 text-center">{{ $data->tanggal_dilaporkan }}</td>
                        <td class="py-3 px-4 text-center">{{ $data->tingkat_kecelakaan }}</td>
                        <td class="py-3 px-4 text-center">{{ $data->nama_jalan }}</td>
                        <td class="py-3 px-4 text-center">{{ $data->penyebab }}</td>
                        <td class="py-3 px-4 text-center">
                            {{ $data->md }} / {{ $data->lb }} / {{ $data->lr }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">
                            Data kecelakaan belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6 flex justify-center">
                {{ $kecelakaan->appends(['per_page' => request('per_page')])->links() }}
            </div>

        </div>
    </div>
</section>
@endsection