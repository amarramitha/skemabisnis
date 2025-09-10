<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="h-screen flex bg-gray-100 overflow-hidden">
    <!-- Sidebar -->
    <aside
        class="group w-16 hover:w-64 flex-shrink-0 bg-red-600 text-white flex flex-col 
           transition-[width] duration-500 ease-in-out overflow-hidden overflow-x-hidden">

        <!-- Logo / Title -->
        <div class="p-4 text-xl font-bold border-b border-red-700 truncate flex items-center gap-2">
            <i data-lucide="layout-dashboard" class="w-6 h-6 group-hover:hidden"></i>
            <span class="hidden group-hover:inline">Admin Panel</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-2 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors duration-200
            {{ request()->routeIs('dashboard') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="home" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline">Dashboard</span>
            </a>

            <!-- Master Data -->
            <div>
                <a href="{{ route('masterdata') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-200
                {{ request()->routeIs('masterdata') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                    <i data-lucide="database" class="w-5 h-5"></i>
                    <span class="hidden group-hover:inline">Master Data</span>
                </a>

                <!-- Submenu -->
                <a href="{{ route('masterdata.input') }}"
                    class="ml-8 flex items-center gap-2 px-3 py-1.5 rounded-md text-sm transition-all duration-200
                {{ request()->routeIs('masterdata.input') ? 'bg-red-700 text-white font-semibold shadow' : 'text-gray-200 hover:bg-red-700 hover:text-white' }}">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span class="hidden group-hover:inline">Input Data</span>
                </a>
            </div>

            <a href="{{ route('penawaran') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-200
            {{ request()->routeIs('penawaran') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline">Penawaran</span>
            </a>

            <a href="{{ route('riwayat') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-md transition-all duration-200
            {{ request()->routeIs('riwayat') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="history" class="w-5 h-5"></i>
                <span class="hidden group-hover:inline">Riwayat</span>
            </a>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t border-red-700">
            <div class="mb-2">
                <div class="font-medium hidden group-hover:block">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-sm text-gray-300 hidden group-hover:block">{{ Auth::user()->email ?? 'admin@example.com' }}</div>
                <i data-lucide="user" class="w-6 h-6 group-hover:hidden"></i>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-red-600 bg-white font-medium transition hover:bg-red-500 hover:text-white">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="hidden group-hover:inline">Log Out</span>
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