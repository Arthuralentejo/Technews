<?php

namespace App\Controller\Pages;

use App\Controller\BaseController;
use App\Model\NewsModel;
use App\Utils\View;
use Exception;

/**
 *
 */
class Home extends BaseController
{
    /**
     * @param $limit
     * @return string
     * @throws Exception
     */
    public static function getHomePage($limit): string
    {
        $itens = '';
        $news = (new NewsModel())->load(
            order: 'id DESC',
            limit: $limit);
        while ($objNews = $news->fetchObject(NewsModel::class)) {
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
     * @return array|false|string|string[]
     * @throws Exception
     */
    public static function getHome()
    {
        $content = View::render('pages/home', [
            'news' => self::getHomePage(3)
        ]);
        return parent::getPage('TechNews - Home', $content);
    }
}