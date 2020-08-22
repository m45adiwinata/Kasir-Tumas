@extends('layout')
@section('content')
<div class="container">
	@include('header')
	<table class="table table-hover table-bordered" style="font-size:14px;">
		<thead class="thead-dark">
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Jml. Transaksi</th>
                <th scope="col">Total Cash</th>
                <th scope="col">Total Laba</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$tgl}}</td>
                <td>{{count($penjualans)}}</td>
                <td>Rp {{number_format($total_cash, 2, ',', '.')}}</td>
                <td>Rp {{number_format($total_laba, 2, ',', '.')}}</td>
            </tr>
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
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
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
