<?php
if (!function_exists('str2word')){
  function str2word($string, $word_limit)
  {
      $words = explode(" ",$string);
      return implode(" ",array_splice($words,0,$word_limit));
  }
}