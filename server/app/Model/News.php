<?php

namespace App\Model;
use \App\Db\Database;
class News {
  function __construct() {
}
  /**
   * @var int
   */
  public $id;

  /**
   * @var string
   */
  public $title;

  /**
   * @var string
   */
  public $content;
  /**
   * @var string
   */
  public $date;

  public function addNews(){
    $db = new Database('news');
    echo '<pre>';
    print_r($db);
    echo '</pre>';

  }
  public static function getNews(){
    
  }

}