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
    <!-- <button class="btn btn-prime" id="detail-barang">Detail Barang</button> -->
    <table class="table table-hover table-bordered" style="font-size:18px;" id="tbl-detail-barang">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Barcode</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Terjual</th>
                <th scope="col">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
            <tr>
                <td>{{$barang['barcode']}}</td>
                <td>{{$barang['nama_barang']}}</td>
                <td>{{$barang['terjual']}}</td>
                <td>{{$barang['sisa_stok']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn" id="btn-detail-trx">Detail Transaksi</button>
    <div id="div-detail-trx" style="display: none;">
        <table class="table table-hover table-bordered" style="font-size:14px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Waktu Trx.</th>
                    <th scope="col">Barang</th>
                    <th scope="col">Grosir</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga @</th>
                    <th scope="col">Total</th>
                    <th scope="col">Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualans as $penjualan)
                    @php $ps = $penjualan->penjualanStok()->get(); @endphp
                    @for($i=0;$i<count($ps);$i++)
                        @if($i == 0)
                <tr>
                    <td rowspan="{{count($penjualan->penjualanStok()->get())}}">{{$penjualan->created_at}}</td>
                    <td>{{$ps[$i]->stok()->first()->nama_barang}}</td>
                    <td>@php echo(($ps[$i]->grosir == 1) ? 'YA' : 'TIDAK'); @endphp</td>
                    <td>{{$ps[$i]->jumlah}}</td>
                    <td>Rp {{number_format($ps[$i]->harga, 2, ',', '.')}}</td>
                    <td style="text-align:right;">Rp {{number_format($ps[$i]->jumlah * $ps[$i]->harga, 2, ',', '.')}}</td>
                    <td rowspan="{{count($penjualan->penjualanStok()->get())}}"><i style="font-size:30px;" class="fa fa-print" onclick="printUlang({{$penjualan->id}})"></i></td>
                </tr>
                        @else
                <tr>
                    <td>{{$ps[$i]->stok()->first()->nama_barang}}</td>
                    <td>@php echo(($ps[$i]->grosir == 1) ? 'YA' : 'TIDAK'); @endphp</td>
                    <td>{{$ps[$i]->jumlah}}</td>
                    <td>Rp {{number_format($ps[$i]->harga, 2, ',', '.')}}</td>
                    <td style="text-align:right;">Rp {{number_format($ps[$i]->jumlah * $ps[$i]->harga, 2, ',', '.')}}</td>
                </tr>
                        @endif
                    @endfor
                @endforeach
                <tr>
                    <td colspan="5" style="text-align:center;"><b>TOTAL</b></td>
                    <td style="text-align:right;">Rp. {{$total_cash}}</td>
                </tr>
            </tbody>
        </table>
    </div>
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
                // console.log("hello");
                data.forEach(function(element) {
                    $('#tbody-detail-barang').append(
                        '<tr>'+
                            '<td>'+element['barcode']+'</td>'+
                            '<td>'+element['nama_barang']+'</td>'+
                            '<td>'+element['terjual']+'</td>'+
                            '<td>'+element['sisa_stok']+'</td>'+
                        '</tr>'
                    );
                });
            });
        });
        $('#btn-detail-trx').click(function() {
            $('#div-detail-trx').css('display', 'block');
        });
    });
    function printUlang(id) {
        $.get('/api/print-ulang/' + id, function(data) {
            alert("Nota transaksi TX"+id+" dicetak ulang.");
        });
    }
</script>
@endsection