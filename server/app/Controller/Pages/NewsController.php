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
class NewsController extends BaseController
{
    /**
     * @param Request $request
     * @param Pagination $pagination
     * @param NewsModel $newsModel
     * @return string
     */
    public static function getNewsItens(Request $request, Pagination &$pagination, NewsModel &$newsModel): string
    {
        $itens = '';


        $news = $newsModel->loadAll(
            order:'DESC',
            limit: $pagination->getLimit());

        foreach($news as $objNews){
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
     * @return string
     * @throws Exception
     */
    public function getSingleNewsPage($id): string
    {
        $newsModel = new NewsModel();
        $news = $newsModel->loadById($id);
        $objNews = $db->fetchObject(NewsEntity::class);
        $content = View::render('pages/singleNews', [
            'id' => $objNews->id,
            'title' => $objNews->title,
            'content' => $objNews->content,
            'date' => $objNews->date
        ]);
        return $this->getPage('TechNews - ' . $objNews->title, $content);
    }


    /**
     * @param $request
     * @return string
     * @throws Exception
     */
    public static function getNewsPage($request): string
    {
        $newsModel = new NewsModel();
        $total = $newsModel->getTotal();
        $page = $request->getQueryParams()['page'] ?? 1;
        $pagination = new Pagination($total, $page, 9);
        $content = View::render('pages/news', [
            'news' => self::getNewsItens($request, $pagination,$newsModel),
            'pagination' => self::getPagination($request, $pagination)
        ]);
        return parent::getPage('TechNews - NewsController', $content);
    }
}