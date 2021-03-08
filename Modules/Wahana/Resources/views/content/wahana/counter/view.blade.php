@extends('core::layouts/master')
@section('title','Varian Wahana')
@section('js')
  <script>
    $(document).ready( function () {
        'use strict';
        $('#table').DataTable({
          "order": [[ 1, "desc" ]],
          // "scrollX": true,
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
                { data: 'name', name: 'name'},
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
        <li class="breadcrumb-item">Wahana</li>
        <li class="breadcrumb-item active" aria-current="page">Varian</li>
      </ol>
      <h6 class="slim-pagetitle">Varian Wahana - {{ $devices->name }}
      </h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-row">
            <label class="col-md-5" for="">Wahana</label>
            <p>: {{ $devices->name }}</p>
          </div>
          <div class="form-row">
            <label class="col-md-5" for="">Tarif</label>
            <p>: {{ number_format($devices->rates) }}</p>
          </div>
          <div class="form-row">
            <label class="col-md-5" for="">Waktu Bermain</label>
            <p>: {{ $devices->timer_count.' Menit' }}</p>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-12 mb-3">
              <a href="#" class="btn btn-primary mr-2" data-toggle="tooltip" title="Muat ulang halaman" data-placement="top"><i class="fa fa-refresh"></i></a>
              <a href="{{ route('counterCreate',['id' => request('id')]) }}" class="btn btn-success mr-2"><i class="fa fa-plus"></i> Tambah Varian</a>
            </div>
          </div>
          {{ Form::open(['method' => 'post','id'=>'bulkAction']) }}
          <table class="table display nowrap" width="100%" id="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Varian</th>
                <th>#</th>
              </tr>
            </thead>
          </table>
          {{ Form::close() }}
        </div><!-- col -->
      </div>
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection