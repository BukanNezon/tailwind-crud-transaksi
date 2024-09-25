<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\Component;

class TransaksiIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedTransaksi = null;
    public $paginate = 5;

    protected $queryString = ['search'];

    #[Title('Data Transaksi')]

    public function render()
    {
        if (!$this->search) {
            $transaksis = Transaksi::latest()->paginate($this->paginate);
        } else {
            $transaksis = Transaksi::where('invoice', 'like', '%' . $this->search . '%')->paginate($this->paginate);
        }

        return view('livewire.transaksi.transaksi-index', [
            'transaksis' => $transaksis,
        ]);
    }

    public function loadTransaksi($transaksiId)
    {
        $this->selectedTransaksi = Transaksi::with('details.product')->findOrFail($transaksiId);
    }

    public function hapus($id)
    {
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->delete();
        }
    }
}
