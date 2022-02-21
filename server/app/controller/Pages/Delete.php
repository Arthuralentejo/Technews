<?php

namespace App\Controller\Pages;
use App\Utils\View;
use App\Repository\Database;
use Exception;
use App\Http\Response;

class Delete{

  public static function delete($id = null){
    $db = new Database('news');
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