@extends('core::layouts/master')
@section('title','Kasir Item')

@section('js')
  <script type="text/javascript">
    $(document).ready(function(){
      // $('.payment').button('toggle')
      $('#table').DataTable({
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
        },
        "bLengthChange": false
      });
      $('.code').keyup(function(){
        $('.quantity').val('1');
      });
    });
  </script>

  {{-- PWA --}}
  
@endsection

@section('content')    
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Kasir</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kasir Item</li>
      </ol>
      <h6 class="slim-pagetitle">Kasir Item</h6>
    </div><!-- slim-pageheader -->

    <div class="section-wrapper">
      <div class="row">
        <div class="col-sm-8">
          @include('flash::message')
          {{ Form::open(['route' => 'cashItemCart','autocomplete' => 'off']) }}
          <div class="row">
            <div class="col-sm-5">
              <div class="input-group">
                <input type="number" autofocus name="code" class="form-control code" placeholder="Code">
              </div>
              <span class="text-danger">{{ $errors->first('code') }}</span>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <input type="number" name="quantity" class="form-control quantity" id="quantity" placeholder="Jumlah">
              </div>
              <span class="text-danger">{{ $errors->first('quantity') }}</span>
            </div>
            <div class="col-sm-4">
              <button class="btn btn-outline-secondary btn-block mg-b-10" id="cart"><i class="fa fa-plus mg-r-5"></i> Cart</button>
            </div>
          </div>
          {{ Form::close() }}
          <br>
          <div class="table-wrapper">
            {{ Form::open(['route' => 'cashItemCartUpdate']) }}
            <table id="table" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th width="60%">Item / Kode</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>Subtotal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="showData">
                @foreach (Cart::content() as $key => $res)
                  <tr id="K001">
                    <td>
                      {{ $res->name }} /<br>
                      <input type="hidden" name="rowid[]" value="{{ $key }}">{{ $res->id }}
                    </td>
                    <td id="jumlah">
                      x{{ $res->qty }}
                      {{-- <input type="text" name="quantity[]" value="" class="wd-30p form-control"> --}}
                    </td>
                    <td>{{ number_format($res->price) }}</td>
                    <td>{{ number_format($res->total) }}</td>
                    <td>
                      <a href="{{ route('cartItemCartUp',['rowid' => $key]) }}" class="btn btn-success"><i class="fa fa-arrow-circle-up"></i></a>
                      <a href="{{ route('cartItemCartDown',['rowid' => $key]) }}" class="btn mr-3 btn-danger"><i class="fa fa-arrow-circle-down"></i></a>
                      {{-- <button class="btn btn-secondary mr-2"> <i class="fa pl-2 pr-2 fa-refresh"></i> </button> --}}
                      <a href="{{ route('cashItemRemove',['rowid' => $key]) }}" class="btn btn-danger"><i class="fa pl-2 pr-2 fa-trash"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table> 
            {{ Form::close() }}
          </div><!-- table-wrapper -->
        </div><!-- col-4 -->
        <div class="col-sm">
          <a href="{{ route('cashTicketClear') }}" class="btn btn-block btn-outline-danger mb-3"><i class="fa fa-trash"></i> Reset Transaksi</a>
          {{ Form::open(['route' => 'cashItemStore' ,'autocomplete' => 'off']) }}
          <div class="row">
            <div class="col-sm-5">
              <p>Nomor Transaksi :</p>
              <p>Nama Staff :</p>
              <br>
              <br>
              <p>Total Belanja : </p>
              <p>Total Item :</p>
              {{-- <p>Kembali:</p> --}}
            </div>
            <div class="col-sm-7">
              <p>{{ $transaction }}</p>
              <p>{{ Auth::user()->name }}</p>
              <br>
              <br>
              <p>Rp. {{ Cart::subtotal() }}</p>
              <p>{{ Cart::count() }}</p>
              {{-- <p>Rp. 0</p> --}}
            </div>
          </div>
          <p>Bayar :</p>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp.</span>
            </div>
            <input type="number" class="form-control bayar" name="cash" value="" placeholder="0">
          </div>
          <span class="text-danger">{{ $errors->first('cash') }}</span>
          {{-- <div class="row mt-3">
            <div class="col-md-12">
              <div class="btn-group-toggle w-100 btn-group btn-d-flex payment" data-toggle="buttons">
                <label class="btn w-100 btn-outline-primary active">
                  <input type="radio" name="payment" value="tunai" autocomplete="off">
                  <i class="fa fa-money"></i> Tunai
                </label>
                <label class="btn w-100 btn-outline-primary cash">
                  <input type="radio" name="payment" value="debit" autocomplete="off">
                  <i class="fa fa-credit-card"></i> Debit
                </label>
              </div>
            </div>
          </div> --}}
          <div class="row mt-3">
            <div class="col-md-12">
              <button class="btn btn-outline-secondary btn-block active charge"><i class="fa fa-file-text-o"></i> Bayar</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div><!-- row -->
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


    {{-- $('.code').select2({
      placeholder: 'Cari...',
      tags:true,
      minimumInputLength: 3,
      ajax: {
        url: '{{ route("cashItemJson") }}',
        type: "GET",
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          $('#quantity').val('1');
          return {
            results:  $.map(data, function (res) {
              return {
                text: res.code + ' - ' +res.name,
                id: res.code
              }
            })
          };
        },
        cache: true
      }
    }); --}}