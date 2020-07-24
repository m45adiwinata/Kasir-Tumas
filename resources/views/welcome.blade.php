@extends('layout')
@section('content')
<div class="container">
    @include('header')
    <div class="row">
        <div class="col-md-11">
            <div class="form-inline">
                <div class="form-group mx-sm-4 mb-2">
                    <!-- <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com"> -->
                    <input type="text" class="form-control" name="barcode" id="barcode" placeholder="barcode..." autofocus>
                </div>
                <div class="form-group mb-2">
                    <select name="nama_barang" id="nama_barang" style="width:20vw;"></select>
                    <!-- <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="nama barang..."> -->
                </div>
            </div>
            <br>
            
        </div>
        <div class="col-md">
            <!-- Modal Input Jumlah Item -->
            <div class="modal fade" id="modalJumlah" tabindex="-1" role="dialog" aria-labelledby="modalJumlahTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalJmlNamaBarang"></h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-grosir">
                                <label class="form-check-label" for="checkbox-grosir">Grosir</label>
                            </div>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="jumlah..." style="font-size:50px;">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="modalConfirmHapus" tabindex="-1" role="dialog" aria-labelledby="modalConfirmHapusTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus item ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width:8vw;">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="delPembelian()" style="width:8vw;">Ya</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <!-- Modal Input Terima Uang -->
            <div class="modal fade" id="modalTerimaUang" tabindex="-1" role="dialog" aria-labelledby="modalTerimaUang" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nominal Uang</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Rp.</label>
                                <div class="col-10">
                                    <input class="form-control" type="number" name="uang" id="uang" style="font-size:50px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <!-- Modal Input Kembalian -->
            <div class="modal fade" id="modalKembalian" tabindex="-1" role="dialog" aria-labelledby="modalKembalian" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Kembalian</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Rp.</label>
                                <div class="col-10">
                                    <input type="number" readonly class="form-control" name="kembalian" id="kembalian" style="font-size:50px;">
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-selesai" class="btn btn-primary" style="width:8vw;">Selesai</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <div style="height:70vh;overflow:auto;">
                <table id="pembelian" >
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>H. Satuan</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </table>
            </div>
            Total Belanja <span class="float-right mx-1-right" id="totalbelanja"></span>
            <br>
            <button type="submit" id="bayar" class="btn btn-success mb-2 float-right">BAYAR</button>
            <form action="{{route('penjualan.store')}}" method="POST" style="display:none;" id="invisible-form">
                @csrf
                
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var id = 1;
    var belanjaan = [];
    var deletingId = null;
    var totalbelanja = 0;
    $(document).ready(function(){
        // $('#uang').simpleMoneyFormat();
        $('#nama_barang').select2({
            placeholder: 'Cari...',
            ajax: {
            url: '/stok/get-by-nama/x',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.nama_barang,
                        id: item.barcode
                    }
                })
                };
            },
            cache: true
            }
        });
        $('#modalJumlah').on('shown.bs.modal', function() {
            $('#jumlah').focus();
        });
        $('#modalTerimaUang').on('shown.bs.modal', function() {
            $('#uang').focus();
        });
        $('#modalKembalian').on('shown.bs.modal', function() {
            $('#btn-selesai').focus();
        });
        
        $('#barcode').keypress(function (e) {
            if (e.keyCode == 13) {
                $.get('/stok/get-data/' + $('#barcode').val(), function(data) {
                    if(data == "tidak ada") {
                        alert("DATA BARANG TIDAK DITEMUKAN.");
                    }
                    else {
                        $('#modalJmlNamaBarang').html(data.nama_barang);
                        $('#modalJumlah').modal('toggle');
                    }
                });
            }
            else {
                e.target.value += e.key;
            }
            e.preventDefault();
            return false;
        });
        $('#nama_barang').change(function() {
            $('#barcode').val($(this).val());
            if ($('#nama_barang').select2('data')[0]) {
                $('#modalJmlNamaBarang').html($('#nama_barang').select2('data')[0]['text']);
            }
            $('#modalJumlah').modal('toggle');
        });
        $('#jumlah').keypress(function (e) {
            if (e.keyCode == 13) {
                $.get('/stok/get-data/' + $('#barcode').val(), function(data) {
                    if(data == "tidak ada") {
                        alert("DATA BARANG TIDAK DITEMUKAN.");
                    }
                    else {
                        if ($('#checkbox-grosir:checked')[0]) {
                            $('#pembelian').append(
                                '<tr id="row-'+id+'">'+
                                '<td>'+data.nama_barang+'</td>'+
                                '<td>'+$('#jumlah').val()+'</td>'+
                                '<td>'+data.h_grosir+'</td>'+
                                '<td>'+($('#jumlah').val() * data.h_grosir)+'</td>'+
                                '<td><i class="fa fa-trash" onclick="toggleDelModal('+id+')" aria-hidden="true"></i></td>'+
                                '</tr>'
                            );
                            $('#invisible-form').append(
                                '<div id="invis-row-'+id+'">'+
                                    '<input type="text" name="barcode['+id+']" value="'+data.barcode+'">'+
                                    '<input type="number" name="jumlah['+id+']" value="'+$('#jumlah').val()+'">'+
                                    '<input type="number" name="harga['+id+']" value="'+data.h_grosir+'">'+
                                    '<input type="number" name="total['+id+']" value="'+($('#jumlah').val() * data.h_grosir)+'">'+
                                '</div>'
                            );
                            belanjaan.push({
                                'id': id,
                                'barcode': data.barcode,
                                'total': $('#jumlah').val() * data.h_grosir
                            });
                            totalbelanja += $('#jumlah').val() * data.h_grosir;
                        }
                        else {
                            $('#pembelian').append(
                                '<tr id="row-'+id+'">'+
                                '<td>'+data.nama_barang+'</td>'+
                                '<td>'+$('#jumlah').val()+'</td>'+
                                '<td>'+data.h_ecer+'</td>'+
                                '<td>'+($('#jumlah').val() * data.h_ecer)+'</td>'+
                                '<td><i class="fa fa-trash" onclick="toggleDelModal('+id+')" aria-hidden="true"></i></td>'+
                                '</tr>'
                            );
                            $('#invisible-form').append(
                                '<div id="invis-row-'+id+'">'+
                                    '<input type="text" name="barcode['+id+']" value="'+data.barcode+'">'+
                                    '<input type="number" name="jumlah['+id+']" value="'+$('#jumlah').val()+'">'+
                                    '<input type="number" name="harga['+id+']" value="'+data.h_ecer+'">'+
                                    '<input type="number" name="total['+id+']" value="'+($('#jumlah').val() * data.h_ecer)+'">'+
                                '</div>'
                            );
                            belanjaan.push({
                                'id': id,
                                'barcode': data.barcode,
                                'total': $('#jumlah').val() * data.h_ecer
                            });
                            totalbelanja += $('#jumlah').val() * data.h_ecer;
                        }
                        
                        $('#totalbelanja').html(formatRupiah(totalbelanja.toString(), 'Rp. '));
                        $('#jumlah').val(null);
                        $('#modalJumlah').modal('toggle');
                        $('#nama_barang').val(null).trigger('change');
                        $('#barcode').focus();
                        id++;
                    }
                });
            }
            else {
                e.target.value += e.key;
            }
            e.preventDefault();
            return false;
        });
        $('#bayar').click(function() {
            $('#modalTerimaUang').modal('toggle');
            $('#uang').attr("min", totalbelanja);
            $('#uang').val(totalbelanja);
        });
        $("#uang").on('focus', function() { 
            $(this).select();
        });
        $('#uang').keypress(function(e) {
            if (e.keyCode == 13) {
                $('#kembalian').val($('#uang').val() - totalbelanja);
                $('#modalKembalian').modal('toggle');
            }
            else {
                var selectedText = '';
                // window.getSelection 
                if (window.getSelection) { 
                    selectedText = window.getSelection().toString(); 
                } 
                // document.getSelection 
                else if (document.getSelection) { 
                    selectedText = document.getSelection().toString(); 
                } 
                // document.selection 
                else if (document.selection) { 
                    selectedText = document.selection.createRange().text; 
                } else return;
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
        $('#btn-selesai').click(function() {
            $( "#invisible-form").append('<input type="hidden" name="totalbelanja" value="'+totalbelanja+'">');
            $( "#invisible-form").submit();
        });
    });

    function toggleDelModal(id) {
        deletingId = id;
        $('#modalConfirmHapus').modal('toggle');
    }

    function delPembelian() {
        $('#row-'+deletingId).remove();
        $('#invis-row-'+deletingId).remove();
        var deletedIdx = belanjaan.findIndex(i => i.id == deletingId);
        var deleted = belanjaan[deletedIdx];
        totalbelanja -= deleted.total;
        $('#modalConfirmHapus').modal('toggle');
        $('#totalbelanja').html(formatRupiah(totalbelanja.toString(), 'Rp. '));
        belanjaan.splice(deletedIdx, 1);
        deletingId = null;
    }

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function isTextSelected(input) {
        if (typeof input.selectionStart == "number") {
            return input.selectionStart == 0 && input.selectionEnd == input.value.length;
        } else if (typeof document.selection != "undefined") {
            input.focus();
            return document.selection.createRange().text == input.value;
        }
    }
</script>
@endsection