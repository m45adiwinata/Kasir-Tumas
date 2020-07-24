<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';
    protected $primaryKey = 'barcode';
    protected $casts = [
        'barcode' => 'string',
     ];
     protected $guarded = [];

     public function penjualan()
     {
        return $this->belongsToMany('App\Penjualan');
     }

     public function penjualanStok()
     {
         return $this->hasMany('App\PenjualanStok', 'stok_barcode', 'barcode');
     }
}
