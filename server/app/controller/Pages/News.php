<?php

namespace App\Controller\Pages;
use App\Controller\BaseController;
use App\Http\Request;
use App\Model\NewsModel;
use App\Utils\Pagination;
use App\Utils\View;
use Exception;

/**
 *
 */
class News extends BaseController{
    /**
     * @param Request $request
     * @param Pagination $pagination
     * @param int $limit
     * @return string
     * @throws Exception
     */
    public static function getNewsItens(Request $request, Pagination &$pagination, int $limit = 9): string
    {
    $itens = '';
    $total = (new Database('news'))->select(null,null,null,'COUNT(*) as total')->fetchObject()->total;
    $page = $request->getQueryParams()['page'] ?? 1;
    $pagination = new Pagination($total,$page,$limit);

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
    }

    /**
     * @param $id
     * @return array|false|string|string[]
     * @throws Exception
     */
    public static function getSingleNewsPage($id){
        $db = (new Database('news'))->select('id='.$id);
        $objNews = $db->fetchObject(NewsEntity::class);
        $content = View::render('pages/singleNews', [
          'id' => $objNews->id,
          'title' => $objNews->title,
          'content' => $objNews->content,
          'date' => $objNews->date
        ]);
        return parent::getPage('TechNews - '.$objNews->title,$content);
  }


    /**
     * @param $request
     * @return array|false|string|string[]
     * @throws Exception
     */
    public static function getNewsPage($request){
    $content =  View::render('pages/news',[
      'news' => self::getNewsItens($request,$pagination),
      'pagination' => parent::getPagination($request,$pagination)
    ]);
    return parent::getPage('TechNews - News',$content);
  }
}