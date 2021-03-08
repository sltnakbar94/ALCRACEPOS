@extends('core::layouts/master')
@section('title','Dashboard')

@section('content')
    <div class="slim-mainpanel">
      <div class="container fluid pd-t-30">
        <div class="dash-headline-two">
          <div>
            {{-- <h2 class="tx-inverse mg-b-5">Selamat Datang Di Aplikasi POS ALC Race, {{ Auth::user()->name }}!</h2> --}}
            <p class="mg-b-0">Sekarang Tanggal {{ date('F Y, d') }}</p>
          </div>
        </div><!-- dash-headline-two -->
        <hr>
        <div class="statistic">
          <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
@endsection

@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
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
          categories: {!! json_encode($yearly['legend']) !!}
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
      series: {!! json_encode($yearly['series']) !!}
  });
</script>
@endsection
