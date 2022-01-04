<?php 
namespace App\Utils;


class Enviroment{
  

  public static function load($dir){
    if(!file_exists($dir)){
      return false;
    }
    $content = file($dir.'/.env');
    foreach ($content as $line) {
      putenv(trim($line));
    }
  }
}