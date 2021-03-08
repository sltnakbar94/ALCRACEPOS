<a href="{{ route('itemEdit',['id' => $item->id]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i></a>
<a href="javascript:;" onclick="deleteRow('{{ route('itemDestroy',['id' => $item->id]) }}')" class="btn mr-1 btn-sm btn-danger btn-rounded"><i class="fa fa-trash"></i></a>
<a target="_blank" href="{{ route('itemBarcode',['id' => $item->id]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-print"></i> Barcode</a>
