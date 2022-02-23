<?php

namespace App\Controller\Pages;

use App\Controller\BaseController;
use App\Http\Response;
use App\Model\NewsModel;
use App\Utils\View;
use Exception;

/**
 * Class UpdateController
 *
 * @package App\Controller\Pages
 */
class UpdateController extends BaseController
{

    /**
     * @param $id
     * @return string
     * @throws Exception
     */
    public static function getUpdateForm($id): string
    {
        if (!isset($id)) {
            throw new Exception("Id not found");
        }
        $newsModel = new NewsModel();
        $news = $newsModel->loadById($id);
        if (!isset($news)) {
            throw new Exception("News not found");
        }
        $content = View::render('pages/publish', [
            'action' => 'UpdateController',
            'title' => $news->title,
            'content' => $news->content
        ]);
        return parent::getPage('TechNews - UpdateController NewsController', $content);
    }

    /**
     * @param $request
     * @return Response
     */
    public static function Update($request = null): Response
    {
        $newsModel = new NewsModel();
        $values = $request->getPostVars();
        $id = $request->getQueryParams()['id'];
        try {
            $newsModel->update($id, $values);
            $resp = new Response(204, '');
            $resp->addHeader('Location', '/');
            return $resp;
        } catch (Exception $e) {
            return new Response(500, $e->getMessage());
        }
    }
}
