@extends('core::layouts/master')
@section('title','Close Shift')
@section('js')
<script>
  $(document).ready(function(){
    $('#actual').keyup(function(){
      var diff = $('#actual').val() - $('#total').val();
      $('#diff').text(diff);
    })
  });
</script>    
@endsection
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Shift</li>
        <li class="breadcrumb-item active" aria-current="page">Rincian Shift</li>
      </ol>
      <h6 class="slim-pagetitle">Rincian Shift</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          @include('flash::message')
          {{ Form::open(['route' => 'closeShift']) }}
            <div class="form-row">
              <h5 class="col-md-4">Transaksi Tiket</h5>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Jumlah Transaksi Tiket</label>
              <span class="col-md">: {{ $ticketTransaction }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Jumlah Uang Transaksi Tiket</label>
              <span class="col-md">: {{ number_format($ticket) }}</span>
            </div>
            <div class="form-row mt-3">
              <h5 class="col-md-4">Transaksi Item</h5>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Jumlah Transaksi Item</label>
              <span class="col-md">: {{ $itemTransaction }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Jumlah Uang Transaksi Item</label>
              <span class="col-md">: {{ number_format($item) }}</span>
            </div>
            <hr>
            <div class="form-row">
              <label for="" class="col-md-4">Mulai Shift</label>
              <span class="col-md">: {{ date('Y-m-d H:i',strtotime($shift->open_at)) }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Close Shift</label>
              <span class="col-md">: {{ date('Y-m-d H:i',strtotime($shift->close_at)) }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Uang saat mulai shift</label>
              <span class="col-md">: {{ number_format($shift->beginning_cash) }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Total uang transaksi</label>
              <span class="col-md">: {{ number_format($item + $ticket) }} </span>
              {{-- <i>(Jumlah uang transaksi tiket + Jumlah uang transaksi item)</i> --}}
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Total uang yang harus disetorkan</label>
              <span class="col-md">: {{ number_format($shift->expected_cash) }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Jumlah uang tunai sebenarnya</label>
              <span class="col-md">: {{ number_format($shift->actual_cash) }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Selisih</label>
              <span class="col-md">: {{ number_format($shift->difference) }}</span>
            </div>
            <div class="form-row">
              <label for="" class="col-md-4">Catatan</label>
              <span class="col-md">: {{ $shift->notes ?? '-' }}</span>
            </div>
            <div class="form-group">
              <a href="{{ route('printShift',['id'=>$shift->id]) }}" target="_blank " class="btn btn-primary"><i class="fa fa-save fa-download"></i> Print / Download</a>
              <a href="{{ route('reportShift') }}" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Kembali</a>
            </div>
        </div>
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection