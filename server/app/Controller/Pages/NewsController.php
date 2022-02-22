<?php

namespace App\Controller\Pages;
use App\Controller\BaseController;
use App\Http\Request;
use App\Model\NewsModel;
use App\Utils\Pagination;
use App\Utils\View;
use Exception;

/**
 * Class NewsController
 *
 * @package App\Controller\News
 */
class NewsController extends BaseController{
    /**
     * @param Request $request
     * @param Pagination $pagination
     * @param int $limit
     * @return string
     * @throws Exception
     */
    public function getNewsItens(Request $request, Pagination &$pagination, int $limit = 9): string
    {
    $itens = '';
    $newsModel = new NewsModel();
    $total = $newsModel->loadAll(
        fields: "COUNT(*) as total"
    );
//    var_dump($total);
//    die;
//    $total = (new Database('news'))->select(null,null,null,'COUNT(*) as total')->fetchObject()->total;
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
    public function getSingleNewsPage($id){
        $db = (new Database('news'))->select('id='.$id);
        $objNews = $db->fetchObject(NewsEntity::class);
        $content = View::render('pages/singleNews', [
          'id' => $objNews->id,
          'title' => $objNews->title,
          'content' => $objNews->content,
          'date' => $objNews->date
        ]);
        return $this->getPage('TechNews - '.$objNews->title,$content);
  }


    /**
     * @param $request
     * @return string
     * @throws Exception
     */
    public function getNewsPage($request): string
    {
    $content =  View::render('pages/news',[
      'news' => $this->getNewsItens($request),
      'pagination' => $this->getPagination($request,$pagination)
    ]);
    return parent::getPage('TechNews - NewsController',$content);
  }
}