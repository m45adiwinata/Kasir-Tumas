<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    public function penjualanStok()
    {
        return $this->hasMany('App\PenjualanStok');
    }

    public function stok()
    {
        return $this->belongsToMany('App\Stok');
    }
}
