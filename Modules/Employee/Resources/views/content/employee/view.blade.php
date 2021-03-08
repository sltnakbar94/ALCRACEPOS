@extends('core::layouts/master')
@section('title','Member')

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
                { data: 'additional.phone', name: 'additional.phone'},
                { data: 'role.display_name', name: 'role.display_name',"orderable": false, "searchable": false},
                { data: 'action', name: 'action', "orderable": false, "searchable": false }
          ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
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
        <li class="breadcrumb-item active" aria-current="page">Member</li>
      </ol>
      <h6 class="slim-pagetitle">Member</h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-md-12">
          @include('flash::message')
        </div>
        <div class="col-lg-12 mb-3">
          <a href="#" class="btn btn-primary mr-2" data-toggle="tooltip" title="Muat ulang halaman" data-placement="top"><i class="fa fa-refresh"></i></a>
          <a href="{{ route('employeeCreate') }}" class="btn btn-success mr-2"><i class="fa fa-plus"></i> Tambah Member</a>
        </div>
        <div class="col-lg-12">
          {{ Form::open(['method' => 'post','id'=>'bulkAction']) }}
          <table class="table display nowrap" width="100%" id="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Staf</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Level Access</th>
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