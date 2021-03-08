<!DOCTYPE html>
<html>
<title>Ticket</title>
<style>
  @page {
    margin: 0px;
    /* size: 226.772pt; */
  }
  body {
       margin: 10px;

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
  .page-break {
    page-break-after: always;
  }
</style>

<body>
  @foreach ($transaction->item as $item)

  @for ($i = 0; $i < $item->cart->quantity; $i++)
    {{-- <div id="watermark"><img src="{{ asset("storage/background/bg.jpeg") }}" height="100%"></div> --}}
    <div class="event">
      <code>
        <table border="0" style="margin-bottom:-5px">
          <tbody>
            <tr>
              <td>
                <h2 style="font-size:20px;font-weight:500;margin-top:-5px">ALC RACE TIKET</h2>
              </td>
            </tr>
            <tr>
              <td>
                <h3 style="font-size:13px;font-weight:500;margin-top:-15px">WAHANA BERMAIN ANAK</h3>
              </td>
            </tr>
          </tbody>
        </table>
      </code>
    </div>
    <div class="cart">
      <code>
        <table border="0" style="margin-bottom:10px">
          <tbody>
            <tr>
              <td>Kutabumi , Tanggerang</td>
            </tr>
          </tbody>
        </table>
        <table border="0" style="margin-bottom:10px">
          <tbody>
            <tr>
              <td colspan="2" style="text-align:center;padding-bottom:5px;font-weight:bold;">Tiket Wahana</td>
            </tr>
            <tr>
              <td width="95px">Tanggal </td>
              <td>: {{ date('d-m-Y, H:i',strtotime($transaction->created_at)) }}</td>
            </tr>
            <tr>
              <td>Transaksi No </td>
              <td>: {{ $transaction->transaction_number }}</td>
            </tr>
          </tbody>
        </table>
        <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
        <h2 style="margin-top:0px;text-align:center">{{ $item->name }}</h2>
        <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
        <p style="text-align:center;font-size:12px;margin-top:15px">hanya berlaku untuk 1x (Satu Kali) bermain pada tanggal {{ date('d-m-Y',strtotime($transaction->created_at)) }}</p>
        <p style="text-align:center;font-size:12px;margin-top:-20px">** Terima Kasih **</p>
      </code>
    </div>
    <div class="page-break"></div>
  @endfor
  @endforeach
  {{-- <div class=""></div> --}}
    <script>
      window.focus();
      window.print();
    </script>
</body>
</html>
