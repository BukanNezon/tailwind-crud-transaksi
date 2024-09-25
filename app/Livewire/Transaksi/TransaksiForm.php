<?php

namespace App\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransaksiForm extends Component
{
    public $customerName;
    public $invoice;
    public $transactionDate;
    public $selectedProduct;
    public $products;
    public $cart = [];
    public $payment = 0;
    public $change = 0;

    #[Validate(['customerName' => 'required|string'])]
    #[Validate(['selectedProduct' => 'required'])]
    #[Validate(['payment' => 'required|numeric|min:0'])]

    public function mount()
    {
        $this->products = Product::all();
        $this->invoice = 'INV-' . Str::upper(Str::random(6));
        $this->transactionDate = Carbon::now()->format('Y-m-d');
    }

    public function addToCart()
    {
        // Validasi input
        $this->validate();

        $product = Product::find($this->selectedProduct);

        // Jika produk ditemukan, cek stok (menggunakan field 'jumlah' sesuai tabel product)
        if ($product) {
            if ($product->jumlah <= 0) {
                session()->flash('error', 'Produk ini sudah habis.');
                return;
            }

            // Cek apakah produk sudah ada di keranjang
            $existingIndex = $this->findProductInCart($product->id);
            if ($existingIndex !== null) {
                // Cek apakah jumlah melebihi stok
                if ($this->cart[$existingIndex]['quantity'] + 1 > $product->jumlah) {
                    session()->flash('error', 'Jumlah produk melebihi stok.');
                } else {
                    $this->cart[$existingIndex]['quantity']++;
                    $this->cart[$existingIndex]['total'] = $this->cart[$existingIndex]['quantity'] * $this->cart[$existingIndex]['price'];
                }
            } else {
                $this->cart[] = [
                    'product' => $product,
                    'name' => $product->name, 
                    'quantity' => 1,
                    'price' => $product->harga,
                    'total' => $product->harga,
                ];
            }

            $this->reset('selectedProduct');
        } else {
            session()->flash('error', 'Produk tidak ditemukan.');
        }

        $this->calculateTotal();
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($index, $quantity)
    {
        $product = $this->cart[$index]['product'];

        // Cek apakah kuantitas melebihi stok (menggunakan 'jumlah')
        if ($quantity > $product->jumlah) {
            session()->flash('error', 'Jumlah melebihi stok yang tersedia.');
            return;
        }

        // Update kuantitas dan total
        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['total'] = $this->cart[$index]['price'] * $quantity;

        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        // Menghapus item dari cart
        array_splice($this->cart, $index, 1);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        // Menghitung total keseluruhan dari cart
        $total = array_sum(array_column($this->cart, 'total'));
        $this->change = $this->payment - $total;
    }

    public function updatedPayment()
    {
        // Otomatis hitung kembalian ketika payment diupdate
        $this->calculateTotal();
    }

    public function saveTransaction()
    {
        // Cek apakah keranjang (cart) kosong
        if (empty($this->cart)) {
            session()->flash('error', 'Tidak ada transaksi. Keranjang belanja kosong.');
            return;
        }
    
        $totalAmount = array_sum(array_column($this->cart, 'total'));
    
        // Cek apakah pembayaran kurang dari total harga
        if ($this->payment < $totalAmount) {
            session()->flash('error', 'Your payment is insufficient!');
            return;
        }
    
        // Simpan transaksi ke database
        try {
            $transaksi = Transaksi::create([
                'pelanggan' => $this->customerName,
                'invoice' => $this->invoice,
                'tanggal' => $this->transactionDate,
                'pembayaran' => $this->payment,
                'kembalian' => $this->change,
            ]);
    
            // Simpan detail transaksi ke database
            foreach ($this->cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'product_id' => $item['product']->id,
                    'qty' => $item['quantity'],
                    'total' => $item['total'],
                ]);
    
                // Update stok produk
                $item['product']->decrement('jumlah', $item['quantity']);
            }
    
            session()->flash('success', 'Your transaction has been saved successfully.');
    
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan transaksi.');
            return;
        }
    
        $this->dispatch('sweet-alert', title: 'Transaksi Berhasil Disimpan', icon: 'success');
        
        return redirect()->route('transaksi.index');
        
    }

    private function resetTransactionData()
    {
        // Reset semua variabel yang berkaitan dengan transaksi
        $this->customerName = null;
        $this->invoice = 'INV-' . Str::upper(Str::random(6)); 
        $this->transactionDate = Carbon::now()->format('Y-m-d');
        $this->selectedProduct = null;
        $this->cart = []; 
        $this->payment = 0; 
        $this->change = 0;  
    }
    

    private function findProductInCart($productId)
    {
        foreach ($this->cart as $index => $item) {
            if ($item['product']->id === $productId) {
                return $index;
            }
        }
        return null;
    }

    public function render()
    {
        return view('livewire.transaksi.transaksi-form');
    }
}
