@extends('core::layouts/master')
@section('title','Item')

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
                { data: 'transaction_number', name: 'transaction_number'},                
                { data: 'created_at', name: 'created_at'},
                { data: 'subtotal', name: 'cartSum.aggregate',"orderable": false, "searchable": false },
                { data: 'action', name: 'action', "orderable": false, "searchable": false }
          ]
        });
    });
    function deleteRow(url){
        $('#bulkAction').attr('action',url);
        $('#bulkAction').append('<input type="hidden" name="_method" value="DELETE">');
        confirmDelete(function(){
          $('#bulkAction').submit();
        });
    }   
  </script>
@endsection

@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Transaksi Item</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rincian Item</li>
      </ol>
      <h6 class="slim-pagetitle">Transaksi Penjualan Item @role('staff')- Hari Ini @endrole</h6>
    </div><!-- slim-pageheader -->

    <div class="row">
      <div class="col-md-3 mb-3">
        <a href="{{ route('transItemView') }}">
          <div class="card card-body">
            <h6 class="font-weight-light">TOTAL PENJUALAN</h6>
            <h4>{{ number_format($total) }}</h4>
          </div>
        </a>
      </div>
      <div class="col-md-3 mb-3">
        <a href="{{ route('transItemView') }}">
          <div class="card card-body">
            <h6 class="font-weight-light">TOTAL ITEM TERJUAL</h6>
            <h4>{{ number_format($totalItem) }}</h4>
          </div>
        </a>
      </div>
    </div>
    <div class="card card-body">
      {{ Form::open(['method' => 'post', 'id' => 'bulkAction']) }}
        <table class="table display nowrap" width="100%" id="table">
          <thead>
            <tr>
              <th>No</th>
              <th>No Transaksi</th>
              <th>Tanggal Transaksi</th>
              <th>Total Transaksi</th>
              <th>#</th>
            </tr>
          </thead>
        </table>
      {{ Form::close() }}
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection