@if ($item->updated_at)
<a href="javascript:;" class="btn btn-secondary btn-sm disabled"><i class="fa fa-ban fa-fw"></i> Responded</a>
@else
<a href="{{ route('approvalItemShow',['id' => $item->id]) }}" class="btn btn-secondary btn-sm">Respon</a>
@endif