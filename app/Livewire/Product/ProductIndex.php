<?php

namespace App\Livewire\Product;

use Livewire\Attributes\Title;
use Livewire\Component;

class ProductIndex extends Component
{
    #[Title('Data Products')]
    public function render()
    {
        return view('livewire.product.product-index');
    }
}
