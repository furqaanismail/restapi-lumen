<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Produk extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'nama', 'harga', 'warna',
        'kondisi', 'deskripsi',
    ];

}
