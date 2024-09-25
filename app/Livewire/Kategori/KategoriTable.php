<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class KategoriTable extends Component
{
    use WithPagination;
    
    public $paginate = 5;
    public $search;

    #[On('xxx')]
    public function render()
    {
        if (!$this->search) {
            $kategori = Kategori::latest()->paginate($this->paginate);
        } else {
            $kategori = Kategori::where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);
        }

        return view('livewire.kategori.kategori-table', [
            'kategori' => $kategori,
        ]);
    }

    public function hapus($get_id)
    {
        try {
            $kategori = Kategori::find($get_id);
            $kategori->delete();

            $this->dispatch('sweet-alert', title: 'Kategori Berhasil Dihapus', icon: 'success');
        } catch (\Exception $e) {
            $this->dispatch('sweet-alert', title: 'Kategori Gagal Dihapus', icon: 'error');
        }
    }
}
