<?php

namespace App\Livewire\Kategori;

use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Kategori;
use Livewire\Component;

class KategoriEdit extends Component
{
    public Kategori $kategori;

    #[Validate('required', message: 'Masukkan Nama Kategori')]
    public $name;

    #[On('kategoriEdit')]
    public function load_data(Kategori $kategori)
    {
        $this->kategori = $kategori;
        $this->name = $kategori->name;
        
        $this->dispatch('xxx'); 
    }

    public function mount(Kategori $kategori)
    {
        // Menginisialisasi properti $kategori
        $this->kategori = $kategori;
        $this->name = $kategori->name;
    }

    public function kategoriUpdate()
    {
        $this->validate();

        try {
            $this->kategori->update(['name' => $this->name]); 

            $this->dispatch('xxx'); 
            $this->dispatch('sweet-alert', title: 'Kategori Berhasil Diubah', icon: 'success');
        } catch (\Throwable $th) {
            $this->dispatch('sweet-alert', title: 'Data Gagal Diubah', icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.kategori.kategori-edit', [
            'kategori' => $this->kategori,
        ]);
    }
}
