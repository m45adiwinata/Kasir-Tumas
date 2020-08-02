@extends('layout')
@section('content')
<div class="container">
    @include('header')
    <div class="row">
        <div class="col-md-11">
            <a href="/admin/rekap" class="btn btn-primary" id="rekap">Rekap Hari Ini</a>
            <button class="btn btn-success" id="rekap-custom">Rekap Custom</button>
            <button class="btn btn-warning" id="ganti-password">Ganti Password</button>
            <br>
        </div>
        <!-- Modal Input Tanggal Rekap Custom -->
        <div class="modal fade" id="modalAturTanggal" tabindex="-1" role="dialog" aria-labelledby="modalAturTanggal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Atur Tanggal Rekap</h5>
                    </div>
                    <div class="modal-body">
                        <form class="form-group row" action="{{route('admin.rekapCustom')}}" method="POST">
                        	@csrf
                            <label for="tgl1" class="col-2 col-form-label">Dari</label>
                            <div class="col-10">
                                <input class="form-control" type="date" name="tgl1" id="tgl1" style="font-size:50px;">
                            </div>
                            <label for="tgl2" class="col-2 col-form-label">Sampai</label>
                            <div class="col-10">
                                <input class="form-control" type="date" name="tgl2" id="tgl2" style="font-size:50px;">
                            </div>
                            <input type="submit" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <!-- Modal Ganti Password -->
        <div class="modal fade" id="modalGantiPassword" tabindex="-1" role="dialog" aria-labelledby="modalGantiPassword" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Ganti Password</h5>
                    </div>
                    <div class="modal-body">
                        <form class="form-group row" action="{{route('admin.ganti-password')}}" method="POST">
                            @csrf
                            <label for="password_lama" class="col-4 col-form-label">Password Lama</label>
                            <div class="col-8">
                                <input class="form-control" type="password" name="password_lama" id="password_lama" style="font-size:20px;">
                            </div>
                            <label for="password_baru" class="col-4 col-form-label my-2">Password Baru</label>
                            <div class="col-8 my-2">
                                <input class="form-control" type="password" name="password_baru" id="password_baru" style="font-size:20px;">
                            </div>
                            <label for="konf_password_baru" class="col-4 col-form-label">Konfirmasi Password Baru</label>
                            <div class="col-8">
                                <input class="form-control" type="password" name="konf_password_baru" id="konf_password_baru" style="font-size:20px;" />
                            </div>
                            <input type="submit" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	var date = new Date();
	$(document).ready(function() {
		$('#modalAturTanggal').on('shown.bs.modal', function() {
            $('#tgl1').focus();
        });
		var tempMonth = date.getMonth();
		tempMonth += 1;
		if (tempMonth < 10) {
			tempMonth = String('0'+tempMonth);
		}
		else {
			tempMonth = String(tempMonth);
		}
		currentDate = date.getFullYear()+'-'+tempMonth+'-'+date.getDate();
		$('#rekap-custom').click(function() {
			$('#modalAturTanggal').modal('toggle');
		});
        $('#ganti-password').click(function() {
            $('#modalGantiPassword').modal('toggle');
        });
        $('#konf_password_baru').keyup(function() {
            if($('#password_baru').val() != $(this).val()) {
                $(this).css('background-color', '#ff4d4d');
            }
            else {
                $(this).css('background-color', 'transparent');
            }
        });
	});
</script>
@endsection