<!DOCTYPE html>
<html>
<title>Struk</title>
<style>
  @page {
    margin: 0px;
    /* size: 226.772pt; */
  }
  body { margin: 10px; }
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

<body>
  {{-- <div id="watermark"><img src="{{ asset("storage/background/bg.jpeg") }}" height="100%" width="100%"></div> --}}
  <div class="event" style="">
    <code>
      <h2 style="font-size:20px;font-weight:500;margin-top:-5px">ALC RACE</h2>
      <h3 style="font-size:13px;font-weight:500;margin-top:-15px">WAHANA BERMAIN ANAK</h3>
    </code>
  </div>
  <div class="cart">
    <code>
      <table width="100%" border="0" style="margin-bottom:10px">
        <tbody>
          <tr>
            <td>KUTABUMI, TANGGERANG</td>
          </tr>
        </tbody>
      </table>
      <table width="100%" border="0" style="margin-bottom:10px">
          <tbody>
            <tr>
              <td colspan="2" style="text-align:center;padding-bottom:5px;">Tiket Terusan Wahana</td>
            </tr>
            <tr>
              <td>Tanggal </td>
              <td>: {{ date('d-m-Y, H:i',strtotime($transaction->created_at)) }}</td>
            </tr>
            <tr>
              <td>Transaksi No </td>
              <td>: {{ $transaction->transaction_number }}</td>
            </tr>
          </tbody>
        </table>
      <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td>ITEM</td>
            <td align="right">QTY</td>
          </tr>
          @foreach ($transaction->item as $item)
            <tr>
              <td>{{ $item->name }}</td>
              <td align="right">x{{ $item->cart->quantity }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <br>
      <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <p style="text-align:center;font-size:12px;margin-top:15px">hanya berlaku untuk tanggal <br>{{ date('d-m-Y',strtotime($transaction->created_at)) }}</p>
      <p style="text-align:center;font-size:12px;margin-top:-20px">** Terima Kasih **</p>
    </code>
  </div>
  {{-- <div class=""></div> --}}
    <script>
      window.focus();
      window.print();
    </script>
</body>
</html>
