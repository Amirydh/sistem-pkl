<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Absensi Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('peserta.absensi.store') }}" enctype="multipart/form-data" x-data="{ status: 'Hadir' }">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_absensi" :value="__('Tanggal Absensi')" />
                                <x-text-input id="tanggal_absensi" class="block mt-1 w-full" type="date" name="tanggal_absensi" :value="old('tanggal_absensi', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_absensi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status Kehadiran')" />
                                <select x-model="status" id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div x-show="status === 'Sakit' || status === 'Izin'" x-transition class="mt-6 space-y-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan (Wajib diisi untuk Sakit/Izin)')" />
                                <textarea id="keterangan" name="keterangan" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('keterangan') }}</textarea>
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="bukti" :value="__('Upload Bukti (Surat Dokter, dll)')" />
                                <input id="bukti" name="bukti" type="file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                <x-input-error :messages="$errors->get('bukti')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('peserta.absensi.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">{{ __('Kembali ke Riwayat') }}</a>
                            <x-primary-button>
                                {{ __('Kirim Absensi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>