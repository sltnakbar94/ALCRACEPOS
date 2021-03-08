@extends('core::layouts/master')
@section('title','Refund')

@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Item</li>
      </ol>
      <h6 class="slim-pagetitle">Refund</h6>
    </div><!-- slim-pageheader -->

    <div class="card card-pricing-one">
      <div class="row mb-3">
        <div class="col-md-12">
          <div class="alert alert-info">
            <h4 class="alert-title">Informasi</h4>
            Akses <span class="font-weight-bold">Store Manager</span> diperlukan untuk melakukan refund.
          </div>
        </div>
      </div>
      {{-- <hr> --}}
      <div class="row">
        <div class="col-md-5">
          @include('flash::message')
          {{ Form::open(['route' => 'refundItemStore' ,'method' => 'post']) }}
          <input type="hidden" name="transaction_number" value="{{ $transaction->transaction_number }}">
          <input type="hidden" name="item" value="{{ $itemInfo->id }}">
          <div class="form-group">
            <label for="">Quantity yang dikembalikan ?</label>
            <input type="number" name="quantity" id="" class="form-control">
            <span class="text-danger">{{ $errors->first('quantity') }}</span>
          </div>
          <div class="form-group">
            <label for="">Catatan</label>
            <textarea name="notes" id="" cols="30" rows="2" class="form-control"></textarea>
            <span class="text-danger">{{ $errors->first('notes') }}</span>
          </div>
          <hr>
          <div class="form-group">
            <label for="">Store Manager</label>
            <select name="store_manager" id="" class="form-control select2-search" data-placeholder="- Pilih -">
              <option label="- Pilih -"></option>
              @foreach ($storeManager as $item)
                <option value="{{ $item->email }}">{{ $item->name }}</option>
              @endforeach
            </select>
            <span class="text-danger">{{ $errors->first('store_manager') }}</span>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="">PIN <small>(6 Digit)</small></label>
                <input type="password" name="pin" value="{{ old('pin') }}" maxlength="6" id="" class="form-control">
                <span class="text-danger">{{ $errors->first('pin') }}</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-block btn-success"><i class="fa fa-mail-forward fa-fw"></i>Refund</button>
          </div>
          {{ Form::close() }}
        </div>
        <div class="col-md">
          <div class="form-row">
            <label for="" class="col-md-4">Nomor Transaksi</label>
            <p class="col-md">: {{ $transaction->transaction_number }}</p>
          </div>
          <div class="form-row mb-3">
            <label for="" class="col-md-4">Tanggal Transaksi</label>
            <p class="col-md">: {{ $transaction->created_at }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-4">Kode Item</label>
            <p class="col-md">: {{ $itemInfo->item->code }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-4">Item</label>
            <p class="col-md">: {{ $itemInfo->item->name }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-4">Harga / Jumlah</label>
            <p class="col-md">: {{ number_format($itemInfo->price) }} / x{{ $itemInfo->quantity }}</p>
          </div>
          <div class="form-row">
            <label for="" class="col-md-4">Subtotal</label>
            <p class="col-md">: {{ number_format($itemInfo->subtotal) }}</p>
          </div>
        </div>
        
      </div>
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection