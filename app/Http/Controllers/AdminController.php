<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Penjualan;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function rekapHarian($tgl1, $tgl2)
    {
    	$tgl2 = new DateTime($tgl2);
    	$tgl2->modify('+1 day');
    	$data['penjualans'] = Penjualan::whereBetween('created_at', [$tgl1, $tgl2])->get();
    	dd($data);
    }
}
