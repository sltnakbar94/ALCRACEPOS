@extends('core::layouts/master')
@section('title','Wahana')
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Wahana</li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Varian</li>
      </ol>
      <h6 class="slim-pagetitle">Wahana <small>(Ubah Varian)</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          @include('flash::message')
          {{ Form::open(['route' => 'counterUpdate','method' => 'patch']) }}
          <input type="hidden" name="id" value="{{ $counter->id }}">
            {{-- <div class="form-group">
              <label for="">Nomor</label>
              <input type="text" class="form-control" name="counter_number" value="{{ old('counter_number') }}">
              <span class="text-danger">{{ $errors->first('counter_number') }}</span>
            </div> --}}
            <div class="form-group">
              <label for="">Nama Varian</label>
              <input type="text" class="form-control" name="name" value="{{ old('name') ?? $counter->name }}">
              <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group">
              <button class="btn btn-primary">Simpan</button>
              <a href="{{ route('counterView',['id' => request('device')]) }}" class="btn btn-secondary">Kembali</a>
            </div>
          {{ Form::close() }}
        </div>
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection