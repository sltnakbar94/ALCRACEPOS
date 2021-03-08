@extends('core::layouts/master')
@section('title','Best Selling Item')
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
                { data: 'name', name: 'name',"orderable": false},                
                { data: 'buy_price', name: 'buy_price',"orderable": false},                
                { data: 'price', name: 'price',"orderable": false},                
                { data: 'qty_aggregate', name: 'qty_aggregate', "orderable": false},                
                { data: 'aggregate', name: 'aggregate', "orderable": false},                
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
          <li class="breadcrumb-item" aria-current="page">Selisih Penjualan</li>
          <li class="breadcrumb-item active" aria-current="page">Item</li>
        </ol>
        <h6 class="slim-pagetitle">Selisih Penjualan</small></h6>
      </div><!-- slim-pageheader -->
      <div class="card card-body">
        <div class="row">
          <div class="col-lg">
            <div class="alert alert-info">
              <h4 class="alert-title"><i class="fa fa-info fa-fw"></i> Informasi</h4>
              <span class="text-bold">Harga Beli didapatkan dari data terakhir atau terkini pada form penerimaan barang</span>
            </div>
            <table class="table display nowrap" width="100%" id="table">
              <thead>
                <tr>
                  <th width="5%">Rank</th>
                  <th>Item</th>
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Qty Terjual</th>
                  <th>Hasil Penjualan</th>
                </tr>
              </thead>
            </table>
          </div>
        </div><!-- row -->
      </div><!-- card -->
    </div>
  </div><!-- container -->
@endsection
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Best Selling</li>
        <li class="breadcrumb-item active" aria-current="page">Item</li>
      </ol>
      <h6 class="slim-pagetitle">Best Selling Item</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          
        </div>
      </div><!-- row -->
    </div><!-- card -->
  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection