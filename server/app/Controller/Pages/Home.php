<?php

namespace App\Controller\Pages;
use App\Utils\View;
use App\Repository\Database;
use App\Model\Entity\News as NewsEntity;
use Exception;

class Home extends Page{
  public static function getHomePage($limit){
    $itens = '';
    try {
      $db = (new Database('news'))->select('', 'id DESC', $limit);
      while($objNews = $db->fetchObject(NewsEntity::class)){
        $itens .= View::render('pages/cards', [
          'id' => $objNews->id,
          'title' => $objNews->title,
          'content' => substr("$objNews->content", 0, 50),
          'date' => $objNews->date
        ]);
      }
      return $itens;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public static function getHome(){
      $content =  View::render('pages/home',[
        'news' => self::getHomePage(3)
      ]);
      return parent::getPage('TechNews - Home',$content);
  }
}