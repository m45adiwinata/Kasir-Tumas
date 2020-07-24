<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanStok extends Model
{
    protected $table = 'penjualan_stok';
    public $timestamps = false;
    protected $guarded = [];
}
