<?php

namespace App\Utils;

class View{
  private static function getContentView($view){
    
    $file = dirname(__DIR__,2).'/resource/view/'.$view.'.html';
    return file_exists($file) ? file_get_contents($file) : '';
  }

  public static function render($view, $data = []) {
    $contentView = self::getContentView($view);

    $keys = array_keys($data);
    $keys = array_map(function($key){
      return '{{'.$key.'}}';
    }, $keys);



    // echo "<pre>";
    // print_r($keys);
    // echo "</pre>";

    return str_replace($keys, array_values($data), $contentView);
  }
}
