@extends('core::layouts/master')
@section('title','Item')
@section('js')
    <script>
      $('#codeFocus').keypress(function(event){
        if(event.keyCode == 13){
          $('#nameFocus').focus();
          event.preventDefault();
          return false;
        }
      });
    </script>
@endsection 
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Item</li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Item</li>
      </ol>
      <h6 class="slim-pagetitle">Item <small>(Tambah Item)</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          @include('flash::message')
          {{ Form::open(['route' => 'itemStore']) }}
            <div class="input-group mb-3">
              <input type="number" name="code" value="{{ old('code') == false ? request('generateUniq') : old('code') }}" id="codeFocus" autofocus class="form-control">
              <div class="input-group-append">
                <a href="{{ route('generateCodeItem') }}" class="btn btn-primary">Generate Code</a>
              </div>
              <span class="text-danger">{{ $errors->first('code') }}</span>
            </div>
            <div class="form-group">
              <label for="">Nama Item</label>
              <input type="text" name="item" value="{{ old('item') }}" id="nameFocus" class="form-control">
              <span class="text-danger">{{ $errors->first('item') }}</span>
            </div>
            <div class="form-group">
              <label for="">Harga Jual</label>
              <input type="number" name="price" value="{{ old('price') }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('price') }}</span>
            </div>
            <div class="form-group">
              <label for="">Stok Awal</label>
              <input type="number" name="stock" value="{{ old('stock') }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('stock') }}</span>
            </div>
            <div class="form-group">
              <label for="">Status</label>
              <select name="status" id="" class="form-control select2-search" data-placeholder="- Pilih -">
                <option label="- Pilih -"></option>
                <option @if(old('status') == 'publish') selected @endif value="publish">Publish</option>
                <option @if(old('status') == 'unpublish') selected @endif value="unpublish">Unpublish</option>
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