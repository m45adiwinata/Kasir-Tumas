<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

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
        $items = [];
        foreach ($request->barcode as $key => $bt) {
            $stok = Stok::find($bt);
            $terjual = new PenjualanStok;
            $terjual->stok_barcode = $bt;
            $terjual->jumlah = $request->jumlah[$key];
            $terjual->harga = $request->harga[$key];
            $terjual->harga_pokok = $stok->h_pokok;
            $terjual->total = $request->total[$key];
            $data->penjualanStok()->save($terjual);
            $sisa_stok = $stok->jml_stok - intval($request->jumlah[$key]);
            $stok->update([
                'jml_stok' => $sisa_stok
            ]);
            array_push($items, [
                'name' => $stok->nama_barang,
                'qty' => $request->jumlah[$key],
                'price' => $request->harga[$key],
            ]);
        }

        $mid = date('d/m/Y H:i:s');
        $store_name = 'TOKO SURADNYA';
        $store_address = 'Jl. Seririt - Gilimanuk,';
        $store_phone = 'Telp: 081 338 606 207, WA. 081 916 147 145';
        $store_email = '';
        $store_website = '';
        $tax_percentage = 0;
        $transaction_id = 'TX'.$data->id;
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);
        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
		$printer->setTransactionID($transaction_id);
        $printer->setKembalian($request->uang, $request->uang - $request->totalbelanja);
        // Set tax
        $printer->setTax($tax_percentage);
        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        $printer->printReceipt();
        
        return redirect('/');
    }
}
