<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Utils\Database;
use \Exception;
use App\http\Response;

class Delete{

  public static function delete($request = null){
    $db = new Database('news');
    $id = $request->getQueryParams()['id'];
    try {
      $db->delete('id='.$id);
      $resp = new Response(302,'');
      $resp->addHeader('location','/');
      return $resp;
    } catch (Exception $e) {
      return new Response(500,$e->getMessage());
    }
  }
}