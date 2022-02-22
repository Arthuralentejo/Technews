<?php

namespace App\Controller\Pages;
use App\Controller\BaseController;
use App\Http\Response;
use App\Repository\Database;
use App\Utils\View;
use Exception;

class Publish extends BaseController{

  
  public static function getPublishForm(){
    $content =  View::render('pages/publish',[
      'action' => 'Publish',
      'title' => '',
      'content' => '',
    ]);
    return parent::getPage('TechNews - Publish News',$content);
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