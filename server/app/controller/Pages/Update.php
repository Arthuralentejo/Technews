<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Repository\Database;
use App\Model\Entity\News as NewsEntity;
use Exception;
use App\Http\Response;

class Update extends Page{

  public static function getUpdateForm($id)  {
    if (!$id) {
      return new Response(404, 'Page not found');
    }
    $db = new Database('news');
    $dbReturn = $db->select('id=' . $id);
    if (!$dbReturn) {
      return new Response(404, 'News not found');
    }
    $news = $dbReturn->fetchObject(NewsEntity::class);
    $content =  View::render('pages/publish',[
      'action' => 'Update',
      'title' => $news->title,
      'content' => $news->content
    ]);
    return parent::getPage('TechNews - Update News',$content);
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
