@extends('layout')
@section('content')
<div class="container">
    @include('header')
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}  
    </div>
    @endif
    @if(session()->get('danger'))
    <div class="alert alert-danger">
        {{ session()->get('danger') }}
    </div>
    @endif
    <a class="btn btn-primary float-md-left" style="margin-right:20px;" href="/stok/create">Tambah/Edit Data</a>
    <input type="text" name="search" id="search" autocomplete="off">
    <button id="search-btn">Cari</button>
    <br><br>
    <div style="width: 60vw; height:600px; overflow-x:auto;">
        <table class="table table-hover table-bordered text-left" style="font-size:14px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama</th>
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
                    <td>{{50 * ($stoks->currentPage()-1) + $key + 1}}</td>
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

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        @if($search)
        $('#search').val('{!! $search !!}');
        @endif
        $('#search-btn').click(function() {
            window.location.href = '/stok/search/' + $('#search').val();
        });
        $('#search').keypress(function (e) {
            if (e.keyCode == 13) {
                window.location.href = '/stok/search/' + $(this).val();
            }
            else {
                var selectedText = '';
                if (document.getSelection) { 
                    selectedText = document.getSelection().toString(); 
                }
                if (selectedText.length > 0) {
                    e.target.value = e.key;
                }
                else {
                    e.target.value += e.key;
                }
            }
            e.preventDefault();
            return false;
        });
        $("#search").on('focus', function() { 
            $(this).select();
        });
    });
</script>
@endsection