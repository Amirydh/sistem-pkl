<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Penugasan Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        Gunakan halaman ini untuk menugaskan Pembimbing dan Lokasi PKL kepada setiap peserta secara massal.
                    </p>

                    @if (session('success'))
                        <div class="mb-4 text-sm font-medium text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800 p-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.penugasan.store') }}">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama Peserta</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tugaskan Pembimbing</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tugaskan Lokasi PKL</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($pesertas as $peserta)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $peserta->user->name }}</td>
                                            <td class="px-6 py-4">
                                                {{-- Dropdown untuk Pembimbing --}}
                                                <select name="pembimbing_id[{{ $peserta->id }}]" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                    <option value="">-- Pilih Pembimbing --</option>
                                                    @foreach ($pembimbings as $pembimbing)
                                                        <option value="{{ $pembimbing->id }}" @selected($peserta->pembimbing_id == $pembimbing->id)>
                                                            {{ $pembimbing->user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Dropdown untuk Lokasi PKL --}}
                                                <select name="lokasi_pkl_id[{{ $peserta->id }}]" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                    <option value="">-- Pilih Lokasi --</option>
                                                    @foreach ($lokasiPkls as $lokasi)
                                                        <option value="{{ $lokasi->id }}" @selected($peserta->lokasi_pkl_id == $lokasi->id)>
                                                            {{ $lokasi->nama_tempat }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-end mt-6">
                            <x-primary-button type="submit">
                                {{ __('Simpan Semua Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>