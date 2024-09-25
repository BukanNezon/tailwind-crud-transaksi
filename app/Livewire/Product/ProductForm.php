<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class ProductForm extends Component
{
    use WithFileUploads;

    #[Validate('image', message: 'File Harus Gambar')]
    #[Validate('max:1024', message: 'Ukuran File Maksimal 1MB')]
    public $image;

    #[Validate('required', message: 'Masukkan Nama Produk')]
    public $name;

    #[Validate('required', message: 'Masukkan Deskripsi Produk')]
    #[Validate('min:3', message: 'Deskripsi Minimal 3 Karakter')]
    public $deskripsi = '';

    #[Validate('required', message: 'Masukkan Jumlah Produk')]
    public $jumlah;

    #[Validate('required', message: 'Masukkan Harga Produk')]
    public $harga;

    #[Validate('nullable', message: 'Pilih Kategori')]
    public $kategori_id;

    public function render()
    {
        return view('livewire.product.product-form', [
            'categoriesList' => Kategori::all(),
        ]);
    }

    public function store()
    {
        $this->validate();

        try {
            $this->image->storeAs('public/products', $this->image->hashName());

            $data = [
                'image' => $this->image->hashName(),
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'jumlah' => $this->jumlah,
                'harga' => $this->harga,
                'kategori_id' => $this->kategori_id,
            ];

            
            $product = Product::create($data); 
            
            if ($this->image) {
                $imagePath = $this->image->store('images', 'public');
                $product->update(['image' => $imagePath]);
            }

            $this->reset();
            $this->dispatch('reset-ckeditor');
            $this->dispatch('xxx');
            $this->dispatch('sweet-alert', title: 'Data Berhasil Disimpan', icon: 'success');
            $this->dispatch('editProduct');
        } catch (\Throwable $th) {
            $this->dispatch('sweet-alert', title: 'Data Gagal Disimpan', icon: 'error');
        }
    }
}
