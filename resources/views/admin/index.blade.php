@extends('layout')
@section('content')
<div class="container">
    @include('header')
    <div class="row">
        <div class="col-md-11">
            <a href="/admin/rekap" class="btn btn-primary" id="rekap">Rekap Hari Ini</a>
            <button class="btn btn-success" id="rekap-custom">Rekap Custom</a>
            <br>
        </div>
        <!-- Modal Input Terima Uang -->
        <div class="modal fade" id="modalAturTanggal" tabindex="-1" role="dialog" aria-labelledby="modalAturTanggal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Atur Tanggal Rekap</h5>
                    </div>
                    <div class="modal-body">
                        <form class="form-group row" action="{{route('admin.rekapCustom')}}" method="POST">
                        	@csrf
                            <label for="example-text-input" class="col-2 col-form-label">Dari</label>
                            <div class="col-10">
                                <input class="form-control" type="date" name="tgl1" id="tgl1" style="font-size:50px;">
                            </div>
                            <label for="example-text-input" class="col-2 col-form-label">Sampai</label>
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
	});
</script>
@endsection