@extends('layout')
@section('content')
<div class="container">
    @include('header')
    <br>
    <div class="row">
        <div class="col-md-11">
            <form class="form" action="{{route('stok.store')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="barcode" class="col-sm-2 col-form-label">Barcode</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="barcode" id="barcode" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode" class="col-sm-2 col-form-label">Kode Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="kode" id="kode">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-2 col-form-label">Kategori Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="kategori" id="kategori">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="suplier" class="col-sm-2 col-form-label">Suplier Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="suplier" id="suplier">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="satuan_grosir" class="col-sm-2 col-form-label">Satuan Grosir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="satuan_grosir" id="satuan_grosir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="satuan_ecer" class="col-sm-2 col-form-label">Satuan Ecer</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="satuan_ecer" id="satuan_ecer">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="isi" class="col-sm-2 col-form-label">Isi Per Grosir</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="isi" id="isi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="h_pokok" class="col-sm-2 col-form-label">Harga Pokok</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="h_pokok" id="h_pokok">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="h_grosir" class="col-sm-2 col-form-label">Harga Jual Grosir</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="h_grosir" id="h_grosir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="h_ecer" class="col-sm-2 col-form-label">Harga Jual Eceran</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="h_ecer" id="h_ecer">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_beli" class="col-sm-2 col-form-label">Tanggal Beli</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tgl_beli" id="tgl_beli">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jml_beli" class="col-sm-2 col-form-label">Jumlah Stok <i id="lbl-satuan-ecer"></i></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="jml_stok" id="jml_stok">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stok_min" class="col-sm-2 col-form-label">Stok Minimum</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="stok_min" id="stok_min">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stok_max" class="col-sm-2 col-form-label">Stok Maximum</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="stok_max" id="stok_max">
                    </div>
                </div>
                <button type="submit" class="btn btn-success" id="submit">Submit</button>
            </form>
        </div>
        <div class="col-md">
            
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#barcode').keypress(function (e) {
            if (e.keyCode == 13) {
                $.get('/stok/get-data/' + $(this).val(), function(data) {
                    if (data == "tidak ada") {
                        alert("DATA TIDAK DITEMUKAN, ANDA AKAN MEMBUAT DATA BARU.");
                        $('#nama_barang').focus();
                    }
                    else {
                        $('form').attr({'action': 'update/'+data.barcode, 'method':'GET'});
                        $('#nama_barang').val(data.nama_barang);
                        $('#kode').val(data.kode);
                        $('#kategori').val(data.kategori);
                        $('#kode').val(data.kode);
                        $('#suplier').val(data.suplier);
                        $('#satuan_grosir').val(data.satuan);
                        $('#satuan_ecer').val(data.satuan_ecer);
                        $('#isi').val(data.isi);
                        $('#h_pokok').val(data.h_pokok);
                        $('#h_grosir').val(data.h_grosir);
                        $('#h_ecer').val(data.h_ecer);
                        $('#tgl_beli').val(data.tgl_beli);
                        $('#jml_stok').val(data.jml_stok);
                        $('#stok_min').val(data.stok_min);
                        $('#stok_max').val(data.stok_max);
                        $('#h_pokok').focus();
                    }
                });
            }
            else {
                e.target.value += e.key;
            }
            e.preventDefault();
            return false;
        });
        $('#satuan_ecer').change(function() {
            $('#lbl-satuan-ecer').html('('+$(this).val()+')');
        });
        // $('#submit').click(function() {
        //     var fd = new FormData();
        //     fd.append('barcode', $('#barcode').val());
        //     // let barcode = $('#barcode').val();
        //     let kode = $('#kode').val();
        //     let nama_barang = $('#nama_barang').val();
        //     let kategori = $('#kategori').val();
        //     let suplier = $('#suplier').val();
        //     let tgl_beli = $('#tgl_beli').val();
        //     $.post('/stok/masuk/'+fd, function(data) {
        //         console.log(data);
        //     });
        // });
    });
</script>
@endsection