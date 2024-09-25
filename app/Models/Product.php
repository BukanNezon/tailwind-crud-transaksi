<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = [
        'kategori_id',
        'image',
        'name',
        'jumlah',
        'deskripsi',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}

