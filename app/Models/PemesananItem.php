<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananItem extends Model
{
    protected $table = 'pemesanan_items';

    protected $casts = [
        'qty' => 'integer',
        'harga_saat_pesan' => 'integer',
        'subtotal' => 'integer',
    ];


    protected $fillable = [
        'pemesanan_id',
        'produk_id',
        'qty',
        'harga_saat_pesan',
        'subtotal',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

