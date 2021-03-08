@extends('core::layouts/master')
@section('title','Penerimaan Barang')
@section('js')
  <script>
    $(document).ready( function () {
        'use strict';
        $('#table').DataTable({
          "order": [[ 1, "desc" ]],
          // responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          },
          aLengthMenu: [
              [10,25, 50, 100, -1],
              [10,25, 50, 100, "All"]
          ],
          processing: true,
          serverSide: true,
          ajax: '{!! $dataTableURL !!}',
          columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, "searchable": false },
                { data: 'quantity', name: 'quantity'},                
                { data: 'buy_prices', name: 'buy_price'},
                { data: 'enter_date', name: 'enter_date'},
                { data: 'notes', name: 'notes'},
          ]
        });
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
        <li class="breadcrumb-item active" aria-current="page">Tambah Stok</li>
      </ol>
      <h6 class="slim-pagetitle">Tambah Stok</h6>
    </div><!-- slim-pageheader -->
    
    <div class="row">
      <div class="col-md-5">
        <div class="card card-body">
          @include('flash::message')
          {{ Form::open(['route' => 'receivingStore']) }}
            <input type="hidden" name="id" value="{{ $item->id }}">
            <div class="form-row">
              <label class="col-md-5" for="">Kode Item</label>
              <p>: {{ $item->code }}</p>
            </div>
            <div class="form-row">
              <label class="col-md-5" for="">Nama Item</label>
              <p>: {{ $item->name }}</p>
            </div>
            <div class="form-row">
              <label class="col-md-5" for="">Stok Sekarang</label>
              <p>: {{ $item->stock->quantity }}</p>
            </div>
            <div class="form-group">
              <label for="">Stok Masuk</label>
              <input type="text" name="quantity" id="{{ old('quantity') }}" class="form-control">
              <span class="text-danger">{{ $errors->first('quantity') }}</span>
            </div>
            <div class="form-group">
              <label for="">Tanggal Masuk</label>
              <input type="text" class="form-control fc-datepicker" name="enter_date" placeholder="DD-MM-YYYY" id="">
              <span class="text-danger">{{ $errors->first('enter_date') }}</span>
            </div>
            <div class="form-group">
              <label for="">Harga Beli Satuan</label>
              <input type="text" name="buy_price" id="{{ old('buy_price') }}" class="form-control">
              <span class="text-danger">{{ $errors->first('buy_price') }}</span>
            </div>
            <div class="form-group">
              <label for="">Keterangan</label>
              <textarea name="notes" id="" cols="30" rows="3" class="form-control">{{ old('notes') }}</textarea>
              <span class="text-danger">{{ $errors->first('notes') }}</span>
            </div>
            <div class="form-group">
              <button class="btn btn-info"><i class="fa fa-save fa-fw"></i> Proses</button>
              <a href="{{ route('changePriceView') }}" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Kembali</a>
            </div>
          {{ Form::close() }}
        </div><!-- card -->
      </div>
      <div class="col-md-7">
        <div class="card card-body">
          <h4 class="card-title">Riwayat Penambahan Stok</h4>
          @include('flash::message')
          {{ Form::open() }}
            <table class="table display nowrap" width="100%" id="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Stok Masuk</th>
                  <th>Harga Beli Satuan</th>
                  <th>Tgl</th>
                  <th>Ket</th>
                </tr>
              </thead>
            </table>
          {{ Form::close() }}
        </div><!-- card -->
      </div>
    </div>

  </div><!-- container -->
</div><!-- slim-mainpanel -->
<!-- modal -->
@endsection