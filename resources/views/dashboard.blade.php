@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Users</h2>
            <p class="mt-2 text-2xl font-bold text-blue-600">1,245</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Products</h2>
            <p class="mt-2 text-2xl font-bold text-green-600">320</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Reports</h2>
            <p class="mt-2 text-2xl font-bold text-red-600">57</p>
        </div>
    </div>

    <!-- Table -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Recent Users</h2>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="px-4 py-2">John Doe</td>
                    <td class="px-4 py-2">john@example.com</td>
                    <td class="px-4 py-2">Admin</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2">Jane Smith</td>
                    <td class="px-4 py-2">jane@example.com</td>
                    <td class="px-4 py-2">User</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
