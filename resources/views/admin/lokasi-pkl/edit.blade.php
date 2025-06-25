<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lokasi PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.lokasi-pkl.update', $lokasiPkl) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Nama Tempat -->
                        <div>
                            <x-input-label for="nama_tempat" :value="__('Nama Tempat')" />
                            <x-text-input id="nama_tempat" class="block mt-1 w-full" type="text" name="nama_tempat" :value="old('nama_tempat', $lokasiPkl->nama_tempat)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_tempat')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $lokasiPkl->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>
                        
                        <!-- Telepon -->
                        <div class="mt-4">
                            <x-input-label for="telepon" :value="__('Telepon (Opsional)')" />
                            <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" :value="old('telepon', $lokasiPkl->telepon)" />
                            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.lokasi-pkl.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>