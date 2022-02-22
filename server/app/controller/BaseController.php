<?php

namespace App\Controller;

use App\Http\Request;
use App\Utils\Pagination;
use App\Utils\View;


/**
 * Class BaseController
 *
 * @package App\Controller
 */
abstract class BaseController{
    /**
     * @return string
     */
    private static function getHeader(): string
    {
    return View::render('pages/header');
  }

    /**
     * @return string
     */
    private static function getFooter(): string
    {
    return View::render('pages/footer');
  }

    /**
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */
    public static function getPagination(Request $request, Pagination $pagination): string
    {
    $pages = $pagination->getPages();

    if(count($pages) <= 1) return '';

    $links = '';

    $url = $request->getRouter()->getCurrentUrl();
    $queryParams = $request->getQueryParams();
    foreach ($pages as $page) {
      $queryParams['page'] = $page['page'];
      $link = $url.'?'.http_build_query($queryParams);
      $links .= View::render('pages/pagination/link', [
        'page' => $page['page'],
        'link' => $link,
        'active' => $page['current'] ? 'active' : ''
      ]);
    }
    return View::render('pages/pagination/box', [
      'links' => $links
    ]);
  }

    /**
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $content): string
  {
    return View::render('pages/page', [
      'page-title' => $title,
      'header' => self::getHeader(),
      'footer' => self::getFooter(),
      'page-content' => $content
    ]);
  }

    /**
     * @param string $url
     * @return void
     */
    public function redirect(string $url)
    {
        header("Location: " . $url);
    }

}
