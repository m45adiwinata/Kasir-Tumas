@extends('layout')
@section('content')
<div class="container">
    @include('header')
    <div class="row">
        <div class="col-md-11">
            <a href="/admin/rekap" class="btn btn-primary">Rekap Hari Ini</a>
            <a href="/admin/rekap-custom" class="btn btn-success">Rekap Custom</a>
            <br>
        </div>
    </div>
</div>
@endsection