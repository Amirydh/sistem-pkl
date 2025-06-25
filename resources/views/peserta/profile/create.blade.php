{{-- resources/views/peserta/profile/create.blade.php --}}
<x-guest-layout>
    {{-- Menggunakan div pembungkus yang lebih lebar untuk form yang lebih panjang --}}
    <div class="w-full sm:max-w-lg mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

        <div class="text-center mb-8">
            {{-- Menambahkan logo Laravel di atas form --}}
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500 inline-block" />
                </a>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-4">Lengkapi Profil Anda</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Silakan isi semua data di bawah ini untuk melanjutkan.
            </p>
        </div>

        <!-- Tampilkan pesan warning jika ada -->
        @if (session('warning'))
            <div class="mb-4 text-sm text-yellow-800 bg-yellow-100 p-3 rounded-lg">
                {{ session('warning') }}
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.profile.store') }}">
            @csrf

            <!-- NISN -->
            <div>
                <x-input-label for="nisn" :value="__('NISN')" />
                <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn')"
                    required autofocus />
                <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
            </div>

            <!-- Asal Sekolah -->
            <div class="mt-4">
                <x-input-label for="asal_sekolah" :value="__('Asal Sekolah / Kampus')" />
                <x-text-input id="asal_sekolah" class="block mt-1 w-full" type="text" name="asal_sekolah"
                    :value="old('asal_sekolah')" required placeholder="Contoh: SMK Negeri 1 Jakarta" />
                <x-input-error :messages="$errors->get('asal_sekolah')" class="mt-2" />
            </div>

            <!-- =================================================================== -->
            <!-- ==                    BAGIAN YANG HILANG                         == -->
            <!-- =================================================================== -->

            <!-- Kelas -->
            <div class="mt-4">
                <x-input-label for="kelas" :value="__('Kelas')" />
                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas')"
                    required placeholder="Contoh: XII TKJ 1" />
                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
            </div>

            <!-- Jurusan -->
            <div class="mt-4">
                <x-input-label for="jurusan" :value="__('Jurusan')" />
                <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan" :value="old('jurusan')"
                    required placeholder="Contoh: Teknik Komputer dan Jaringan" />
                <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
            </div>

            <!-- Telepon -->
            <div class="mt-4">
                <x-input-label for="telepon" :value="__('Nomor Telepon')" />
                <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" :value="old('telepon')"
                    required placeholder="0883243863" />
                <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
            </div>

            <!-- =================================================================== -->
            <!-- ==                      AKHIR BAGIAN HILANG                    == -->
            <!-- =================================================================== -->

            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('SIMPAN DAN LANJUTKAN') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
