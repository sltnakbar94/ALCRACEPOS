<a href="{{ route('counterEdit',['id' => $wahana->id,'device' => $wahana->device_id]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i></a>
<a href="javascript:;" onclick="deleteRow('{{ route('counterDestroy',['id' => $wahana->id,'device' => $wahana->device_id]) }}')" class="btn mr-2 btn-sm btn-danger btn-rounded"><i class="fa fa-trash"></i></a>