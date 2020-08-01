@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md">
            <a href="#">Tambah/Edit Data</a>
            <input type="text" name="search" id="search">
            <button id="search-btn">Cari</button>
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table class="table table-hover table-bordered" style="font-size:14px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Kode</th>
                    <th scope="col" style="width:400px;">Nama</th>
                    <th scope="col">Suplier</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Isi</th>
                    <th scope="col">H. Pokok</th>
                    <th scope="col">H. Grosir</th>
                    <th scope="col">H. Ecer</th>
                    <th scope="col">Tgl. Beli</th>
                    <th scope="col">Jml. Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stoks as $key => $stok)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$stok->barcode}}</td>
                    <td>{{$stok->kode}}</td>
                    <td>{{$stok->nama_barang}}</td>
                    <td>{{$stok->suplier}}</td>
                    <td>{{$stok->kategori}}</td>
                    <td>{{$stok->satuan}}</td>
                    <td>{{$stok->isi}}</td>
                    <td>{{$stok->h_pokok}}</td>
                    <td>{{$stok->h_grosir}}</td>
                    <td>{{$stok->h_ecer}}</td>
                    <td>{{$stok->tgl_beli}}</td>
                    <td>{{$stok->jml_stok}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $stoks->links() }}
</div>
@endsection