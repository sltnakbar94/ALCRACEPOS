@extends('core::layouts/master')
@section('title','Kasir Tiket')
@section('content')    
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Kasir</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kasir Tiket</li>
      </ol>
      <h6 class="slim-pagetitle">Kasir Tiket</h6>
    </div><!-- slim-pageheader -->

    <div class="section-wrapper">
      <div class="row">
        <div class="col-md-7">
          <div class="row mb-4">
            <div class="col-md-12">
              <h4 class="title">With Timer</h4>
              <hr>
            </div>
            @foreach ($withTimer as $key => $item)
              <div class="col-md-4 mb-3">
                {{-- <a href="{{ route('cashTicketCartUp',['code' => $item->code]) }}" data-toggle="modal" data-target="#myModal{{ $item->code }}">                 --}}
                <a href="{{ route('cashTicketCartUp',['code' => $item->code]) }}">
                  <div class="card card-body bg-primary">
                    <h4 class="tx-white text-center">
                      {{ $item->name }} <br>
                      <small>{{ $item->timer_count.' Menit' }}</small><br>
                      <small>Rp. {{ number_format($item->rates) }}</small>
                    </h4>
                  </div>
                </a>
              </div>
              {{-- <div id="myModal{{ $item->code }}" class="modal fade">
                <div class="modal-dialog modal-dialog-vertical-center" role="document">
                  <div class="modal-content bd-0 tx-14">
                    <div class="modal-header">
                      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Jumlah Tiket</h6>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    {{ Form::open(['route' => 'cashTicketCartBasic','autocomplete' => 'off']) }}
                    <div class="modal-body pd-25">
                      <div class="form-group">
                        <label for="">Masukan Jumlah Tiket</label>
                        <input type="hidden" name="type" value="basic">
                        <input type="hidden" name="code" value="{{ $item->code }}">
                        <input type="text" name="quantity" value="1" id="" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                    {{ Form::close() }}
                  </div>
                </div><!-- modal-dialog -->
              </div><!-- modal -->   --}}
            @endforeach
          </div>
          <div class="row mb-4">
            <div class="col-md-12">
              <h4 class="title">One Time</h4>
              <hr>
            </div>
            @foreach ($oneTime as $key => $item)
              <div class="col-md-4">
                {{-- <a href="{{ route('cashTicketCartUp',['code' => $item->code]) }}" data-toggle="modal" data-target="#myModal{{ $item->code }}">                 --}}
                <a href="{{ route('cashTicketCartUp',['code' => $item->code]) }}">
                  <div class="card card-body bg-primary">
                    <h4 class="tx-white text-center">
                      {{ $item->name }} <br>
                      <small>Rp. {{ number_format($item->rates) }}</small>
                    </h4>
                  </div>
                </a>
              </div>
              {{-- <div id="myModal{{ $item->code }}" class="modal fade">
                <div class="modal-dialog modal-dialog-vertical-center" role="document">
                  <div class="modal-content bd-0 tx-14">
                    <div class="modal-header">
                      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Jumlah Tiket</h6>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    {{ Form::open(['route' => 'cashTicketCartBasic','autocomplete' => 'off']) }}
                    <div class="modal-body pd-25">
                      <div class="form-group">
                        <label for="">Masukan Jumlah Tiket</label>
                        <input type="hidden" name="type" value="basic">
                        <input type="hidden" name="code" value="{{ $item->code }}">
                        <input type="text" name="quantity" value="1" id="" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                    {{ Form::close() }}
                  </div>
                </div><!-- modal-dialog -->
              </div><!-- modal --> --}}
            @endforeach
          </div>
          <div class="row">
            <!-- <div class="col-md-12">
              <h4 class="title">Lainnya</h4>
              <hr>
            </div>
            <div class="col-md-4">
              <a href="javascript:;" data-toggle="modal" data-target="#myModal{{ 'Tiket' }}">
                <div class="card card-body bg-primary">
                  <h4 class="tx-white text-center" style="margin: 10px 0px;">{{ 'Tiket Terusan' }}
                  </h4>
                </div>
              </a>
            </div>
            <div class="col-md-4">
              <a href="javascript:;" data-toggle="modal" data-target="#myModal{{ 'Cashback' }}">
                <div class="card card-body bg-primary">
                  <h4 class="tx-white text-center" style="margin: 10px 0px;">{{ 'Cashback' }}
                  </h4>
                </div>
              </a>
            </div> -->
          </div>
        </div>
        <div class="col-sm">
          @include('flash::message')
          <a href="{{ route('cashTicketClear') }}" class="btn btn-block btn-outline-danger mb-3"><i class="fa fa-trash"></i> Reset Transaksi</a>
          {{ Form::open(['route' => 'cashTicketStore' ,'autocomplete' => 'off']) }}
          <input type="hidden" name="ticket_type" value="{{ request('type') ?? 'basic' }}">
          <input type="hidden" name="transaction" value="{{ $transaction }}">
          <input type="hidden" name="subtotal" value="{{ Cart::subtotal()  }}">
          <div class="row">
            <div class="col-sm-5">
              <p>Nomor Transaksi :</p>
              <p>Nama Staff :</p>
              @if (request('type') == 'pass') <p>Tiket :</p> @endif
            </div>
            <div class="col-sm-7">
              <p>{{ $transaction }}</p>
              <p>{{ Auth::user()->name }}</p>
              @if (request('type') == 'pass') <p>Terusan</p> @endif
            </div>
          </div>
          <div class="row mt-4 mb-2">
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>Wahana</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (Cart::content() as $key => $res)
                    <tr>
                      <td>{{ $res->name }}<span class="float-right">x{{ $res->qty }}</span></td>
                      <td>{{ number_format($res->price) }}</td>
                      <td>{{ number_format($res->total) }}</td>
                      <td>
                        @if (request('type') == 'pass')
                          <a href="{{ route('cashTicketRemove',['rowid' => $key, 'type' => 'pass']) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        @else
                          <a href="{{ route('cashTicketRemove',['rowid' => $key]) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <p>Total Belanja : </p>
              <p>Cashback :</p>
              <p>Total Item :</p>
            </div>
            <div class="col-sm-7">
              <p>Rp. {{ Cart::subtotal() }}</p>
              <p>Rp. {{ Cart::discount() }}</p>
              <p>{{ Cart::count() }}</p>
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
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="btn-group-toggle w-100 btn-group btn-d-flex payment" data-toggle="buttons">
                {{-- <label class="btn w-100 btn-outline-primary active">
                  <input type="radio" name="payment" value="tunai" autocomplete="off">
                  <i class="fa fa-money"></i> Tunai
                </label> --}}
                {{-- <label class="btn w-100 btn-outline-primary cash">
                  <input type="radio" name="payment" value="debit" autocomplete="off">
                  <i class="fa fa-credit-card"></i> Debit
                </label> --}}
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <button class="btn btn-outline-secondary btn-block active charge"><i class="fa fa-file-text-o"></i> Bayar</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div><!-- section-wrapper -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->

{{-- Modal Tiket Terusan --}}
<div id="myModal{{ 'Tiket' }}" class="modal fade">
  <div class="modal-dialog modal-lg" style="width:100%" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">(Tiket Terusan) Pilih Wahana</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {{ Form::open(['route' => 'cashTicketCartPass','autocomplete' => 'off']) }}
          <input type="hidden" name="ticket_type" value="pass">
          <div class="modal-body pd-20">
            <div class="row">
              <div class="col-md-6">
                <h5 class="mg-b-10">With Timer</h5>
                <hr>
                @foreach ($withTimer as $key => $item)
                <div class="form-group">
                  <label class="ckbox">
                    <input value="{{ $item->code }}" name="code[]" type="checkbox"><span>{{ $item->name }}</span>
                  </label>
                </div>
                @endforeach
              </div>
              <div class="col-md-6">
                <h5 class="mg-b-10">One Time</h5>
                <hr>
                @foreach ($oneTime as $key => $item)
                <div class="form-group">
                  <label class="ckbox">
                    <input value="{{ $item->code }}" name="code[]" type="checkbox"><span>{{ $item->name }}</span>
                  </label>
                </div>
                @endforeach
              </div>
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
          {{ Form::close() }}
        </div>
      </div><!-- modal-dialog -->
</div><!-- modal -->

{{-- Modal Tiket Terusan --}}
<div id="myModal{{ 'Cashback' }}" class="modal fade">
  <div class="modal-dialog modal-lg" style="width:30%" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Cashback Per Transaksi</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {{ Form::open(['route' => 'cashTicketCashback','autocomplete' => 'off']) }}
          <input type="hidden" name="ticket_type" value="{{ request('type') ?? 'basic' }}">
          <div class="modal-body pd-20">
            <div class="form-group">
              <label for="">Nominal Cashback (%)</label>
              <input type="number" name="cashback" id="" class="form-control">
            </div>
            {{-- <div class="form-group">
              <label for="">Notes</label>
              <textarea name="notes" id="" cols="30" rows="3" class="form-control"></textarea>
            </div> --}}
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
          {{ Form::close() }}
        </div>
      </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection


