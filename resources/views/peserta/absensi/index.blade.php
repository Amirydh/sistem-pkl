<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Semua Riwayat Absensi Anda</h3>
                        <a href="{{ route('peserta.absensi.create') }}">
                            <x-primary-button>{{ __('+ Isi Absensi Hari Ini') }}</x-primary-button>
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="mb-4 text-sm font-medium text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800 p-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayatAbsensi as $absen)
                                    <tr class="dark:bg-gray-800">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $absen->tanggal_absensi->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $absen->status }}</td>
                                        <td class="px-6 py-4">{{ $absen->keterangan ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($absen->bukti)
                                                <a href="{{ asset('storage/' . $absen->bukti) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                                    Lihat
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada riwayat absensi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $riwayatAbsensi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>