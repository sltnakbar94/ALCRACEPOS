@extends('core::layouts/master')
@section('title','Kasir Item')

@section('js')
@if ($transaction)
<script>
    $(document).ready(function(){
          // $('input[type="text"]').focus(); 
            print("{{ route('cashItemReceipt',['number' => request('number')]) }}");
    })
    function print(doc) {
         var objFra = document.createElement('iframe');   // CREATE AN IFRAME.
         objFra.style.visibility = "hidden";    // HIDE THE FRAME.
         objFra.style.display = "none";
         objFra.src = doc;                      // SET SOURCE.
         document.body.appendChild(objFra);  // APPEND THE FRAME TO THE PAGE.
         objFra.contentWindow.focus();       // SET FOCUS.
         objFra.contentWindow.print();      // PRINT IT.
        //  $('input[type="text"]').focus(); 
      }
      
    </script>
@endif
@endsection

@section('content')    
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#"></a></li>
        <li class="breadcrumb-item active" aria-current="page"></li>
      </ol>
      <h6 class="slim-pagetitle">Transaksi Sukses</h6>
    </div><!-- slim-pageheader -->

    <div class="section-wrapper">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1>Transaksi Sukses</h1>
        </div>
        <div class="col-md-6">
          <h4 class="float-right" style="font-weight:100">{{ date('d M Y, h:i',strtotime($transaction->created_at)) }}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <h4 style="font-weight:100">Nomor transaksi</h4>
        </div>
        <div class="col-md-4">
          <h4 style="font-weight:100">: {{ $transaction->transaction_number }}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <h4 style="font-weight:100">Total</h4>
        </div>
        <div class="col-md-4">
          <h4 style="font-weight:100">: Rp {{ number_format($total) }}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <h4 style="font-weight:100">Pembayaran {{ $transaction->payment }}</h4>
        </div>
        <div class="col-md-4">
          <h4 style="font-weight:100">: Rp {{ number_format($transaction->cash) }}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <h4 style="font-weight:100">Kembali</h4>
        </div>
        <div class="col-md-4">
          <h4 style="font-weight:100">: Rp {{ number_format($transaction->change) }}</h4>
        </div>
      </div>
      <hr>
      <div class="row text-center">
        <div class="col-md-12">
          <a href="{{ route('cashItemSuccess',['number' =>request('number')]) }}" class="btn btn-secondary mr-3"><i class="fa fa-print fa-fw"></i> CETAK ULANG STRUK BELANJA</a>
          <a href="{{ route('cashItemView') }}" class="btn btn-success"><i class="fa fa-shopping-cart fa-fw"></i> MULAI TRANSAKSI BARU</a>
        </div>
      </div>
    </div><!-- section-wrapper -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->

<!-- MODAL GRID -->
<div id="modaldemo" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bd-0 bg-transparent rounded overflow-hidden">
      <div class="modal-body pd-0">
        <div class="row no-gutters">
          <div class="col-lg-6 bg-primary">
            <div class="pd-40">
              <h1 class="tx-white mg-b-20">slim</h1>
              <p class="tx-white op-7 mg-b-30">We work with clients big and small across a range of sectors and we utilise all forms of media to get your name out there in a way that’s right for you. We believe that analysis of your company and your customers is key in responding effectively to your promotional needs and we will work with you to fully understand your business to achieve the greatest amount of publicity possible so that you can see a return from the advertising.</p>
              <p class="tx-white">
                <span class="tx-uppercase tx-medium d-block mg-b-15">Our Address:</span>
                <span class="op-7">Ayala Center, Cebu Business Park, Cebu City, Cebu, Philippines 6000</span>
              </p>
            </div>
          </div><!-- col-6 -->
          <div class="col-lg-6 bg-white">
            <div class="pd-y-30 pd-xl-x-30">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="pd-x-30 pd-y-10">
                <h3 class="tx-gray-800 tx-normal mg-b-5">Welcome back!</h3>
                <p>Sign in to your account to continue</p>
                <br>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Enter your email">
                </div><!-- form-group -->
                <div class="form-group mg-b-20">
                  <input type="email" name="password" class="form-control" placeholder="Enter your password">
                  <a href="" class="tx-12 d-block mg-t-10">Forgot password?</a>
                </div><!-- form-group -->

                <button class="btn btn-primary btn-block">Sign In</button>

                <div class="mg-t-30 mg-b-20">Don't have an account yet? <a href="">Sign Up</a></div>
              </div>
            </div><!-- pd-20 -->
          </div><!-- col-6 -->
        </div><!-- row -->
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection