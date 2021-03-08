<?php
use Illuminate\Support\Facades\Auth;
use Modules\Shift\Entities\WorkShift;

function CheckShift(){
  $shift = WorkShift::where(['user_id' => Auth::user()->id])
          ->where(DB::Raw('DATE(open_at)'),date('Y-m-d'))
          ->whereNull('close_at')
          ->first();
  if ($shift) {
    return true;
  }else{
    return false;
  }
}
function Shift(){
  $shift = WorkShift::where(['user_id' => Auth::user()->id])
          ->where(DB::Raw('DATE(open_at)'),date('Y-m-d'))
          ->whereNull('close_at')
          ->first();
  if ($shift) {
    return $shift;
  }else{
    return false;
  }
}
function ShiftID(){
  $shift = WorkShift::where(['user_id' => Auth::user()->id])
          ->where(DB::Raw('DATE(open_at)'),date('Y-m-d'))
          ->whereNull('close_at')
          ->first();
  if ($shift) {
    return $shift->id;
  }else{
    return false;
  }
}

