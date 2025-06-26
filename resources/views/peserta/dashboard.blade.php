<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Info & Aksi -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Welcome Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                Selamat Datang, {{ Auth::user()->name }}!
                            </h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">
                                Ini adalah halaman utama Anda untuk mengelola jurnal kegiatan PKL.
                            </p>
                            @if (session('warning'))
                            <div class="mb-4 text-sm text-yellow-800 bg-yellow-100 p-3 rounded-lg">
                                {{ session('warning') }}
                            </div>
                            @endif
                            <div class="mt-6">
                                <a href="{{ route('peserta.kegiatan.create') }}">
                                    <x-primary-button>
                                        {{ __('+ Tambah Kegiatan Baru') }}
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pembimbing & Lokasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300">Pembimbing Anda</h4>
                            <p class="text-lg text-gray-900 dark:text-gray-100 mt-1">
                                {{ $peserta->pembimbing->user->name ?? 'Belum Ditentukan' }}
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300">Lokasi PKL</h4>
                            <p class="text-lg text-gray-900 dark:text-gray-100 mt-1">
                                {{ $peserta->lokasiPkl->nama_tempat ?? 'Belum Ditentukan' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Statistik -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm space-y-4">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Ringkasan Kegiatan</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Total Kegiatan</span>
                            <span class="font-bold text-blue-500">{{ $totalKegiatan }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Disetujui</span>
                            <span class="font-bold text-green-500">{{ $kegiatanDisetujui }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Menunggu Persetujuan</span>
                            <span class="font-bold text-yellow-500">{{ $kegiatanMenunggu }}</span>
                        </div>
                    </div>
                    <hr class="dark:border-gray-600">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 pt-2">Kegiatan Terbaru</h4>
                    <div class="space-y-3">
                        @forelse ($kegiatanTerbaru as $kegiatan)
                        <div class="text-sm">
                            <p class="text-gray-800 dark:text-gray-200 truncate">{{ $kegiatan->judul_kegiatan }}</p>
                            <p class="text-xs text-gray-500">{{ $kegiatan->tanggal->format('d M Y') }}</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada kegiatan.</p>
                        @endforelse
                    </div>
                    <div class="pt-4">
                        <a href="{{ route('peserta.kegiatan.index') }}" class="w-full">
                            <x-secondary-button class="w-full justify-center">{{ __('Lihat Semua Kegiatan') }}</x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>