<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'pelanggan',
        'invoice',
        'tanggal',
        'pembayaran',
        'kembalian',
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
