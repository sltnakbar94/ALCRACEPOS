@extends('core::layouts/master')
@section('title','Rincian Transaksi')

@section('js')
    <script>
      @if(request('receipt'))
        $(document).ready(function(){
            print("{{ route('cashItemReceipt',['number' => request('number')]) }}");
        })
        function print(doc) {
          var objFra = document.createElement('iframe');   // CREATE AN IFRAME.
          objFra.style.visibility = "hidden";    // HIDE THE FRAME.
          objFra.src = doc;                      // SET SOURCE.
          document.body.appendChild(objFra);  // APPEND THE FRAME TO THE PAGE.
          objFra.contentWindow.focus();       // SET FOCUS.
          objFra.contentWindow.print();      // PRINT IT.
          //  $('input[type="text"]').focus(); 
        }   
      @endif
    </script>
@endsection

@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Transaksi Item</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rincian</li>
      </ol>
      <h6 class="slim-pagetitle">Rincian Transaksi</h6>
    </div><!-- slim-pageheader -->

    <div class="card mb-3 card-body">
      <h4 class="card-title">Riwayat Transaksi</h4>
      <div class="row">
        <div class="col-md-12">
          @include('flash::message')
          <div class="form-row">
            <label for="" class="col-md-2">Nomor Transaksi</label>
            <span class="col-md">: {{ $transaction->transaction_number }}
              <a href="{{ route('transItemDetail',['receipt' => 'true','number' => $transaction->transaction_number]) }}" class="btn btn-sm btn-secondary float-right"><i class="fa fa-print fa-fw"></i> Print Transaksi</a>
            </span>
          </div>
          <div class="form-row">
            <label for="" class="col-md-2">Tanggal Transaksi</label>
            <p class="col-md">: {{ $transaction->created_at }}</p>
          </div>
        </div>
        <div class="col-md-12">
          <table class="table display nowrap" width="100%" id="table">
            <thead>
              <tr>
                <td>Item</td>
                <td>Quantity</td>
                <td>Harga</td>
                <td>Diskon</td>
                <td>Subtotal</td>
                <td>#</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($transaction->cart as $item)    
              <tr>
                <td>{{ $item->item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ number_format($item->disc).'%' }}</td>
                <td>{{ number_format($item->subtotal) }}</td>
                <td>
                  @if (Auth::user()->hasRole('staff'))
                    <a href="{{ route('refundItemView',['transNum' => $transaction->transaction_number,'item' => $item->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-mail-forward fa-fw"></i> Refund</a>
                  @else
                    <a href="javascript:;" class="btn disabled btn-danger btn-sm"><i class="fa fa-ban fa-fw"></i> Refund</a>  
                  @endif
                </td>
              </tr>
              @endforeach
              <tr>
                <td align='center' colspan='4'><span class="font-weight-bold">TOTAL</span></td>
                <td colspan='2'>{{ number_format($totalTransaction) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- card -->
    <div class="card card-body">
      <h4 class="card-title">Riwayat Pengembalian</h4>
      <div class="row">
        <div class="col-md-12">
          @include('flash::message')
        </div>
        <div class="col-md-12">
          <table class="table display nowrap" width="100%" id="table">
            <thead>
              <tr>
                <td>Item</td>
                <td>Quantity</td>
                <td>Harga</td>
                <td>Diskon</td>
                <td>Subtotal</td>
                <td>#</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($transaction->refund as $item)    
              <tr>
                <td>{{ $item->item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ number_format($item->disc).'%' }}</td>
                <td>{{ number_format($item->subtotal) }}</td>
                <td><a href="javascript:;" class="btn btn-danger disabled btn-sm"><i class="fa fa-mail-forward fa-fw"></i> Refunded</a></td>
              </tr>
              @endforeach
              <tr>
                <td align='center' colspan='4'><span class="font-weight-bold">TOTAL</span></td>
                <td colspan='2'>{{ number_format($totalRefund) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- card -->
  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection