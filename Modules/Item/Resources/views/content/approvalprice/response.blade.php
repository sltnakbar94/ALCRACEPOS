@extends('core::layouts/master')
@section('title','Persetujuan Perubahan Harga')

@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Item</a></li>
        <li class="breadcrumb-item active" aria-current="page">Persetujuan Perubahan Harga</li>
      </ol>
      <h6 class="slim-pagetitle">Persetujuan Perubahan Harga</h6>
    </div><!-- slim-pageheader -->

    <div class="row">
      <div class="col-md-6">
        <div class="card card-body">
          <div class="form-row">
            <label for="" class="col-md-6">Kode</label>
            <p>{{ $item->item->code }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-6">Item</label>
            <p>{{ $item->item->name }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-6">Harga Sebelumnya</label>
            <p>{{ number_format($item->previous_price) }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-6">Harga Yang Diajukan</label>
            <p>{{ number_format($item->price) }}</p>
          </div>
        </div>
      </div><!-- row -->
      <div class="col-md-6">
        <div class="card card-body">
          <a href="{{ route('approvalItemStoreGet',['id' => $item->id,'status'=>'Approved']) }}" class="btn btn-block btn-success"><i class="fa fa-check fa-fw"></i> Setuju Melakukan Perbuahan Harga</a>
          <br>
          <a href="javascript:;" data-toggle="modal" data-target="#myModal{{ 'not' }}" class="btn btn-block btn-danger"><i class="fa fa-close fa-fw"></i> Tidak Setuju Melakukan Perbuahan Harga</a>
        </div>
      </div>
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->

<div id="myModal{{ 'not' }}" class="modal fade">
  <div class="modal-dialog modal-lg" style="width:30%" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Berikan Alasan</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {{ Form::open(['route' => 'approvalItemStorePost','autocomplete' => 'off']) }}
          <input type="hidden" name="id" value="{{ $item->id }}">
          <input type="hidden" name="status" value="Not Approved">
          <div class="modal-body pd-20">
            <div class="form-group">
              <label for="">Alasan</label>
              <textarea name="reason" id="" cols="30" rows="3" class="form-control"></textarea>
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
          {{ Form::close() }}
        </div>
      </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection