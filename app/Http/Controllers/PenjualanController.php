<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Penjualan;
use App\PenjualanStok;
use App\Stok;
date_default_timezone_set('Asia/Makassar');

class PenjualanController extends Controller
{
    public function store(Request $request)
    {
        
        $data = new Penjualan;
        $data->total = $request->totalbelanja;
        $data->save();
        foreach ($request->barcode as $key => $bt) {
            $terjual = new PenjualanStok;
            $terjual->stok_barcode = $bt;
            $terjual->jumlah = $request->jumlah[$key];
            $terjual->harga = $request->harga[$key];
            $terjual->total = $request->total[$key];
            $data->penjualanStok()->save($terjual);
            $stok = Stok::find($bt);
            $sisa_stok = $stok->jml_stok - intval($request->jumlah[$key]);
            $stok->update([
                'jml_stok' => $sisa_stok
            ]);
            // $stok->jml_stok -= intval($request->jumlah[$key]);
        }
        
        return redirect('/');
    }
}
