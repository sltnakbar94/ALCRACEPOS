@extends('core::layouts/master')
@section('title','Laporan Shift')

@section('js')
  <script>
    $(document).ready( function () {
        'use strict';
        $('#table').DataTable({
          // "order": [[ 2, "asc" ]],
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
                { data: 'user.name', name: 'user.name'},                
                { data: 'open_at', name: 'open_at'},
                { data: 'close_at', name: 'close_at'},
                { data: 'beginning_cash', name: 'beginning_cash'},
                { data: 'total_transaction', name: 'total_transaction'},
                { data: 'expected_cash', name: 'expected_cash'},
                { data: 'actual_cash', name: 'actual_cash'},
                { data: 'difference', name: 'difference'},
                { data: 'detail', name: 'detail'},
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
        <li class="breadcrumb-item active" aria-current="page">Laporan Rincian Shift</li>
      </ol>
      <h6 class="slim-pagetitle">Laporan Rincian Shift @if(request('from') == request('to')) - Hari Ini @endif</h6>
    </div><!-- slim-pageheader -->
    @role(['storemanager','superadministrator'])
            <div class="card card-body mb-3">
                {{ Form::open(['method' => 'get','autocomplete' => 'off']) }}    
                <div class="row">
                    <div class="col-sm-3">
                        <label>Nama Staff</label>
                        <div class="input-group">
                            <select class="form-control select2" data-live-seach="true" title="- Pilih -"  name="staff">
                                <option value="">Semua Staff</option>
                                @foreach ($staff as $item)
                                    <option {{ request('staff') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <label>Dari Tanggal</label>
                      <div class="input-group">
                        <input type="text" value="{{ request('from') ?? date('d-m-Y') }}" name="from" class="form-control fc-datepicker" placeholder="Tanggal">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label>Sampai Tanggal</label>
                      <div class="input-group">
                          <input type="text" value="{{ request('to') ?? date('d-m-Y') }}" name="to" class="form-control fc-datepicker" placeholder="Tanggal">
                      </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="col-sm-12" style="margin-top: 29px;">
                            <button class="btn btn-info mg-b-10 mr-3" id="addButton"><i class="fa fa-search mg-r-5"></i> Filter</button>
                            <a href="{{ route('reportShift') }}" class="btn btn-purple mg-b-10" id="addButton"><i class="fa fa-eye mg-r-5"></i> Tampilkan Semua</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            @if (request()->has(['from','to']))
                <div class="alert alert-info">
                    <h4 class="alert-title"><i class="fa fa-info fa-fw"></i> Informasi </h4>
                    Berikut Laporan 
                    @if (request('from') == request('to'))
                    <span class="font-weight-bold">HARI INI</span>
                    @else      
                    Per - Tanggal <span class="font-weight-bold">@if (request()->has(['from','to']))({{ date('d-m-Y',strtotime(request('from'))) }} s/d {{ date('d-m-Y',strtotime(request('to'))) }})@endif </span>
                    @endif
                </div>
            @endif
        @endrole
    @php $total = $totalTransItem + $totalTransTicket - $shift->aggregate_actual_cash; @endphp
    @if ($total > 0)
    <div class="alert alert-danger">
      <h4 class="alert-title"><i class="fa fa-exclamation-circle fa-fw"></i> Warning</h4>
      Terdapat selisih pada Total Transaksi yang ada dengan Total Transaksi pada saat Member melakukan Close Shift <br>
      dengan <span class="font-weight-bold"> Jumlah Selisih {{ number_format($total) }} </span> <br>
      (Penyebab Selisih <span class="font-weight-bold">Member Tidak Melakukan Prosedur CLOSE SHIFT</span>)
    </div>
    @endif
    <div class="card card-body">
      <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card card-body">
                <h6 class="font-weight-light">TOTAL TRANSAKSI TIKET</h6>
                <h4>{{ number_format($totalTransTicket) }}</h4>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body">
                <h6 class="font-weight-light">TOTAL TRANSAKSI ITEM</h6>
                <h4>{{ number_format($totalTransItem) }}</h4>
            </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card card-body">
            <h6 class="font-weight-light">TOTAL UANG TRANSAKSI</h6>
            <h4>{{ number_format($shift->aggregate_actual_cash) }}</h4>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card card-body">
            <h6 class="font-weight-light">TOTAL DISETORKAN</h6>
            <h4>{{ number_format($deposited->aggregate_actual_cash) }}</h4>
          </div>
        </div>
      </div>
    <div class="card card-body">
      <div class="row">
        <div class="col-lg-12">
          {{ Form::open(['method' => 'post','id'=>'bulkAction']) }}
            <table class="table display nowrap" width="100%" id="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Open Shift</th>
                  <th>Close Shift</th>
                  <th>Cash Awal</th>
                  <th>Total Uang Transaksi</th>
                  <th>Total Seharusnya</th>
                  <th>Total Disetorkan</th>
                  <th>Selisih</th>
                  <th></th>
                </tr>
              </thead>
            </table>
          {{ Form::close() }}
        </div><!-- col -->
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection