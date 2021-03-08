@extends('core::layouts/master')
@section('title','Laporan Pajak')
@section('js')
  <script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    }); 
  </script>
@endsection
@section('content')
  <div class="slim-mainpanel">
    <div class="container">
      <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Laporan Pajak</li>
        </ol>
        <h6 class="slim-pagetitle">Laporan Pajak</small></h6>
      </div><!-- slim-pageheader -->
      <div class="alert alert-info">
        <h4 class="alert-title"><i class="fa fa-exclamation-circle fa-fw"></i> UNDER CONSTRUCTION</h4>
        Halaman masih berupa <span class="font-weight-bold">MOCKUP</span> dan dalam tahap pengembangan.
      </div>
      <div class="mb-3 card card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Tahun</label>
              <select name="" id="" class="form-control" title="- Pilih -">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
              </select>
            </div>
          </div>
          <div class="col-sm-3">
              <div class="col-sm-12" style="margin-top: 29px;">
                  <button class="btn btn-info mg-b-10" id="addButton"><i class="fa fa-search mg-r-5"></i> Filter</button>
              </div>
          </div>
        </div>
      </div>
      <div class="card card-body">
        <div class="row">
          <div class="col-lg">
            <table class="table display nowrap" width="100%" id="table">
              <thead>
                <tr>
                  <th width="5%">Bulan</th>
                  <th>Total Penjualan</th>
                  <th>DPP (Dasar Pengenaan Pajak)</th>
                  <th>Pajak Yang Harus Dibayarkan (PPN 10%)</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Januari</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Februari</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Maret</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>April</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Mei</td>
                  <td>{{ number_format(453790000) }}</td>
                  <td>{{ number_format(453790000 / 1.1) }}</td>
                  <td>{{ number_format(453790000 / 1.1 * 10 / 100) }}</td>
                  <td>
                    <p class="text-success">Sudah Dibayar</p>
                  </td>
                </tr>
                <tr>
                  <td>Juni</td>
                  <td>{{ number_format(593790000) }}</td>
                  <td>{{ number_format(593790000 / 1.1) }}</td>
                  <td>{{ number_format(593790000 / 1.1 * 10 / 100) }}</td>
                  <td>
                    <p class="text-danger">Belum Dibayar</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!-- row -->
      </div><!-- card -->
    </div>
  </div><!-- container -->
@endsection