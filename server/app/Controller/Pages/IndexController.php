<?php

namespace App\Controller\Pages;

use App\Controller\BaseController;
use App\Model\NewsModel;
use App\Utils\View;
use Exception;

/**
 * Class IndexController
 *
 * @package App\Controller\Pages
 */
class IndexController extends BaseController

{
    /**
     * @param $limit
     * @return string
     * @throws Exception
     */
    public static function getHomePage($limit): string
    {
        $itens = '';
        $news = (new NewsModel())->loadAll(
            order: 'DESC',
            limit: $limit);
        foreach($news as $objNews) {
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
     * @return string
     * @throws Exception
     */
    public static function getHome(): string
    {
        $content = View::render('pages/home', [
            'news' => self::getHomePage(3)
        ]);
        return self::getPage('TechNews - Index', $content);
    }
}