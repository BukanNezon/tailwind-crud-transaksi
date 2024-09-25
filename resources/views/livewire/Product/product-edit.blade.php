<div x-data="{ open: false }" x-init="@this.on('xxx', () => { open = true })">
    <!-- Modal Overlay -->
    <div x-show="open" class="fixed inset-0 bg-gray-600 bg-opacity-50" style="display: none;" x-transition aria-hidden="true"></div>

    <!-- Modal -->
    <div 
        wire.ignore.self
        x-show="open" 
        class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50 overflow-y-auto" 
        style="display: none;" 
        @click.outside="open = false" 
        x-transition 
        aria-hidden="true"
    >
        <div class="bg-white rounded shadow-lg w-1/3 relative max-h-screen">
            <div class="p-4 border-b sticky top-0 bg-white">
                <h1 class="text-lg font-semibold" id="updateModalLabel">Edit Product</h1>
                <button type="button" class="absolute top-2 right-2" @click="open = false">✖</button>
            </div>
            
            <div class="p-4 overflow-y-auto" style="max-height: 70vh;">
                <form wire:submit.prevent="productUpdate">

                    <div class="mb-4">
                        <label for="name" class="block font-bold">Nama Produk</label>
                        <input type="text" class="mt-1 block w-full border @error('name') border-red-500 @enderror rounded p-2" id="name" wire:model="name">
                        @error('name')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- CKEDITOR -->
                    <div wire:ignore x-data="{ deskripsi: $wire.entangle('deskripsi') }" wire:key="editor_edit"
                        @set-deskripsi.window="product_deskripsi_edit.setData(event.detail.deskripsi)">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                        <textarea wire:model="deskripsi" x-model="deskripsi" id="deskripsi_edit" class="form-control @error('deskripsi') is-invalid @enderror"></textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jumlah" class="block font-bold">Jumlah Produk</label>
                        <input type="number" class="mt-1 block w-full border @error('jumlah') border-red-500 @enderror rounded p-2" id="jumlah" wire:model="jumlah">
                        @error('jumlah')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="harga" class="block font-bold">Harga Produk</label>
                        <input type="number" class="mt-1 block w-full border @error('harga') border-red-500 @enderror rounded p-2" id="harga" wire:model="harga">
                        @error('harga')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="block font-bold">Kategori</label>
                        <select id="kategori" class="mt-1 block w-full border @error('kategori_id') border-red-500 @enderror rounded p-2" wire:model="kategori_id">
                            <option value="">Pilih Kategori</option>
                            @foreach($data_kategori as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Gambar Produk</label>
                        <input wire:model="image" type="file" class="mt-1 block w-full border @error('image') border-red-500 @enderror rounded p-2">
                        
                        @if ($image_db)
                            <div class="mt-3">
                                <img src="{{ asset('storage/images/' . $image_db) }}" alt="Current Image" class="block mb-2" width="200">
                                <small class="text-gray-500">{{ $image_db }}</small>
                            </div>
                        @endif
                    
                        @if ($image && !$errors->has('image') && is_object($image))
                            <div class="mt-3">
                                <img src="{{ $image->temporaryUrl() }}" alt="Updated Image" class="block mb-2" width="200">
                                <small class="text-gray-500">{{ $image->getClientOriginalName() }}</small>
                            </div>
                        @endif
                    
                        @error('image')
                            <div class="text- {{ $errors->has('image') ? 'red-500' : '' }} mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </form>
            </div>

            <div class="p-4 border-t flex justify-between">
                <button type="button" class="bg-gray-400 text-white rounded px-4 py-2" @click="open = false">Close</button>
                <button type="button" class="bg-yellow-500 text-white rounded px-4 py-2" wire:click="productUpdate">Update</button>
            </div>
        </div>
    </div>

    @push('script')
    @endpush
</div>

@push('script')
<script>
    let product_deskripsi_edit;
    ClassicEditor
        .create(document.querySelector('#deskripsi_edit'))
        .then(editor_edit => {
            product_deskripsi_edit = editor_edit;
            editor_edit.model.document.on('change:data', () => {
                @this.set('deskripsi', editor_edit.getData());
            });
        });
</script>
@endpush
