<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use App\Penjualan;

date_default_timezone_set('Asia/Makassar');

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function rekapHarian()
    {
    	$data['penjualans'] = Penjualan::whereDate('created_at', date('Y-m-d'))->get();
        $data['tgl'] = date('Y-m-d');

        $total_cash = 0;
        $total_laba = 0;
    	foreach ($data['penjualans'] as $key => $p) {
            $total_cash += $p->total;
            foreach ($p->penjualanStok()->get() as $key2 => $ps) {
                $barang = $ps->stok()->first();
                $total_laba += $ps->jumlah * ($ps->harga - $barang->h_pokok);
            }

        }
        $data['total_cash'] = $total_cash;
        $data['total_laba'] = $total_laba;

        return view('admin.rekap', $data);
    }

    public function rekapCustom(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $tgl2 = new DateTime($tgl2);
        $tgl2->modify('+1 day');
        $data['penjualans'] = Penjualan::whereBetween('created_at', [$tgl1, $tgl2])->get();
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $request->tgl2;
        $total_cash = 0;
        $total_laba = 0;
        foreach ($data['penjualans'] as $key => $p) {
            $total_cash += $p->total;
            foreach ($p->penjualanStok()->get() as $key2 => $ps) {
                $barang = $ps->stok()->first();
                $total_laba += $ps->jumlah * ($ps->harga - $barang->h_pokok);
            }
        }
        $data['total_cash'] = number_format($total_cash, 2, ',', '.');
        $data['total_laba'] = number_format($total_laba, 2, ',', '.');

        return view('admin.rekap-custom', $data);
    }

    public function getDetail($tgl1, $tgl2)
    {
        $tgl2 = new DateTime($tgl2);
        $tgl2->modify('+1 day');
        $periods = new DatePeriod(
            new DateTime($tgl1),
            new DateInterval('P1D'),
            new DateTime($tgl2)
        );
        $data['penjualans'] = [];
        foreach ($periods as $key => $period) {
            $penjualan = Penjualan::whereDate('created_at', $period)->get();
            $total_cash = 0;
            $total_laba = 0;
            foreach ($penjualan as $key => $p) {
                $total_cash += $p->total;
                foreach ($p->penjualanStok()->get() as $key => $ps) {
                    $barang = $ps->stok()->first();
                    $total_laba += $ps->jumlah * ($ps->harga - $barang->h_pokok);
                }
            }
            array_push($data['penjualans'], [
                'tgl' => $period,
                'count' => count($penjualan),
                'total_cash' => $total_cash,
                'total_laba' => $total_laba
            ]);
        }

        return $data;
    }

    public function getDetailBarang($tgl1, $tgl2)
    {
        $tgl2 = new DateTime($tgl2);
        $tgl2->modify('+1 day');
        $penjualans = Penjualan::whereBetween('created_at', [$tgl1, $tgl2])->get();
        $data = [];
        foreach ($penjualans as $key => $p) {
            foreach ($p->penjualanStok()->get() as $key => $ps) {
                $found = false;
                foreach ($data as $key => $b) {
                    if ($b['barcode'] == $ps->stok_barcode) {
                        $found = true;
                        $b['terjual'] += $ps->jumlah;
                    }
                }
                if ($found == false) {
                    array_push($data, [
                        'barcode' => $ps->stok_barcode,
                        'nama_barang' => $ps->stok()->first()->nama_barang,
                        'terjual' => $ps->jumlah,
                        'sisa_stok' => $ps->stok()->first()->jml_stok
                    ]);
                }
            }
        }

        return json_encode($data);
    }
}
