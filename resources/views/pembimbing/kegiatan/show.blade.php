<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Jurnal Kegiatan: {{ $peserta->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('pembimbing.dashboard') }}" class="inline-flex items-center mb-4 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>

            @if (session('success'))
                <div class="mb-4 text-sm font-medium text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800 p-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse ($kegiatans as $kegiatan)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Kolom Info Kegiatan -->
                            <div class="md:col-span-2 space-y-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $kegiatan->judul_kegiatan }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                                    </div>
                                    <div>
                                         @if ($kegiatan->status == 'disetujui')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @elseif ($kegiatan->status == 'ditolak')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <p class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-wrap">{{ $kegiatan->deskripsi }}</p>

                                @if($kegiatan->foto)
                                    <div>
                                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Bukti Foto:</p>
                                        <a href="{{ asset('storage/' . $kegiatan->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="Foto Kegiatan" class="w-full md:w-96 h-auto rounded-lg shadow-md hover:opacity-80 transition-opacity">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Kolom Validasi -->
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">Validasi & Feedback</h4>
                                @if($kegiatan->status == 'menunggu persetujuan')
                                    <form method="POST" action="{{ route('pembimbing.kegiatan.validasi', $kegiatan) }}">
                                        @csrf
                                        <div>
                                            <label for="feedback_pembimbing_{{ $kegiatan->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Feedback (Opsional)</label>
                                            <textarea id="feedback_pembimbing_{{ $kegiatan->id }}" name="feedback_pembimbing" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                        </div>
                                        <div class="flex space-x-2 mt-4">
                                            <button type="submit" name="status" value="disetujui" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Setujui
                                            </button>
                                            <button type="submit" name="status" value="ditolak" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Tolak
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-md">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Feedback Anda:</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">
                                            {{ $kegiatan->feedback_pembimbing ?? 'Tidak ada feedback yang diberikan.' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Peserta ini belum menambahkan kegiatan apapun.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $kegiatans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>