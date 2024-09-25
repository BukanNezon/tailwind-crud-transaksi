<div class="container mx-auto p-8 max-w-4xl bg-white shadow-md rounded-lg">
    <h1 class="mb-4 text-2xl font-semibold text-center">Kategori</h1>

    <div class="flex justify-between mb-4">
        <!-- Search Bar -->
        <div class="w-1/2">
            <input type="text" class="border rounded w-full py-2 px-3" placeholder="Search transactions..." wire:model.live="search">
        </div>
    </div>

    <table class="min-w-full table-auto bg-white border border-gray-300">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th scope="col" class="py-2 border border-gray-300">No</th>
                <th scope="col" class="py-2 border border-gray-300 text-center" style="width: 70%">Nama Kategori</th>
                <th scope="col" class="py-2 border border-gray-300 text-center" style="width: 15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori as $category)
                <tr class="border-b">
                    <td class="py-2 text-center border border-gray-300">{{ $loop->iteration }}</td>
                    <td class="py-2 text-center border border-gray-300 truncate" style="max-width: 150px;">{{ $category->name }}</td>
                    <td class="text-center py-2 border border-gray-300">
                        <button wire:click="$dispatch('kategoriEdit', {kategori: {{ $category->id }}})" class="bg-yellow-500 text-white rounded px-2 py-1 hover:bg-yellow-600">Update</button>
                        <button @click="$dispatch('product-delete', {get_id: '{{ $category->id }}' })" class="bg-red-500 text-white rounded px-2 py-1 hover:bg-red-600">DELETE</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border border-gray-300 text-center px-4 py-2">Tidak Ada Kategori</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $kategori->links('pagination::tailwind') }}
    </div>

    <x-product-delete />
</div>
