@extends('core::layouts/master')
@section('title','Daftar Produk')

@section('js')
  <script>
    $(document).ready( function () {
        'use strict';
        $('#table').DataTable({
          "order": [[ 2, "asc" ]],
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
                { data: 'price', name: 'price'},
                { data: 'status', name: 'status'},
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
        <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
      </ol>
      <h6 class="slim-pagetitle">Daftar Produk</h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="alert alert-info">
        <h4 class="alert-header"><i class="fa fa-info-circle fa-fw"></i>Informasi</h4>
        Dibawah ini adalah daftar produk / master produk yang akan dijual, jika anda menjual produk baru silahkan masukan data awal dengan menekan tombol 
        <i>"Tambah produk baru"</i><br>
        <br>  
        Catatan : <br>
        Jika anda ingin memasukan stock barang yg sudah terdaftar di bawah ini silahkan klik <a href="{{ route('receivingView') }}"><i>disini</i></a> Form Penerimaan 
      </div>
      <div class="row">
        <div class="col-lg-12 mb-3">
          <a href="#" class="btn btn-primary mr-2" data-toggle="tooltip" title="Muat ulang halaman" data-placement="top"><i class="fa fa-refresh"></i></a>
          <a href="{{ route('itemCreate') }}" class="btn btn-success mr-2"><i class="fa fa-plus"></i> Tambah produk baru</a>
        </div>
        <div class="col-lg-12">
          {{ Form::open(['method' => 'post','id'=>'bulkAction']) }}
            <table class="table display nowrap" width="100%" id="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Item</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>#</th>
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