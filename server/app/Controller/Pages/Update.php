<?php

namespace App\Controller\Pages;

use App\Controller\BaseController;
use App\Http\Response;
use App\Model\Entity\News as NewsEntity;
use App\Repository\Database;
use App\Utils\View;
use Exception;

class Update extends BaseController{

  public static function getUpdateForm($id)  {
    if (!$id) {
      return new Response(404, 'BaseController not found');
    }
    $db = new Database('news');
    $dbReturn = $db->select('id=' . $id);
    if (!$dbReturn) {
      return new Response(404, 'NewsController not found');
    }
    $news = $dbReturn->fetchObject(NewsEntity::class);
    $content =  View::render('pages/publish',[
      'action' => 'Update',
      'title' => $news->title,
      'content' => $news->content
    ]);
    return parent::getPage('TechNews - Update NewsController',$content);
  }

  public static function Update($request = null)
  {
    $db = new Database('news');
    $ins = $request->getPostVars();
    $id = $request->getQueryParams()['id'];
    try {
      $db->update('id='.$id, $ins);
      $resp = new Response(204, '');
      $resp->addHeader('Location', '/');
      return $resp;
    } catch (Exception $e) {
      return new Response(500, $e->getMessage());
    }
  }
}
