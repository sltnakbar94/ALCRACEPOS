@extends('core::layouts/master')
@section('title','Kasir Item')

@section('js')
@if ($transaction)
<script>
    $(document).ready(function () {
        @if(request('ticket'))
        print("{!! route('cashTicketReceipt',['ticket' => 'true','number' => request('number')]) !!}");
        @else
        print("{{ route('cashTicketReceipt',['number' => request('number')]) }}");
        @endif
    })

    function print(doc) {
        var objFra = document.createElement('iframe'); // CREATE AN IFRAME.
        objFra.style.visibility = "hidden"; // HIDE THE FRAME.
        objFra.style.display = "none";
        objFra.src = doc; // SET SOURCE.
        document.body.appendChild(objFra); // APPEND THE FRAME TO THE PAGE.
        objFra.contentWindow.focus(); // SET FOCUS.
        objFra.contentWindow.print(); // PRINT IT.
        //  $('input[type="text"]').focus(); 
    }

</script>
@endif
@endsection

@section('content')
<div class="slim-mainpanel">
    <div class="container-fluid">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#"></a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
            <h6 class="slim-pagetitle">Transaksi Sukses</h6>
        </div><!-- slim-pageheader -->

        <div class="section-wrapper">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h1>Transaksi Sukses</h1>
                </div>
                <div class="col-md-6">
                    <h4 class="float-right" style="font-weight:100">
                        {{ date('d M Y, h:i',strtotime($transaction->created_at)) }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h4 style="font-weight:100">Nomor transaksi</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="font-weight:100">: {{ $transaction->transaction_number }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h4 style="font-weight:100">Subtotal</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="font-weight:100">: {{ number_format($beforeCashback) }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h4 style="font-weight:100">Cashback</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="font-weight:100">: {{ '-'.number_format($transaction->cashback) }}</h4>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-5">
                    <h4 style="font-weight:100">Total</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="font-weight:100">: {{ number_format($total) }}</h4>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-5">
                    <h4 style="font-weight:100">Pembayaran {{ $transaction->payment }}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="font-weight:100">: {{ number_format($transaction->cash) }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h4 style="font-weight:100">Kembali</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="font-weight:100">: {{ number_format($transaction->change) }}</h4>
                </div>
            </div>
            <hr>
            <div class="row text-center">
                <div class="col-md-12">
                    <a href="{{ route('cashTicketSuccess',['number' =>request('number')]) }}"
                        class="btn btn-secondary mr-3"><i class="fa fa-print fa-fw"></i> CETAK ULANG STRUK BELANJA</a>
                    <a href="{{ route('cashTicketSuccess',['ticket' => 'true','number' =>request('number')]) }}"
                        class="btn btn-primary mr-3"><i class="fa fa-print fa-fw" target="_blank"></i> CETAK TIKET WAHANA</a>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('cashTicketView') }}" class="btn mt-3 btn-success"><i
                            class="fa fa-shopping-cart fa-fw" target="_blank"></i> MULAI TRANSAKSI BARU</a>
                </div>
            </div>
        </div><!-- section-wrapper -->
    </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection
