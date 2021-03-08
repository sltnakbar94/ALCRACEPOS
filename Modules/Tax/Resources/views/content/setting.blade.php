@extends('core::layouts/master')
@section('title','Pengaturan Pajak')

@section('content')
<div class="slim-mainpanel">
  <div class="container">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengaturan Pajak</li>
      </ol>
      <h6 class="slim-pagetitle">Pengaturan Pajak</h6>
    </div><!-- slim-pageheader -->
    <div class="alert alert-info">
        <h4 class="alert-title"><i class="fa fa-exclamation-circle fa-fw"></i> UNDER CONSTRUCTION</h4>
        Halaman masih berupa <span class="font-weight-bold">MOCKUP</span> dan dalam tahap pengembangan.
      </div>
    <div class="card card-body">
      @include('flash::message')
      <div class="row">
        <div class="col-lg-4">
          {{ Form::open(['method' => 'post','id'=>'bulkAction','route' => 'opTaxStore']) }}
            <div class="form-group">
              <label for="">Nominal Pajak (%)</label>
              <div class="input-group">
                <input type="text" class="form-control" id="" placeholder="Contoh : 10">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupPrepend2">%</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-success">Simpan</button>
            </div>
          {{ Form::close() }}
        </div><!-- col -->
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection