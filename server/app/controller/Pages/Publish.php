<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Utils\Database;
use \Exception;
use App\http\Response;

class Publish extends Page{

  
  public static function getPublishForm(){
    $content =  View::render('pages/publish',[
      'action' => 'Publish',
      'title' => '',
      'content' => '',
    ]);
    return parent::getPage('TechNews - Home',$content);
  }

  public static function publish($request = null){
    $db = new Database('news');
    $ins = $request->getPostVars();
    $ins['date'] = date('Y-m-d H:i:s');
    try {
      $db->insert($ins);
      $resp = new Response(302,'');
      $resp->addHeader('location','/');
      return $resp;
    } catch (Exception $e) {
      return new Response(500,$e->getMessage());
    }
  }
}