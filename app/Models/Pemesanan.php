<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $casts = [
        'total' => 'integer',
    ];

    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PemesananItem::class);
    }

    // alias supaya tetap kompatibel dengan withCount('items')
    public function pemesananItems()
    {
        return $this->hasMany(PemesananItem::class);
    }
}

