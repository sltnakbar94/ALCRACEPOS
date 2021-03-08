@role('storemanager')
  @if ($employee->hasRole(['superadministrator']))
    <a href="javascript:;" class="btn btn-secondary disabled mr-1 btn-sm"><i class="fa fa-ban"></i> Ubah</a>
    <a href="javascript:;" class="btn btn-danger disabled btn-sm"><i class="fa fa-ban"></i> Hapus</a>
  @else
    @if ($employee->id == Auth::user()->id)
      <a href="javascript:;" class="btn btn-secondary disabled mr-1 btn-sm"><i class="fa fa-ban"></i> Ubah</a>
      <a href="javascript:;" class="btn btn-danger disabled btn-sm"><i class="fa fa-ban"></i> Hapus</a>
    @else
      <a href="{{ route('employeeEdit',['id' => $employee->id]) }}" class="btn btn-secondary mr-1 btn-sm"><i class="fa fa-pencil"></i> Ubah</a>
      <a href="javascript:;" onclick="deleteRow('{{ route('employeeDelete',['id' => $employee->id]) }}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>    
    @endif
  @endif
@endrole

@role('superadministrator')
  @if ($employee->id == Auth::user()->id)
    <a href="javascript:;" class="btn btn-secondary disabled mr-1 btn-sm"><i class="fa fa-ban"></i> Ubah</a>
    <a href="javascript:;" class="btn btn-danger disabled btn-sm"><i class="fa fa-ban"></i> Hapus</a>
  @else
    <a href="{{ route('employeeEdit',['id' => $employee->id]) }}" class="btn btn-secondary mr-1 btn-sm"><i class="fa fa-pencil"></i> Ubah</a>
    <a href="javascript:;" onclick="deleteRow('{{ route('employeeDelete',['id' => $employee->id]) }}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>    
  @endif
@endrole