<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjangs';

    protected $fillable = [
        'produk_id',
        'qty',
        'user_id',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getSubTotalAttribute()
    {
        return $this->produk ? $this->qty * $this->produk->harga : 0;
    }
}
