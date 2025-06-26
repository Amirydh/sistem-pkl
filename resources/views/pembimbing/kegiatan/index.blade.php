<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jurnal Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        Ini adalah daftar semua kegiatan yang dikirimkan oleh peserta bimbingan Anda.
                    </p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul Kegiatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($kegiatans as $kegiatan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kegiatan->peserta->user->name }}
                                        <div class="flex-shrink-0 h-10 w-10">
                                            {{-- Tampilkan foto profil, atau default jika tidak ada --}}
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $kegiatan->peserta->user->profile_photo_base64 }}" alt="{{ $kegiatan->peserta->user->name }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kegiatan->tanggal->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $kegiatan->judul_kegiatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($kegiatan->status == 'disetujui')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @elseif ($kegiatan->status == 'ditolak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- Link ini mengarah ke halaman detail jurnal milik peserta terkait --}}
                                        <a href="{{ route('pembimbing.kegiatan.show', $kegiatan->peserta) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">
                                            Lihat & Validasi
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada kegiatan yang perlu divalidasi saat ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $kegiatans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>