@extends('core::layouts/master')
@section('title','Item')
@section('js')
    <script>
      $(document).ready( function () {
          'use strict';
          $('#table').DataTable({
            "order": [[ 3, "asc" ]],
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
                  { data: 'code', name: 'code'},                
                  { data: 'name', name: 'name'},
                  { data: 'stock.quantity', name: 'stock.quantity'},
                  { data: 'action', name: 'action',"orderable": false, "searchable": false},
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
      <h6 class="slim-pagetitle">Tambah Stok <small>(Item)</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <table class="table display nowrap" width="100%" id="table">
        <thead>
          <th>No</th>
          <th>Code</th>
          <th>Item</th>
          <th>Stock</th>
          <th>#</th>
        </thead>
      </table>
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection