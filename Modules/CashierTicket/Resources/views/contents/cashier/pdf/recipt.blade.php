<!DOCTYPE html>
<html>
<title>Struk</title>
<style>
 @page {
    margin: 0px;
    /* size: 226.772pt; */
  }
  body {
     margin: 10px;
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
  .page-break {
    page-break-after: always;
  }

  .content{
      margin-top: 0;
      margin-left: 0;
  }
</style>
<div class="content">
    <table  border="0">
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
    <div class="cart">
        <table  border="0" style="margin-bottom:10px">
            <tbody>
              <tr>
                <td>Kutabumi , Tanggerang</td>
              </tr>
            </tbody>
          </table>
    </div>
    <table  border="0" style="margin-bottom:10px">
        <tbody>
          <tr>
            <td width="65px">Kasir :</td>
            <td align="left">{{ str2word(Auth::user()->name,1) }}</td>
            <td align="right">No :</td>
            <td align="right">{{ $transaction->transaction_number }}</td>
          </tr>
          <tr>
            <td>Tanggal :</td>
            <td colspan="3">{{ date('d-m-Y, H:i',strtotime($transaction->created_at)) }}</td>
          </tr>
        </tbody>
      </table>
      <div style="border-top: 1px dashed #333; padding: 2px; padding-bottom: -4px; text-align: center; border-bottom: none;">&nbsp;</div>
      <table  border="0">
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
      <table  border="0">
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

</div>
</html>


