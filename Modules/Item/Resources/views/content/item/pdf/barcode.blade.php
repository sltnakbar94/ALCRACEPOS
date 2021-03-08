<!DOCTYPE html>
<html>
<title>{{ $item->name }}</title>
<style>
  
  @page { margin: 0px; }
  body { font-family: 'Lato', sans-serif; margin: 0px; }
  .barcode{
    padding-top:25px
  }
</style>
<body style="text-align:center;">
  <div class="barcode">
    <div style="text-align: center;">
      <img src="data:image/png;base64,{{ $barcode }}" alt="barcode" /><br>	
      <code style="font-size:13px">{{$item->code}}</code>
    </div>
  </div>
</body>
</html>
