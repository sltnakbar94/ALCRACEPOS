@extends('core::layouts/master')
@section('title','Dashboard')

@section('content')
<div class="slim-mainpanel">
    <div class="container fluid pd-t-30">
        <div class="dash-headline-two">
            <div>
                <h2 class="tx-inverse mg-b-5">Selamat Datang Di Aplikasi POS ALC Race, {{ Auth::user()->name }}!</h2>
                <p class="mg-b-0">Sekarang Tanggal {{ date('F Y, d') }}</p>
            </div>
        </div><!-- dash-headline-two -->
        @role('superadministrator')
        <hr>
        <div id="container" class="mb-3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <div class="row row-xs mb-3">
            <div class="col-lg-12">
                <div class="card card-sales">
                    <h6 class="slim-card-title tx-primary">Pendapatan Wahana</h6>
                    <div class="row">
                        <div class="col">
                            <label class="tx-12">Hari Ini</label>
                            <p>{{ number_format($dayTicket) }}</p>
                        </div><!-- col -->
                        <div class="col">
                            <label class="tx-12">Bulan Ini</label>
                            <p>{{ number_format($monthTicket) }}</p>
                        </div><!-- col -->
                        <div class="col">
                            <label class="tx-12">Tahun Ini</label>
                            {{-- <p>{{ number_format($yearTicket) }}</p> --}}
                            <p>{{ '-' }}</p>
                        </div><!-- col -->
                    </div><!-- row -->
                    <div class="progress mg-b-5">
                        <div class="progress-bar bg-primary wd-100p" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="tx-12 mg-b-0">Berikut rincian transaksi wahana hari ini <a href="{{ route('transTicketView',['staff'=>'','from' => date('d-m-Y'),'to' => date('d-m-Y')]) }}" class="">klik disini</a></p>
                </div>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-body">
                    <h6 class="slim-card-title tx-primary mb-3">Penjualan Tiket Wahana Bulan {{ request('month') == false ? 'Ini' : $LOL_month }}</h6>
                    <div class="form-group">
                        <form class="form-inline" action="{{url('/dashboard/month')}}" method="POST">
                            @csrf
                            <input type="month" name="month" class="form-control mb-4 mr-sm-2">
                            <button type="submit" style="background:#4880D0;color:white;" class="form-control badge-primary mb-4 mr-sm-2"><i class="fa fa-refresh"></i> PERBARUI</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered">
                            <thead class="thead-colored bg-primary">
                                <tr>
                                    <th class="wd-10p">Tanggal</th>
                                    <th>Jumlah Tiket</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportTicket as $item)
                                <tr>
                                    <td align="center">{{ $item['date'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['value'] }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td align="center"><span class="tx-primary">TOTAL</span></td>
                                    <td><span class="font-weight-bold">{{ number_format($sum_quantity) }}</span></td>
                                    <td><span class="font-weight-bold">{{ number_format($sum_subtotal) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endrole
    </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection
@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
  $('.month.filter').change(function(){
    window.location.replace("{{ url('dashboard') }}?month="+$(this).val());
  })
  Highcharts.chart('container', {
      chart: {
          type: 'line'
      },
      title: {
          text: 'Statistik Pendapatan'
      },
      subtitle: {
          text: 'Statistik Pendapatan Per-Tahun {{ date("Y") }}'
      },
      xAxis: {
          categories: {!! json_encode($statisticYear['legend']) !!}
      },
      yAxis: {
          title: {
              text: ''
          },
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: true
          }
      },
      series: {!! json_encode($statisticYear['series']) !!}
  });
</script>
@endsection
