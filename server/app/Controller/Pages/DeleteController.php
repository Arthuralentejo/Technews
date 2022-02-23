<?php

namespace App\Controller\Pages;
use App\Controller\BaseController;
use App\Model\NewsModel;
use Exception;
use App\Http\Response;

/**
 * Class DeleteCotroller
 *
 * @package App\Controller\Pages
 */
class DeleteController extends BaseController {

    /**
     * @param $id
     * @return Response
     */
    public static function delete($id = null): Response
    {
    $newsModel = new NewsModel();
    try {
      $newsModel->delete($id);
      $resp = new Response(302,'');
      self::redirect('/');
      return $resp;
    } catch (Exception $e) {
      return new Response(500,$e->getMessage());
    }
  }
}