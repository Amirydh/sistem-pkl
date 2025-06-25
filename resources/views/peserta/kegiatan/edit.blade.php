<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('peserta.kegiatan.update', $kegiatan) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Tanggal -->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Kegiatan')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal', $kegiatan->tanggal)" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Judul Kegiatan -->
                        <div class="mt-4">
                            <x-input-label for="judul_kegiatan" :value="__('Judul Kegiatan')" />
                            <x-text-input id="judul_kegiatan" class="block mt-1 w-full" type="text" name="judul_kegiatan" :value="old('judul_kegiatan', $kegiatan->judul_kegiatan)" required autofocus />
                            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi Kegiatan')" />
                            <textarea id="deskripsi" name="deskripsi" rows="5" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                        
                        <!-- Foto -->
                        <div class="mt-4">
                            <x-input-label for="foto" :value="__('Upload Foto Baru (Opsional)')" />
                             @if($kegiatan->foto)
                                <div class="my-2">
                                    <p class="text-sm text-gray-500">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="Foto Kegiatan" class="w-48 h-auto rounded-lg shadow-md">
                                </div>
                             @endif
                            <input id="foto" name="foto" type="file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah foto.</small>
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('peserta.kegiatan.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Kegiatan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>