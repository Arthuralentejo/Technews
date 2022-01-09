<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Model\Entity\News as NewsEntity;
use \App\Utils\Database;
use \App\Utils\Pagination;
class News extends Page{
  public static function getNewsItens($request,&$pagination,$limit = 9){
    $itens = '';
    $total = (new Database('news'))->select(null,null,null,'COUNT(*) as total')->fetchObject()->total;
    $page = $request->getQueryParams()['page'] ?? 1;
    $pagination = new Pagination($total,$page,$limit);

    try {
      $db = (new Database('news'))->select('', 'id DESC', $pagination->getLimit());
      while($objNews = $db->fetchObject(NewsEntity::class)){
        $itens .= View::render('pages/cards', [
          'id' => $objNews->id,
          'title' => $objNews->title,
          'content' => substr("$objNews->content", 0, 50),
          'date' => $objNews->date
        ]);
      }
      return $itens;
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public static function getSingleNewsPage($id){
    try {
      $db = (new Database('news'))->select('id='.$id);
      $objNews = $db->fetchObject(NewsEntity::class);
      $content = View::render('pages/singleNews', [
        'id' => $objNews->id,
        'title' => $objNews->title,
        'content' => $objNews->content,
        'date' => $objNews->date
      ]);
    } catch (\Exception $e) {
      throw $e;
    }
    return parent::getPage('TechNews - '.$objNews->title,$content);
  }


  public static function getNewsPage($request){
    $content =  View::render('pages/news',[
      'news' => self::getNewsItens($request,$pagination),
      'pagination' => parent::getPagination($request,$pagination)
    ]);
    return parent::getPage('TechNews - News',$content);
  }
}