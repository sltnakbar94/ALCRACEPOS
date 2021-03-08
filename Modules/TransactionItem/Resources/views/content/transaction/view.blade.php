@extends('core::layouts/master')
@section('title','Item')

@section('js')
<script>
    $(document).ready(function () {
        'use strict';
        $('#table').DataTable({
            // "order": [
            //     [1, "desc"]
            // ],
            // responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            processing: true,
            serverSide: true,
            ajax: '{!! $dataTableURL !!}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    "orderable": false,
                    "searchable": false
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'transaction_number',
                    name: 'transaction_number'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'subtotal',
                    name: 'cartSum.aggregate',
                    "orderable": false,
                    "searchable": false
                },
                {
                    data: 'quantity',
                    name: 'itemSum.aggregate',
                    "orderable": false,
                    "searchable": false
                },
                {
                    data: 'action',
                    name: 'action',
                    "orderable": false,
                    "searchable": false
                }
            ]
        });
    });

    function deleteRow(url) {
        $('#bulkAction').attr('action', url);
        $('#bulkAction').append('<input type="hidden" name="_method" value="DELETE">');
        confirmDelete(function () {
            $('#bulkAction').submit();
        });
    }
    
    @if(request('number'))
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
                <li class="breadcrumb-item active" aria-current="page">Transaksi Item</li>
            </ol>
            <h6 class="slim-pagetitle">Transaksi Penjualan Item @if(request('from') == request('to')) - Hari Ini @endif</h6>
        </div><!-- slim-pageheader -->
        @role(['storemanager','superadministrator'])
        @include('flash::message')
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
                            <a href="{{ route('transItemView') }}" class="btn btn-danger mg-b-10" id="addButton"><i class="fa fa-close mg-r-5"></i> Bersihkan Filter</a>
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
        <div class="card card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card card-body">
                        <h6 class="font-weight-light">TRANSAKSI</h6>
                        <h4>{{ number_format($totalTrans) }}</h4>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body">
                        <h6 class="font-weight-light">TOTAL ITEM TERJUAL</h6>
                        <h4>{{ number_format($totalItem) }}</h4>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body">
                        <h6 class="font-weight-light">TOTAL PENJUALAN</h6>
                        <h4>{{ number_format($total) }}</h4>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                {{ Form::open(['method' => 'post', 'id' => 'bulkAction']) }}
                <table class="table display nowrap" width="100%" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kasir</th>
                            <th>No Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Transaksi</th>
                            <th>Total Item</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
                {{ Form::close() }}
            </div><!-- card -->
        </div>

    </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection
