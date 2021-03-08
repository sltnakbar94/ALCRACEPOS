<?php

namespace Modules\Shift\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Modules\Shift\Entities\WorkShift;

use Closure;
use Illuminate\Http\Request;

class CheckShift
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $shift = WorkShift::where(['user_id' => Auth::user()->id])
          ->where(DB::Raw('DATE(open_at)'),date('Y-m-d'))
          ->whereNotNull('close_at')
          ->first();
        if ($shift) {
            return $next($request);
        }else{
            return redirect()->route('successShift');
        }
    }
}
