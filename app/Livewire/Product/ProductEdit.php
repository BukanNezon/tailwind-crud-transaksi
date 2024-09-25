<?php

namespace App\Livewire\Product;

use App\Models\Kategori;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductEdit extends Component
{
    use WithFileUploads;
    
    public Product $product;
    public $image;
    public $image_db;

    #[Validate('required', message: 'Masukkan Nama Product')]
    public $name;

    #[Validate('required', message: 'Masukkan Deskripsi Product')]
    #[Validate('min:3', message: 'Isi Deskripsi Minimal 3 Karakter')]
    public $deskripsi = '<p></p>';

    #[Validate('required', message: 'Masukkan Jumlah Produk')]
    public $jumlah;

    #[Validate('required', message: 'Masukkan Harga Produk')]
    public $harga;

    #[Validate('nullable', message: 'Pilih Kategori')]
    public $kategori_id;


    #[On('productEdit')]
    public function load_data(Product $product)
    {
        $this->product = $product;
        $this->image = $product->image;
        $this->name = $product->name;
        $this->deskripsi = $product->deskripsi;
        $this->jumlah = $product->jumlah;
        $this->harga = $product->harga;
        $this->kategori_id = $product->kategori_id;
        $this->image_db = $product->image;
        $this->dispatch('xxx');
        $this->dispatch('editProduct');

        $this->dispatch('set-deskripsi', deskripsi: $this->deskripsi);
    }

    public function productUpdate()
    {
        $validate = $this->validate();

        if ($this->image != $this->image_db) {
            $this->image->storeAs('public/storage/images', $this->image->hashName());
            $this->product->image = $this->image->hashName();
            Storage::delete('public/storage/images/' . $this->image_db);
        }
        
        try {
            $data = [
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'jumlah' => $this->jumlah,
                'harga' => $this->harga,
                'kategori_id' => $this->kategori_id,
            ];
            
            if (isset($this->image)) {
                $data['image'] = $this->product->image;
            }
            
            $this->product->update($data);
            
            $this->dispatch('xxx');
            $this->dispatch('sweet-alert', title: 'Data Berhasil Diperbarui', icon: 'success');
        } catch (\Throwable $th) {
            $this->dispatch('sweet-alert', title: 'Data Gagal Diperbarui', icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.product.product-edit', [
            'data_kategori' => Kategori::all(),
        ]);
    }
}