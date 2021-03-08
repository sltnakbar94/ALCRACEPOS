<a href="{{ route('wahanaEdit',['id' => $wahana->id]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i></a>
<a href="javascript:;" onclick="deleteRow('{{ route('wahanaDestroy',['id' => $wahana->id]) }}')" class="btn mr-2 btn-sm btn-danger btn-rounded"><i class="fa fa-trash"></i></a>
@if ($wahana->device_type == 'With Timer')
  <a href="{{ route('counterView',['id' => $wahana->id]) }}" class="btn btn-sm btn-primary">Varian <i class="fa fa-angle-double-right"></i></a>
@endif
