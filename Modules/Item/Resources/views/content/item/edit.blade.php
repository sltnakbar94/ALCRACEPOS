@extends('core::layouts/master')
@section('title','Item')
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Item</li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Item</li>
      </ol>
      <h6 class="slim-pagetitle">Item <small>(Ubah Item)</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          @include('flash::message')
          {{ Form::open(['route' => 'itemUpdate','method' => 'patch']) }}
            <input type="hidden" name="id" value="{{ $item->id }}">
            <div class="form-group">
              <label for="">Kode Item</label>
              <input type="number" disabled name="code" value="{{ $item->code }}" class="form-control">
              <span class="text-danger">{{ $errors->first('code') }}</span>
            </div>
            <div class="form-group">
              <label for="">Nama Item</label>
              <input type="text" name="item" value="{{ $item->name }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('item') }}</span>
            </div>
            @role ('superadministrator')
              <div class="form-group">
                <label for="">Harga Jual</label>
                <input type="text" name="price" value="{{ $item->price }}" id="" class="form-control">
                <span class="text-danger">{{ $errors->first('price') }}</span>
              </div>
            @endrole
            <div class="form-group">
              <label for="">Status</label>
              <select name="status" id="" class="form-control select2-search" data-placeholder="- Pilih -">
                <option label="- Pilih -"></option>
                <option @if($item->status == 'publish') selected @endif value="publish">Publish</option>
                <option @if($item->status == 'unpublish') selected @endif value="unpublish">Unpublish</option>
              </select>
              <span class="text-danger">{{ $errors->first('status') }}</span>
            </div>
            <div class="form-group">
              <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              <a href="{{ route('itemView') }}" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Kembali</a>
            </div>
          {{ Form::close() }}
        </div>
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection