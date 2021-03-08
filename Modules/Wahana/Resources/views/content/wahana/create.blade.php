@extends('core::layouts/master')
@section('title','Wahana')
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Wahana</li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Perangkat</li>
      </ol>
      <h6 class="slim-pagetitle">Wahana <small>(Tambah Perangkat)</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          @include('flash::message')
          {{ Form::open(['route' => 'wahanaStore']) }}
            <div class="form-group">
              <label for="">Nama Perangkat</label>
              <input type="text" name="name" value="{{ old('name') }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group">
              <label for="">Tarif</label>
              <input type="text" name="price" value="{{ old('price') }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('price') }}</span>
            </div>
            <div class="form-group">
              <label for="">Tipe Wahana</label>
              <select name="type" id="" class="form-control select2-search" data-placeholder="- Pilih -">
                <option label="- Pilih -"></option>
                <option @if(old('type') == 'One Time') selected @endif value="One Time">One Time</option>
                <option @if(old('type') == 'With Timer') selected @endif value="With Timer">With Timer</option>
              </select>
              <span class="text-danger">{{ $errors->first('type') }}</span>
            </div>
            <div class="form-group">
              <label for="">Timer Count 
                <small>(isi form ini jika wahana bertipe <span class="font-weight-bold">With Timer</span>)</small>
              </label>
              <div class="row">
                <div class="col-md-2">
                  <input type="text" name="timer_count" value="{{ old('timer_count') }}" id="" class="form-control">
                </div>
                <div class="col-md-2">
                  <span>Menit</span>
                </div>
                <div class="col-md-12">
                  <span class="text-danger">{{ $errors->first('timer_count') }}</span>
                </div>
              </div>
            </div>
            {{-- <div class="form-group">
              <label for="">Status</label>
              <select name="status" id="" class="form-control select2-search" title="- Pilih -">
                <option @if(old('status') == 'Ready') selected @endif value="Ready">Ready</option>
                <option @if(old('status') == 'Maintenance') selected @endif value="Maintenance">Maintenance</option>
                <option @if(old('status') == 'Out Of Order') selected @endif value="Out Of Order">Out Of Order</option>
              </select>
              <span class="text-danger">{{ $errors->first('status') }}</span>
            </div> --}}
            <div class="form-group">
              <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              <a href="{{ route('wahanaView') }}" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Kembali</a>
            </div>
          {{ Form::close() }}
        </div>
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection