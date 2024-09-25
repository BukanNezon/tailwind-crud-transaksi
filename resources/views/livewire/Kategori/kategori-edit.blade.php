<div x-data="{ open: false }" x-init="@this.on('xxx', () => { open = true })">
    <!-- Modal Overlay -->
    <div x-show="open" class="fixed inset-0 bg-gray-600 bg-opacity-50" style="display: none;" x-transition aria-hidden="true"></div>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center" style="display: none;" x-transition>
        <div class="bg-white rounded shadow-lg w-1/3">
            <div class="p-4 border-b">
                <h1 class="text-lg font-semibold" id="updateModalLabel">Edit Kategori</h1>
                <button type="button" class="absolute top-2 right-2" @click="open = false">✖</button>
            </div>
            <div class="p-4">
                <form wire:submit.prevent="kategoriUpdate">
                    <div class="mb-4">
                        <label for="name" class="font-bold">Nama Kategori</label>
                        <input type="text" class="mt-1 block w-full border @error('name') border-red-500 @enderror rounded p-2" id="name" wire:model="name">
                        @error('name')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="p-4 border-t flex justify-between">
                <button type="button" class="bg-gray-400 text-white rounded px-4 py-2" @click="open = false">Close</button>
                <button type="button" class="bg-yellow-500 text-white rounded px-4 py-2" wire:click="kategoriUpdate">Update</button>
            </div>
        </div>
    </div>

    @push('script')
    @endpush
</div>




{{-- <script>
    // gunakan variable global untuk parsing dari alpinejs
    let post_content_edit;
    ClassicEditor
        .create(document.querySelector('#content_edit'))
        .then(editor_edit  => {
            post_content_edit = editor_edit
            editor_edit.model.document.on('change:data', () => {
                @this.set('content', editor_edit.getData());
            })
        });
</script> --}}