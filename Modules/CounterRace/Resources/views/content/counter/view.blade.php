@extends('core::layouts/master')
@section('title','Counter Wahana Race')

@section('js')
<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
@foreach ($wahana as $counter)
@foreach ($counter->counter as $item)
  <script>
    @if(date('Y-m-d H:i:s') > $item->end_at)
      var seconds = '0';
    @else
      var seconds = '{{ $item->end_at }}';
    @endif
    $('#timer{{ $item->id }}').countdown(seconds, function(event) {
      $(this).html(event.strftime('%M:%S'));
      if (event.type == 'finish') {
        $('.counter{{ $item->id }} a').attr("href", "{{ route('counterRaceStart',['id' => $item->id]) }}");
        $('.counter{{ $item->id }} .card').removeClass('bg-danger');
        $('.counter{{ $item->id }} .card').addClass('bg-primary');
        $('.counter{{ $item->id }} .stat').text('Ready');
        @if(date('Y-m-d H:i:s') < $item->end_at)
          var sound = document.getElementById("audio");
          sound.play();
        @endif
        // window.location.replace("{{ route('counterRaceReset',['id' => $item->id]) }}");
      }
      console.log(event);
    });
  </script>
@endforeach
@endforeach
@endsection


@section('content')
<audio id="audio" src="{{ asset('notification.mp3') }}" autostart="false" ></audio>
<div class="slim-mainpanel">
  <div class="container">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Cashier</a></li>
        <li class="breadcrumb-item active" aria-current="page">Counter Wahana Race</li>
      </ol>
      <h6 class="slim-pagetitle">Counter Wahana Race</h6>
    </div><!-- slim-pageheader -->

    <div class="row">
      @foreach ($wahana as $item)
        <div class="col-md-12">
          <h4>{{ $item->name }}</h4>
          <hr>
        </div>
        @foreach ($item->counter as $counter) 
          <div class="col-md-3 mb-3 counter{{ $counter->id }}">
            @if(date('Y-m-d H:i:s') < $counter->end_at)
            <a href="{{ route('counterRaceReset',['id' => $counter->id]) }}">
            @else
            <a href="{{ route('counterRaceStart',['id' => $counter->id]) }}">        
            @endif
              <div class="card card-body @if(date('Y-m-d H:i:s') < $counter->end_at) bg-danger @else bg-primary @endif ">
                <h4 class="tx-white text-center">
                  {{ $counter->name }}
                </h4>
                <small class="tx-white text-center" style="font-size:18px;margin-bottom:10px" id="timer{{ $counter->id }}"></small>
                @if(date('Y-m-d H:i:s') < $counter->end_at)
                  <h3 class="tx-white stat text-center">On Going</h3>
                @else
                  <h3 class="tx-white stat text-center">Ready</h3>
                @endif
              </div>
            </a>
          </div>
        @endforeach
      @endforeach
    </div>

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection