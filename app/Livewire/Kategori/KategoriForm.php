<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\Attributes\Validate;

class KategoriForm extends Component
{
    #[Validate('required', message: 'Masukkan Nama Kategori')]
    public $name;

    public function render()
    {
        return view('livewire.kategori.kategori-form');
    }

    public function store()
    {
        $this->validate();

        try {
            Kategori::create([
                'name' => $this->name,
            ]);

            $this->reset(['name']);

            $this->dispatch('xxx');
            $this->dispatch('sweet-alert', title: 'Kategori Berhasil Disimpan', icon: 'success');
            $this->dispatch('editKategori');
        } catch (\Throwable $th) {
            $this->dispatch('sweet-alert', title: 'Kategori Gagal Disimpan', icon: 'error');
        }
    }
}
