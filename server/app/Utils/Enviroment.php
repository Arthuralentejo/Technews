<?php 
namespace App\Utils;


/**
 * Class Enviroment
 *
 * @package  App\Utils
 */
class Enviroment{


    /**
     * @param $dir
     * @return false|void
     */
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