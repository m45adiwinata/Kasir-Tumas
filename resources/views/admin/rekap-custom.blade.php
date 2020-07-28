@extends('layout')
@section('content')
<div class="container">
	@include('header')
	<table class="table table-hover table-bordered" style="font-size:18px;">
		<thead class="thead-dark">
            <tr>
                <th scope="col">Dari</th>
                <th scope="col">Sampai</th>
                <th scope="col">Jml. Transaksi</th>
                <th scope="col">Total Cash</th>
                <th scope="col">Total Laba</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$tgl1}}</td>
                <td>{{$tgl2}}</td>
                <td>{{count($penjualans)}}</td>
                <td>Rp. {{$total_cash}}</td>
                <td>Rp. {{$total_laba}}</td>
            </tr>
        </tbody>
	</table>
    <br>
    <button class="btn btn-prime" id="detail-barang">Detail Barang</button>
    <table class="table table-hover table-bordered" style="font-size:18px;" id="tbl-detail-barang"></table>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var tgl1 = {!! json_encode($tgl1) !!};
    var tgl2 = {!! json_encode($tgl2) !!};
    $(document).ready(function() {
        $('#detail-barang').click(function() {
            $.get('/admin/get-detail-barang/'+tgl1+'/'+tgl2, function(data) {
                console.log(data);
                $('#tbl-detail-barang').empty();
                $('#tbl-detail-barang').append(
                    '<thead class="thead-dark">'+
                        '<tr>'+
                            '<th scope="col">Barcode</th>'+
                            '<th scope="col">Nama Barang</th>'+
                            '<th scope="col">Terjual</th>'+
                            '<th scope="col">Sisa Stok</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody id="tbody-detail-barang"></tbody>'
                );
                $(data).each(function(index, element) {
                    $('#tbody-detail-barang').append(
                        '<tr>'+
                            '<td>'+element.barcode+'</td>'+
                            '<td>'+element.nama_barang+'</td>'+
                            '<td>'+element.terjual+'</td>'+
                            '<td>'+element.sisa_stok+'</td>'+
                        '</tr>'
                    );
                });
            });
        });
    });
</script>
@endsection