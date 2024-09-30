<div x-data="{ open: false }">
    <div class="flex justify-center">
        <!-- Button trigger modal -->
        <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded" @click="open = true">
            Tambah Product
        </button>
    </div>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50" style="display: none;" @click.outside="open = false" x-transition aria-hidden="true">
        <div class="bg-white rounded shadow-lg w-1/3">
            <div class="p-4 border-b">
                <h1 class="text-lg font-semibold" id="kategoriModalLabel">Tambah Kategori</h1>
            </div>
            <div class="p-4">
                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label class="font-bold">Nama Kategori</label>
                        <input id="kategoriInput" type="text" class="mt-1 block w-full border @error('name') border-red-500 @enderror rounded p-2" wire:model="name" placeholder="Masukkan Nama Kategori">
                        @error('name')
                        <div class="text-red-500 mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="p-4 border-t flex justify-between">
                        <button type="button" class="bg-gray-400 text-white rounded px-4 py-2" @click="open = false">Close</button>
                        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Add Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    const myModal = document.getElementById('kategoriModal')
    const myInput = document.getElementById('kategoriInput')

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    })
</script> --}}

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