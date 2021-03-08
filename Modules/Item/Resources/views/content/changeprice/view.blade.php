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
                { data: 'code', name: 'code'},                
                { data: 'name', name: 'name'},
                { data: 'price', name: 'price'},
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
        <li class="breadcrumb-item active" aria-current="page">Item</li>
      </ol>
      <h6 class="slim-pagetitle">Item</h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg-12">
          {{ Form::open(['method' => 'post','id'=>'bulkAction']) }}
            <table class="table display nowrap" width="100%" id="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Item</th>
                  <th>Harga</th>
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