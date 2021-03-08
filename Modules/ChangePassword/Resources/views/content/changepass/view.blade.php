@extends('core::layouts/master')
@section('title','Ganti Password')

@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ganti PIN</li>
      </ol>
      <h6 class="slim-pagetitle">Ganti PIN</h6>
    </div><!-- slim-pageheader -->
    <div class="card card-body">
      <div class="row">
        <div class="col-lg-12">
          @include('flash::message')
          {{ Form::open(['method' => 'post','id'=>'bulkAction','route' => 'storeUserPass']) }}
            <div class="form-group">
              <label for="">Ganti PIN</label>
              <input type="text" name="password" id="" class="form-control">
            </div>
            <div class="form-group">
              <label for="">PIN Baru</label>
              <input type="text" name="newPassword" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('newPassword') }}</span>
            </div>
            <div class="form-group">
              <label for="">Ketik Ulang PIN Baru</label>
              <input type="text" name="retypeNewPassword" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('newPassword') }}</span>
            </div>
            <div class="form-group">
              <button class="btn btn-success">Ganti</button>
            </div>
          {{ Form::close() }}
        </div><!-- col -->
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection