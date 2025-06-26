<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Peserta Bimbingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asal Sekolah/Kampus</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Validasi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($pesertas as $peserta)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $peserta->user->name }}
                                        <div class="flex-shrink-0 h-10 w-10">
                                            {{-- Tampilkan foto profil, atau default jika tidak ada --}}
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $peserta->user->profile_photo_base64 }}" alt="{{ $peserta->user->name }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $peserta->asal_sekolah }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($peserta->kegiatan_menunggu_count > 0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $peserta->kegiatan_menunggu_count }} Perlu Validasi
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Semua Tervalidasi
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('pembimbing.kegiatan.show', $peserta) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">
                                            Lihat Jurnal
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Anda belum memiliki peserta bimbingan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pesertas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>