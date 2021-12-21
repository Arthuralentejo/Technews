<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Model\News;

class Home extends Page{


    public static function getHome(){
      $objNews =  new News();
      
      $content =  View::render('pages/home',[
        'id' => $objNews->id,
        'title' => $objNews->title,
        'content' => substr("$objNews->content", 0, 50),
        'date' => $objNews->date
      ]);
      return parent::getPage('TechNews - Home',$content);
    }
}