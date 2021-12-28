<?php

namespace App\Model;
use \App\Db\Database;
use \PDO;
class News {
  function __construct($news_id = null,$date = null,$title,$content) {
    $this->title = $title;
    $this->content = $content;
    $this->date = $date;
    $this->news_id = $news_id;
}

  public $news_id;


  public $title;

  public $content;

  public $date;

  public function addNews(){
    $db = new Database('news');
    $this->id = $db->insert([
      'title' => $this->title,
      'content' => $this->content
    ]);
    return true;
  }
  public static function getNews($id = null){
    $news = new Database('news');
    $resp = $news->select(!is_null($id) ? $id : null)->fetchAll(PDO::FETCH_CLASS);
    $ret; 
    echo '<pre>';
    print_r($resp);
    echo '</pre>';
    return;
  }
}