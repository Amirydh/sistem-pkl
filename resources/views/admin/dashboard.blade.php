<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Layout Utama Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Utama (Lebar) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Kartu Statistik -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <!-- Card Total Peserta -->
                        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center space-x-4">
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <!-- Heroicon: users -->
                                <svg class="w-8 h-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-2.305l-2.501-1.389A8.369 8.369 0 0115 19.128v0zM11.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0v0zM11.25 4.507v10.742A8.354 8.354 0 0015 19.542V8.25A2.25 2.25 0 0012.75 6H11.25zM15 3.75a2.25 2.25 0 00-2.25 2.25V7.5H15V3.75z" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 19.5a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Peserta</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalPeserta }}</p>
                            </div>
                        </div>
                        <!-- Card Total Pembimbing -->
                        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center space-x-4">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <!-- Heroicon: academic-cap -->
                                <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75-13.5L12 3m0 0l3.75 5.25M12 3v12.75" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Pembimbing</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalPembimbing }}</p>
                            </div>
                        </div>
                         <!-- Card Total Lokasi -->
                        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center space-x-4">
                           <div class="bg-green-100 p-3 rounded-full">
                                <!-- Heroicon: building-office-2 -->
                                <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.375a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v-1.5A.75.75 0 019 6.75zM9 12.75h6.375a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v-1.5a.75.75 0 01.75-.75z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Lokasi</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalLokasi }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card Aktivitas Terbaru -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aktivitas Terbaru</h3>
                        <div class="space-y-4">
                            @forelse ($aktivitasTerbaru as $user)
                                <div class="flex items-center space-x-3">
                                    <span class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                    <div class="flex-grow">
                                        <p class="text-sm text-gray-800"><span class="font-bold">{{ $user->name }}</span> ditambahkan sebagai {{ $user->role }}.</p>
                                        <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada aktivitas terbaru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Kolom Samping (Sempit) -->
                <div class="space-y-6">
                    <!-- Card Tindakan Cepat -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tindakan Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.peserta.create') }}" class="w-full">
                                <x-secondary-button class="w-full justify-center">{{ __('Tambah Peserta') }}</x-secondary-button>
                            </a>
                             <a href="{{ route('admin.pembimbing.create') }}" class="w-full">
                                <x-secondary-button class="w-full justify-center">{{ __('Tambah Pembimbing') }}</x-secondary-button>
                            </a>
                            <a href="{{ route('admin.lokasi-pkl.create') }}" class="w-full">
                                <x-secondary-button class="w-full justify-center">{{ __('Tambah Ruangan') }}</x-secondary-button>
                            </a>
                        </div>
                    </div>

                    <!-- Card Perlu Tindakan -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Perlu Validasi <span class="text-sm font-bold text-white bg-yellow-500 rounded-full px-2 py-0.5 ml-2">{{ $kegiatanMenungguCount }}</span></h3>
                        <p class="text-sm text-gray-500 mb-4">Daftar peserta dengan kegiatan yang menunggu persetujuan.</p>
                        <div class="space-y-3">
                            @forelse ($pesertaMenungguValidasi as $peserta)
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-800">{{ $peserta->user->name }}</p>
                                    <span class="text-xs font-semibold text-yellow-800 bg-yellow-200 px-2 py-1 rounded-md">{{ $peserta->kegiatan_menunggu_count }} kegiatan</span>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Semua Beres!</h3>
                                    <p class="mt-1 text-sm text-gray-500">Tidak ada kegiatan yang perlu validasi saat ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>