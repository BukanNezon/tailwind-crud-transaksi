<div x-data="{open:false}" x-show="open"
    @product-delete.window="
        const get_id = event.detail.get_id;

        Swal.fire({
            title: 'Are you sure?',
            text: 'You wont be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
            $wire.hapus(get_id).then(result => {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your product has been deleted.',
                    icon: 'success'
                });
            })
            }
        });
    "
>
</div>
                
                {{-- $wire.hapus(get_id); --}}
        {{-- $wire.hapus(id); --}}
            {{-- alert(id) --}}
            {{-- $wire.hapus(id).then(() => {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your post has been deleted.',
                    icon: 'success'
                });
            }); --}}