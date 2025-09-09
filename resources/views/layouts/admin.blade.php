<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-red-600 text-white flex flex-col">
        <!-- Logo / Title -->
        <div class="p-4 text-xl font-bold border-b border-red-700">
            Admin Panel
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-md transition-all duration-200
                {{ request()->routeIs('dashboard') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="home" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('masterdata') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-md transition-all duration-200
                {{ request()->routeIs('masterdata') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="database" class="w-5 h-5"></i>
                Master Data
            </a>

            <a href="{{ route('penawaran') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-md transition-all duration-200
                {{ request()->routeIs('penawaran') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Penawaran
            </a>

            <a href="{{ route('riwayat') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-md transition-all duration-200
                {{ request()->routeIs('riwayat') ? 'bg-red-700 text-white font-bold shadow-md' : 'text-white hover:bg-red-700' }}">
                <i data-lucide="history" class="w-5 h-5"></i>
                Riwayat Transaksi
            </a>
        </nav>

        <!-- User info -->
        <div class="p-4 border-t border-red-700">
            <div class="mb-2">
                <div class="font-medium">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-sm text-gray-300">{{ Auth::user()->email ?? 'admin@example.com' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-red-600 bg-white font-medium transition hover:bg-red-500 hover:text-white">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col overflow-x-auto">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
        </header>

        <!-- Content -->
        <div class="p-6 min-w-full">
            @yield('content')
        </div>
    </main>

    <script>
    lucide.createIcons();
</script>


</body>

</html>
