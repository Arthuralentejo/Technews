<?php

namespace App\Controller\Pages;
use App\Controller\BaseController;
use App\Http\Response;
use App\Model\NewsModel;
use App\Utils\View;
use Exception;

/**
 * Class PublishController
 *
 * @package App\Controller\Pages
 */
class PublishController extends BaseController{


    /**
     * @return string
     */
    public static function getPublishForm(): string
    {
    $content =  View::render('pages/publish',[
      'action' => 'Publish',
      'title' => '',
      'content' => '',
    ]);
    return parent::getPage('TechNews - Publish News',$content);
  }

    /**
     * @param $request
     * @return Response
     */
    public static function publish($request): Response
    {
    $newsModel = new NewsModel();
    $ins = $request->getPostVars();
    $ins['date'] = date('Y-m-d H:i:s');
    try {
      $newsModel->insert($ins);
      $resp = new Response(302,'');
      self::redirect('/');
      return $resp;
    } catch (Exception $e) {
      return new Response(500,$e->getMessage());
    }
  }
}