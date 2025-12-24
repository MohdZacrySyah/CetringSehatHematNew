<x-admin-layout>
    <x-slot name="header">
        Statistik Ringkas
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pesanan</h4>
            <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Pendapatan</h4>
            <p class="text-3xl font-bold text-green-600 mt-2">Rp 0</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Menu Aktif</h4>
            <p class="text-3xl font-bold text-blue-600 mt-2">0</p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-bold mb-4">Aktivitas Terbaru</h3>
            <p class="text-gray-600">Belum ada aktivitas pesanan terbaru.</p>
        </div>
    </div>
</x-admin-layout>