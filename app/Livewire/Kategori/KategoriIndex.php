<?php

namespace App\Livewire\Kategori;

use Livewire\Attributes\Title;
use Livewire\Component;

class KategoriIndex extends Component
{
    #[Title('Data Kategori')]
    public function render()
    {
        return view('livewire.kategori.kategori-index');
    }
}
