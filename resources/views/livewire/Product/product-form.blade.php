<div x-data="{ open: false }">
    <div class="flex justify-center">
        <!-- Button trigger modal -->
        <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded" @click="open = true">
            Tambah Product
        </button>
    </div>

    <!-- Modal -->
    <div 
        x-show="open" 
        class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50 overflow-y-auto" 
        style="display: none;" 
        @click.outside="open = false" 
        x-transition 
        aria-hidden="true"
    >
        <div class="bg-white rounded shadow-lg w-1/3 relative">
            <div class="p-4 border-b">
                <h1 class="text-lg font-semibold" id="productModalLabel">Tambah Product</h1>
                <button type="button" class="absolute top-2 right-2" @click="open = false">✖</button>
            </div>
            <div class="p-4 max-h-[80vh] overflow-y-auto">
                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold">Nama Produk</label>
                        <input type="text" class="border border-gray-300 rounded p-2 w-full @error('name') border-red-500 @enderror" id="name" wire:model="name">
                        @error('name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                <!-- Product Description -->
                <div wire:ignore x-data="{ content: @entangle('deskripsi') }" x-init="$nextTick(() => {
                    ClassicEditor
                        .create($refs.deskripsi)
                        .then(newEditor => {
                            editor = newEditor;
                            editor.model.document.on('change:data', () => {
                                content = editor.getData();
                            });
                
                            $watch('content', value => {
                                if (value !== editor.getData()) {
                                    editor.setData(value);
                                }
                            });
                        });
                })">
                    <label for="deskripsi" class="text-sm font-bold">Product Description</label>
                    <textarea x-ref="deskripsi" x-model="content"
                        class="textarea textarea-bordered w-full @error('deskripsi') textarea-error @enderror"></textarea>
                    @error('deskripsi')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>


                    <div class="mb-4">
                        <br>
                        <label for="jumlah" class="block text-sm font-bold">Jumlah Produk</label>
                        <input type="number" class="border border-gray-300 rounded p-2 w-full @error('jumlah') border-red-500 @enderror" id="jumlah" wire:model="jumlah">
                        @error('jumlah')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="harga" class="block text-sm font-bold">Harga Produk</label>
                        <input type="number" class="border border-gray-300 rounded p-2 w-full @error('harga') border-red-500 @enderror" id="harga" wire:model="harga">
                        @error('harga')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="block text-sm font-bold">Kategori</label>
                        <select id="kategori" class="border border-gray-300 rounded p-2 w-full @error('kategori_id') border-red-500 @enderror" wire:model="kategori_id">
                            <option value="">Pilih Kategori</option>
                            @foreach($categoriesList as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-bold">Gambar Produk</label>
                        <input type="file" class="border border-gray-300 rounded p-2 w-full @error('image') border-red-500 @enderror" id="image" wire:model="image">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="mt-2 rounded" style="width:200px" />
                        @endif
                        
                        @error('image')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-4 border-t flex justify-between">
                        <button type="button" class="bg-gray-400 text-white rounded px-4 py-2" @click="open = false">Close</button>
                        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const myModal = document.getElementById('productModal');
    myModal.addEventListener('shown.bs.modal', () => {
        document.getElementById('name').focus();
    });

    if (window.editor) {
        editor.setData('');
    }
</script>




{{-- //     document.addEventListener('DOMContentLoaded', function() {
//     window.addEventListener('show-post-modal', event => {
//         $('#postModal').modal('show');
//     });

//     window.addEventListener('hide-modal', event => {
//         $('#postModal').modal('hide');

//         if (editor) {
//             editor.setData('');
//         }
//     });
// }); --}}