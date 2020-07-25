@extends('layout')
@section('content')
<div class="container">
    @include('header')
    <div class="row">
        <div class="col-md-11">
            <a href="#" class="btn btn-primary" id="rekap">Rekap Hari Ini</a>
            <a href="/admin/rekap-custom" class="btn btn-success">Rekap Custom</a>
            <br>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	var date = new Date();
	$(document).ready(function() {
		var tempMonth = date.getMonth();
		tempMonth += 1;
		if (tempMonth < 10) {
			tempMonth = String('0'+tempMonth);
		}
		else {
			tempMonth = String(tempMonth);
		}
		currentDate = date.getFullYear()+'-'+tempMonth+'-'+date.getDate();
		$('#rekap').attr('href', '/admin/rekap/'+currentDate+'/'+currentDate);
	});
</script>
@endsection