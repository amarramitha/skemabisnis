<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-red-600 text-white flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-gray-700">
            Admin Panel
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-white rounded hover:bg-red-700 {{ request()->routeIs('dashboard') ? 'bg-red-600' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-white rounded hover:bg-red-700 {{ request()->routeIs('dashboard') ? 'bg-red-600' : '' }}">
                Master Data
            </a>
            <a href="{{ route('penawaran') }}"
                class="block px-4 py-2 text-white rounded hover:bg-red-700 {{ request()->routeIs('penawaran') ? 'bg-red-600' : '' }}">
                Penawaran
            </a>
            <a href="{{ route('riwayat') }}"
                class="block px-4 py-2 text-white rounded hover:bg-red-700 {{ request()->routeIs('riwayat') ? 'bg-red-600' : '' }}">
                Riwayat Transaksi
            </a>
            {{-- <a href="{{ route('users.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('users.*') ? 'bg-gray-700' : '' }}">
            Users
            </a>
            <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('products.*') ? 'bg-gray-700' : '' }}">
                Products
            </a>
            <a href="{{ route('reports.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('reports.*') ? 'bg-gray-700' : '' }}">
                Reports
            </a>
            <a href="{{ route('settings') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('settings') ? 'bg-gray-700' : '' }}">
                Settings
            </a> --}}
        </nav>

        <!-- User info -->
        <div class="p-4 border-t border-gray-700">
            <div class="mb-2">
                <div class="font-medium">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-sm text-gray-400">{{ Auth::user()->email ?? 'admin@example.com' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-gray-400 px-3 py-2 bg-white rounded hover:bg-red-500">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
        </header>

        <!-- Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>
</body>

</html>