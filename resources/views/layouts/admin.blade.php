<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="h-screen flex bg-gray-100 overflow-hidden">
    <!-- Sidebar -->
    <aside
        class="group w-16 hover:w-64 flex-shrink-0 bg-red-600 text-white flex flex-col
           transition-all duration-500 ease-in-out overflow-hidden">

        <!-- Logo / Title -->
        <div
            class="p-4 text-xl font-bold border-b border-red-700 truncate flex items-center gap-2 transition-all duration-500 ease-in-out">
            <i data-lucide="layout-dashboard" class="w-6 h-6 group-hover:opacity-0 group-hover:translate-x-[-10px] transition-all duration-500"></i>
            <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 translate-x-[-10px] group-hover:translate-x-0 transition-all duration-500">
                Admin Panel
            </span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-2 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-300
            {{ request()->routeIs('dashboard') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="home" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">Dashboard</span>
            </a>

            <!-- Master Data -->
            <div>
                <a href="{{ route('masterdata') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-300
                {{ request()->routeIs('masterdata') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                    <i data-lucide="database" class="w-5 h-5"></i>
                    <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">Master Data</span>
                </a>

                <!-- Submenu -->
                <a href="{{ route('masterdata.inputkategori') }}"
                    class="ml-8 flex items-center gap-2 px-3 py-1.5 rounded-md text-sm transition-all duration-300
                {{ request()->routeIs('masterdata.inputkategori') ? 'bg-red-700 text-white font-semibold shadow' : 'text-gray-200 hover:bg-red-700 hover:text-white' }}">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-150">Input Kategori Produk</span>
                </a>
                <a href="{{ route('masterdata.inputproduk') }}"
                    class="ml-8 flex items-center gap-2 px-3 py-1.5 rounded-md text-sm transition-all duration-300
                {{ request()->routeIs('masterdata.inputproduk') ? 'bg-red-700 text-white font-semibold shadow' : 'text-gray-200 hover:bg-red-700 hover:text-white' }}">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-150">Input Produk</span>
                </a>
            </div>

            <a href="{{ route('penawaran.create') }}"
    class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-300
        {{ request()->routeIs('penawaran.create') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
    <i data-lucide="file-text" class="w-5 h-5"></i>
    <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">Penawaran</span>
</a>


            <a href="{{ route('penawaran.riwayat') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-300
            {{ request()->routeIs('riwayat') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="history" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">Riwayat</span>
            </a>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t border-red-700">
            <div class="mb-2 flex items-center gap-2">
                <i data-lucide="user" class="w-6 h-6 group-hover:hidden transition-all duration-500"></i>
                <div class="hidden group-hover:block transition-all duration-500 opacity-0 group-hover:opacity-100">
                    <div class="font-medium">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-sm text-gray-300">{{ Auth::user()->email ?? 'admin@example.com' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-red-600 bg-white font-medium transition-all duration-300 hover:bg-red-500 hover:text-white">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="hidden group-hover:inline opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center flex-shrink-0">
            <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
        </header>

        <!-- Content -->
        <div class="p-6 flex-1 overflow-y-auto">
            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
