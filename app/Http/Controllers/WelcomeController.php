<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stok;

class WelcomeController extends Controller
{
    public function index()
    {
        // $data['stoks'] = Stok::orderBy('nama_barang')->get();
        
        // return view('welcome', $data);
        return view('welcome');
    }
}
