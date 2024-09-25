<div class="container mx-auto p-8 max-w-4xl bg-white shadow-md rounded-lg">
    <h1 class="mb-4 text-2xl font-semibold text-center">Product</h1>

    <div class="flex justify-between mb-4">
        <!-- Search Bar -->
        <div class="w-1/2">
            <input type="text" class="border rounded w-full py-2 px-3" placeholder="Search transactions..." wire:model.live="search">
        </div>
    </div>
    <table class="min-w-full border border-gray-300">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="border border-gray-300 px-4 py-2">No</th>
                <th class="border border-gray-300 px-4 py-2">Nama Product</th>
                <th class="border border-gray-300 px-4 py-2">Deskripsi</th>
                <th class="border border-gray-300 px-4 py-2">Jumlah Produk</th>
                <th class="border border-gray-300 px-4 py-2">Harga</th>
                <th class="border border-gray-300 px-4 py-2">Kategori</th>
                <th class="border border-gray-300 px-4 py-2">Gambar</th>
                <th class="border border-gray-300 px-4 py-2" style="width: 15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{!! $product->deskripsi !!}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->jumlah }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->harga }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->kategori->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 text-center px-4 py-2">
                        <img src="{{ Storage::url($product->image) }}" class="rounded" style="width: 150px">
                    </td>
                    <td class="border border-gray-300 text-center px-4 py-2">
                        <button wire:click="$dispatch('productEdit', {product: {{ $product->id }}})" class="bg-yellow-500 text-white rounded px-2 py-1">Update</button>
                        <button @click="$dispatch('product-delete', {get_id: '{{ $product->id }}' })" class="bg-red-500 text-white rounded px-2 py-1">DELETE</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="border border-gray-300 text-center px-4 py-2">Tidak Ada Produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $products->links('pagination::tailwind') }}
    </div>
    <x-product-delete />
</div>





{{-- <div>
    <table class="table table-bordered">
        <thead class="bg-dark text-white">
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col" style="width: 15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
            <tr>
                <td class="text-center">
                    <img src="{{ asset('/storage/posts/'.$post->image) }}" class="rounded" style="width: 150px">
                </td>
                <td>{{ $post->title }}</td>
                <td>{!! $post->content !!}</td>
                <td class="text-center">
                    <a href="/edit/{{ $post->id }}" wire:navigate class="btn btn-sm btn-primary">EDIT</a>
                    <button wire:click="destroy({{ $post->id }})" class="btn btn-sm btn-danger">DELETE</button>
                </td>
            </tr>
            @empty
            <div class="alert alert-danger">
                Data Post belum Tersedia.
            </div>
            @endforelse
        </tbody>
    </table>
    {{ $posts->links('vendor.pagination.bootstrap-5') }}
</div> --}}