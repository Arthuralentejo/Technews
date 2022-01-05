<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Utils\Database;
use \Exception;
use App\http\Response;
class Update extends Page{

  public static function getPublishForm(){
    $content =  View::render('pages/publish');
    return parent::getPage('TechNews - Home',$content);
  }

  public static function Update($request = null){
    exit;
    $db = new Database('news');
    $ins = $request->getPostVars();
    $ins['date'] = date('Y-m-d H:i:s');
    try {
      $db->insert($ins);
      $resp = new Response(201,'');
      $resp->addHeader('Location','/');

      return $resp;
    } catch (Exception $e) {
      return new Response(500,$e->getMessage());
    }
  }
}