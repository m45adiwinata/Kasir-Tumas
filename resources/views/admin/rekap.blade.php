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
                <td>{{$total_cash}}</td>
                <td>{{$total_laba}}</td>
            </tr>
        </tbody>
	</table>
</div>
@endsection
