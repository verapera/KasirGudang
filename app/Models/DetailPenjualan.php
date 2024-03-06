<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualans';
    protected $primaryKey = 'detail_id';
    protected $fillable = [
        'kode_penjualan',
        'produk_id',
        'jumlah_produk',
        'subtotal',
        'pelanggan_id',
    ];
}
