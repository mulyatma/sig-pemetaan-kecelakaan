<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIG Kecelakaan Kab Brebes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('styles')
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-gray-800">BREBES</a>
            <button id="menu-toggle" class="md:hidden text-gray-700 focus:outline-none">☰</button>
            <div id="menu" class="hidden md:flex space-x-4">
                <a href="/" class="text-gray-700 hover:text-blue-500 px-4">Home</a>
                <a href="{{ route('kecelakaan.index') }}" class="text-gray-700 hover:text-blue-500 px-4">Data Kecelakaan</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white p-4">
            <a href="/" class="block text-gray-700 hover:text-blue-500 py-2">Home</a>
            <a href="{{ route('kecelakaan.index') }}" class="block text-gray-700 hover:text-blue-500 py-2">Data Kecelakaan</a>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-blue-500 text-white py-6 text-center">
        <p class="text-sm">© 2025 Brebes. All rights reserved.</p>
    </footer>

    @stack('scripts')

</body>

</html>