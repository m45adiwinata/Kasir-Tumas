<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use App\Penjualan;
use Auth;
use App\User;

date_default_timezone_set('Asia/Makassar');

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        return view('admin.index');
    }

    public function rekapHarian()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
    	$data['penjualans'] = Penjualan::whereDate('created_at', date('Y-m-d'))->get();
        $data['tgl'] = date('Y-m-d');

        $total_cash = 0;
        $total_laba = 0;
    	foreach ($data['penjualans'] as $key => $p) {
            $total_cash += $p->total;
            foreach ($p->penjualanStok()->get() as $key2 => $ps) {
                $total_laba += $ps->jumlah * ($ps->harga - $ps->harga_pokok);
            }

        }
        $data['total_cash'] = $total_cash;
        $data['total_laba'] = $total_laba;

        return view('admin.rekap', $data);
    }

    public function rekapCustom(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $tgl2 = new DateTime($tgl2);
        $tgl2->modify('+1 day');
        $data['penjualans'] = Penjualan::whereBetween('created_at', [$tgl1, $tgl2])->get();
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $request->tgl2;
        $total_cash = 0;
        $total_laba = 0;
        $data['barangs'] = [];
        foreach ($data['penjualans'] as $key => $p) {
            $total_cash += $p->total;
            foreach ($p->penjualanStok()->get() as $key2 => $ps) {
                $total_laba += $ps->jumlah * ($ps->harga - $ps->harga_pokok);
                $found = false;
                for ($i=0; $i < count($data['barangs']); $i++) { 
                    if ($data['barangs'][$i]['barcode'] == $ps->stok_barcode) {
                        $found = true;
                        $data['barangs'][$i]['terjual'] += $ps->jumlah;
                    }
                }
                if ($found == false) {
                    array_push($data['barangs'], [
                        'barcode' => $ps->stok_barcode,
                        'nama_barang' => $ps->stok()->first()->nama_barang,
                        'terjual' => $ps->jumlah,
                        'sisa_stok' => $ps->stok()->first()->jml_stok
                    ]);
                }
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
                    $total_laba += $ps->jumlah * ($ps->harga - $ps->harga_pokok);
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

    public function gantiPassword(Request $request)
    {
        $user = Auth::user();
        if(md5($request->password_lama) != $user->password) {
            return redirect('admin')->with('fail', 'Password lama tidak sesuai atau salah.');
        }
        $user->update(['password' => md5($request->password_baru)]);

        return redirect('admin');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
