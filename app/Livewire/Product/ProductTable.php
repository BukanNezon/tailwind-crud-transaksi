<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $product_id;
    public $paginate = 5;
    public $image;
    public $name;
    public $deskripsi;
    public $jumlah;
    public $harga;
    public $kategori;
    public $search;
    public $existingImage;

    #[On('xxx')]
    public function render()
    {
        if (!$this->search) {
            $products = Product::latest()->paginate($this->paginate);
        } else {
            $products = Product::where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);
        }

        return view('livewire.product.product-table', [
            'products' => $products,
        ]);
    }

    public function hapus($get_id)
    {
        try {
            $product = Product::find($get_id);
            $filePath = 'public/storage/' . $product->image;
            Storage::delete($filePath);

            $product->delete();
        } catch (\Exception $e) {
            $this->dispatch('sweet-alert', title: 'Data Gagal Dihapus', icon: 'error');
        }
    }
}
