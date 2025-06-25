<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.pembimbing.create') }}">
                            <x-primary-button>{{ __('Tambah Pembimbing') }}</x-primary-button>
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 text-sm font-medium text-green-600 bg-green-100 p-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 py-2 w-1/4 max-w-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & Email</th>
                                    <th class="px-2 py-2 w-28 max-w-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                    <th class="px-2 py-2 w-32 max-w-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
                                    <th class="px-2 py-2 w-28 max-w-xs text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                                    <th class="px-2 py-2 w-24 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pembimbings as $pembimbing)
                                    <tr>
                                        <td class="px-2 py-2 whitespace-nowrap max-w-xs truncate">
                                            <div class="text-sm font-medium text-gray-900 truncate">{{ $pembimbing->user->name }}</div>
                                            <div class="text-sm text-gray-500 truncate">{{ $pembimbing->user->email }}</div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap max-w-xs truncate">{{ $pembimbing->nip ?? '-' }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap max-w-xs truncate">{{ $pembimbing->jurusan ?? '-' }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap max-w-xs truncate">{{ $pembimbing->telepon ?? '-' }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.pembimbing.edit', $pembimbing) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.pembimbing.destroy', $pembimbing) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Anda yakin ingin menghapus data ini? Menghapus pembimbing akan menghapus akun user terkait.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-2 py-2 text-center text-gray-500">
                                            Tidak ada data pembimbing.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pembimbings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>