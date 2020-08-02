<?php

namespace App\Http\Controllers;

use App\Stok;
use Illuminate\Http\Request;
use Auth;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $data['stoks'] = Stok::orderBy('nama_barang')->paginate(50);
        $data['search'] = null;
        return view('stok.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        return view('stok.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Stok;
        $data->kode = $request->kode;
        $data->barcode = $request->barcode;
        $data->nama_barang = $request->nama_barang;
        $data->kategori = $request->kategori;
        $data->suplier = $request->suplier;
        $data->satuan = $request->satuan;
        $data->satuan_ecer = $request->satuan_ecer;
        $data->isi = $request->isi;
        $data->h_pokok = $request->h_pokok;
        $data->h_grosir = $request->h_grosir;
        $data->h_ecer = $request->h_ecer;
        $data->tgl_beli = $request->tgl_beli;
        $data->jml_stok = $request->jumlah * $request->isi;
        $data->stok_min = $request->stok_min;
        $data->stok_max = $request->stok_max;
        $data->save();

        return redirect('/stok')->with('success', 'DATA BARANG TELAH MASUK.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stok  $stok
     * @return \Illuminate\Http\Response
     */
    public function show(Stok $stok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stok  $stok
     * @return \Illuminate\Http\Response
     */
    public function edit(Stok $stok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stok  $stok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stok $stok)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stok  $stok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stok $stok)
    {
        //
    }

    public function getData($barcode)
    {
        $data = Stok::where('barcode', $barcode)->first();
        if ($data == null) {
            $data = "tidak ada";
        }
        return $data;
    }

    public function masuk(Request $request)
    {
        return "hello";
    }

    public function update2(Request $request, $barcode)
    {
        // dd($request);
        $data = Stok::where('barcode', $barcode)->update([
            'kode' => $request->kode,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'suplier' => $request->suplier,
            'satuan' => $request->satuan_grosir,
            'satuan_ecer' => $request->satuan_ecer,
            'isi' => $request->isi,
            'h_pokok' => $request->h_pokok,
            'h_grosir' => $request->h_grosir,
            'h_ecer' => $request->h_ecer,
            'tgl_beli' => $request->tgl_beli,
            'jml_stok' => $request->jml_stok,
            'stok_min' => $request->stok_min,
            'stok_max' => $request->stok_max,
        ]);

        return redirect('/stok')->with('success', 'DATA BARANG TELAH DIUBAH.');
    }

    public function getByNama(Request $request)
    {
        // dd($request);
        if ($request->has('q')) {
            $data = Stok::where('nama_barang', 'LIKE', '%'.$request->q.'%')->get();
            return response()->json($data);
        }
    }

    public function getAll()
    {
        $data = Stok::pluck('nama_barang', 'barcode');

        return $data;
    }

    public function search($nama_barang)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $data['stoks'] = Stok::where('nama_barang', 'LIKE', '%'.$nama_barang.'%')->orderBy('nama_barang')->paginate(50);
        $data['search'] = $nama_barang;
        return view('stok.index', $data);
    }
}
