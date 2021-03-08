<!DOCTYPE html>
<html>
<title>Struk</title>
<style>
  @page {
    /* margin-right: 2013px ;
    margin-bottom: 2083px ; */
    /* size: 5cm 10cm;
    margin-top: 0; change the margins as you want them to be. */
    size: 8cm 15cm;
    margin : 0mm ;
  }
  body {
    margin-top: 0mm ;
    margin-left: 0mm ;
    max-width: 30%;
   }
  h2{
    margin-top:10px;
    font-size : 20px;
  }
  p{
    font-size: 20px;
    margin-top:-5px;
    /* margin-bottom:15px */
    padding-bottom:20px
  }
  code table{
    font-size:12px;
  }
</style>

<body style="margin-left: 0mm ; margin-top:0mm">
  {{-- <div id="watermark"><img src="{{ asset("storage/background/bg.jpeg") }}" height="100%" width="100%"></div> --}}
  {{-- <div class="event" style="margin-top:0 ; margin-left:0">
    {{-- <code> --}}
       <table width="100%" border="0">
        <tbody>
          <tr>
            <td>
              <h2 style="font-size:20px;font-weight:500;margin-top:-5px"><h2 style="font-size:20px;font-weight:500;margin-top:-5px">ALC RACE</h2></h2>
            </td>
          </tr>
          <tr>
            <td>
              <h3 style="font-size:13px;font-weight:500;margin-top:-15px">WAHANA BERMAIN ANAK</h3>
            </td>
          </tr>
        </tbody>
      </table>
    {{-- </code> --}}
  {{-- </div> --}}
  <div class="cart">
    <code>
      <table width="100%" border="0" style="margin-bottom:10px">
        <tbody>
          <tr>
            <td>Kutabumi , Tanggerang</td>
          </tr>
        </tbody>
      </table>
      <table width="100%" border="0" style="margin-bottom:10px">
        <tbody>
          <tr>
            <td width="65px">Kasir :</td>
            <td align="left">{{ str2word(Auth::user()->name,1) }}</td>
            <td align="right">No :</td>
            <td align="left">{{ $transaction->transaction_number }}</td>
          </tr>
          <tr>
            <td>Tanggal :</td>
            <td colspan="3">{{ date('d-m-Y, H:i',strtotime($transaction->created_at)) }}</td>
          </tr>
        </tbody>
      </table>
      <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td>ITEM</td>
            <td align="right">QTY</td>
            <td align="right">HARGA</td>
            <td align="right">TOTAL</td>
          </tr>
          @foreach ($transaction->item as $item)
            @if ($item->cart == true)
            <tr>
              <td>{{ $item->name }}</td>
              <td align="right">{{ $item->cart->quantity }}</td>
              <td align="right">{{ number_format($item->cart->price) }}</td>
              <td align="right">{{ number_format($item->cart->subtotal) }}</td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      <br>
      <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td align="right">Subtotal :</td>
            <td align="right">{{ number_format($beforeCashback) }}</td>
          </tr>
          <tr>
            <td align="right">Cashback :</td>
            <td align="right">{{ '-'.number_format($transaction->cashback) }}</td>
          </tr>
          <tr>
            <td align="right">Total :</td>
            <td align="right">{{ number_format($total) }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td align="right">Pembayaran {{ $transaction->payment }} :</td>
            <td align="right">{{ number_format($transaction->cash) }}</td>
          </tr>
          <tr>
            <td align="right">Kembali :</td>
            <td align="right">{{ number_format($transaction->change) }}</td>
          </tr>
        </tbody>
      </table>
      <p style="text-align:center;font-size:12px;margin-top:25px">** Terima Kasih **</p>
    </code>
  {{-- </div> --}}
  {{-- <div class=""></div> --}}
    <script>
    //   window.focus();
    var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}
      window.print();
    </script>
</body>
</html>
