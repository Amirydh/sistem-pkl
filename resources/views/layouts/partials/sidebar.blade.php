{{-- File: resources/views/layouts/partials/sidebar.blade.php --}}

<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    :class="{ 'translate-x-0': mobileSidebarOpen }" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium mt-4">

            {{-- Menu Utama (Umum untuk Semua Role) --}}
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    @click="mobileSidebarOpen = false">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.934A8.5 8.5 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            {{-- Menu Berdasarkan Role --}}

            {{-- MENU ADMIN --}}
            @if (Auth::user()->role == 'admin')
                <li class="pt-2">
                    <span class="px-2 text-xs font-semibold text-gray-500 uppercase">Manajemen Admin</span>
                </li>
                <li>
                    <a href="{{ route('admin.penugasan.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.penugasan.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Penugasan Peserta</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.peserta.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.peserta.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Manajemen Peserta</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pembimbing.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.pembimbing.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Manajemen Pembimbing</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.lokasi-pkl.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.lokasi-pkl.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Manajemen Lokasi PKL</span>
                    </a>
                </li>
            @endif


            {{-- MENU PEMBIMBING --}}
            {{-- VERSI BARU --}}
            @if (Auth::user()->role == 'pembimbing')
                {{-- di dalam @if (Auth::user()->role == 'pembimbing') --}}
                <li class="pt-2">
                    <span class="px-2 text-xs font-semibold text-gray-500 uppercase">Menu Pembimbing</span>
                </li>
                <li>
                    <a href="{{ route('pembimbing.dashboard') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('pembimbing.dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Daftar Peserta</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pembimbing.kegiatan.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('pembimbing.kegiatan.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Validasi Kegiatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pembimbing.absensi.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('pembimbing.absensi.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Daftar Absensi</span>
                    </a>
                </li>
            @endif

            {{-- MENU PESERTA --}}
            {{-- VERSI BARU YANG SUDAH DIPERBAIKI --}}
            @if (Auth::user()->role == 'peserta')
                <li class="pt-2">
                    <span class="px-2 text-xs font-semibold text-gray-500 uppercase">Menu Peserta</span>
                </li>
                <li>
                    <a href="{{ route('peserta.absensi.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('peserta.absensi.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Absensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('peserta.kegiatan.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('peserta.kegiatan.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        @click="mobileSidebarOpen = false">
                        <span class="flex-1 ml-3 whitespace-nowrap">Jurnal Kegiatan</span>
                    </a>
                </li>
            @endif

            {{-- Menu Akun (Umum untuk Semua Role) --}}
            <li class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('profile.edit') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    @click="mobileSidebarOpen = false">
                    {{-- ================================================ --}}
                    {{-- ==              IKON YANG DIGANTI             == --}}
                    {{-- ================================================ --}}
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Profil Saya</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Log Out</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>
