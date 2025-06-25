<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Peserta Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.peserta.store') }}">
                        @csrf
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akun Login</h3>
                        
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>

                        <hr class="my-6">

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Profil Peserta</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nisn" :value="__('NISN')" />
                                <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn')" required />
                                <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="asal_sekolah" :value="__('Instansi Pendidikan')" />
                                <x-text-input id="asal_sekolah" class="block mt-1 w-full" type="text" name="asal_sekolah" :value="old('asal_sekolah')" required />
                                <x-input-error :messages="$errors->get('asal_sekolah')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="kelas" :value="__('Kelas')" />
                                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas')" required />
                                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jurusan" :value="__('Jurusan')" />
                                <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan" :value="old('jurusan')" required />
                                <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="telepon" :value="__('Telepon (Opsional)')" />
                                <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" :value="old('telepon')" />
                                <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pembimbing_id" :value="__('Pilih Pembimbing (Opsional)')" />
                                <select name="pembimbing_id" id="pembimbing_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach ($pembimbings as $pembimbing)
                                        <option value="{{ $pembimbing->id }}" @if(old('pembimbing_id') == $pembimbing->id) selected @endif>{{ $pembimbing->user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('pembimbing_id')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="lokasi_pkl_id" :value="__('Pilih Lokasi PKL (Opsional)')" />
                                <select name="lokasi_pkl_id" id="lokasi_pkl_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach ($lokasiPkls as $lokasi)
                                        <option value="{{ $lokasi->id }}" @if(old('lokasi_pkl_id') == $lokasi->id) selected @endif>{{ $lokasi->nama_tempat }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('lokasi_pkl_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.peserta.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>