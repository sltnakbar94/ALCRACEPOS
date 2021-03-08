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
  .shift td {
    padding:5px;
  }
</style>

<body>
  {{-- <div id="watermark"><img src="{{ asset("storage/background/bg.jpeg") }}" height="100%" width="100%"></div> --}}
  <div class="event" style="">
    <code>
      <table width="100%" border="0" style="margin-bottom:-5px">
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
    </code>
  </div>
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
            <td width="75px">Kasir</td>
            <td align="left">: {{ str2word(Auth::user()->name,1) }}</td>
          </tr>
          <tr>
            <td width="75px">SHIFT ID</td>
            <td align="left">: {{ $shift->id }}</td>
          </tr>
          <tr>
            <td colspan="2">REKAP PER-SHIFT</td>
          </tr>
        </tbody>
      </table>
      <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <p style="font-size:15px;margin:5px 0px -10px 0px;">TRANSAKSI TIKET</p>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td>Jumlah transaksi</td>
            <td align="left">: {{ $ticketTransaction }}</td>
          </tr>
          <tr>
            <td>Jumlah uang transaksi</td>
            <td align="left">: {{ number_format($ticket) }}</td>
          </tr>
        </tbody>
      </table>
      <p style="font-size:15px;margin:15px 0px -10px 0px;">TRANSAKSI ITEM</p>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td>Jumlah transaksi</td>
            <td align="left">: {{ $itemTransaction }}</td>
          </tr>
          <tr>
            <td>Jumlah uang transaksi</td>
            <td align="left">: {{ number_format($item) }}</td>
          </tr>
        </tbody>
      </table>
      <div style="margin-top:25px;border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td>MULAI SHIFT</td>
          </tr>
          <tr>
            <td>{{ date('Y-m-d H:i' ,strtotime($shift->open_at)) }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>CLOSE SHIFT</td>
          </tr>
          <tr>
            <td>{{ date('Y-m-d H:i' ,strtotime($shift->close_at)) }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>UANG SAAT MULAI SHIFT</td>
          </tr>
          <tr>
            <td>{{ number_format($shift->beginning_cash) }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>TOTAL UANG TRANSAKSI</td>
          </tr>
          <tr>
            <td>{{ number_format($shift->total_transaction) }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>TOTAL UANG YANG HARUS DISETORKAN</td>
          </tr>
          <tr>
            <td>{{ number_format($shift->expected_cash) }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>JUMLAH UANG TUNAI SEBENARNYA</td>
          </tr>
          <tr>
            <td>{{ number_format($shift->actual_cash) }}</td>
          </tr>
           <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>SELISIH</td>
          </tr>
          <tr>
            <td>{{ number_format($shift->difference) }}</td>
          </tr>
           <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>CATATAN</td>
          </tr>
          <tr>
            <td>{{ $shift->notes ?? '-' }}</td>
          </tr>
        </tbody>
      </table>
      <div style="margin-top:25px;border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <br>
      <p style="text-align:center;font-size:12px;margin-top:65px">-- TTD & NAMA STORE MANAGER --</p>
      <p style="text-align:center;font-size:12px;margin-top:-20px">dibutuhkan tanda tangan / paraf STORE MANAGER untuk keperluan serah terima uang</p>
    </code>
  </div>
  {{-- <div class=""></div> --}}
    {{-- <script>
      window.focus();
      window.print();
    </script> --}}
</body>
</html>
