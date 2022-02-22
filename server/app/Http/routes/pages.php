y<?php

use App\Http\Request;
use App\Http\Response;
use App\Controller\Pages;
/**
 * @var App\Http\Router $router
 */

$router->get('/',[
    /**
     * @return Response
     */ function() : Response
    {
        return new Response(200,Pages\IndexController::getHome());
    }
]);

$router->get('/news',[
    /**
     * @param $request
     * @return Response
     */ function($request) : Response
    {
        return new Response(200,Pages\NewsController::getNewsPage($request));
    }
]);
$router->get('/news:page',[
    /**
     * @param Request $request
     * @return Response
     */ function($request) : Response
    {
        return new Response(200,Pages\NewsController::getNewsPage($request));
    }
]);
$router->get('/news:id',[
    /**
     * @param int $id
     * @return Response
     * @throws Exception
     */ function(int $id) : Response
    {
        return new Response(200,Pages\NewsController::getSingleNewsPage($id));
    }
]);
$router->get('/publish',[
    /**
     * @return Response
     */ function() : Response
    {
        return new Response(200,Pages\Publish::getPublishForm());
    }
]);
$router->post('/publish',[
    /**
     * @param $request
     * @return Response
     */ function($request) : Response
    {
        return Pages\Publish::publish($request);
    }
]);
$router->get('/news/update:id',[
    /**
     * @param $id
     * @return Response
     */ function($id) : Response
    {
        return new Response(200,Pages\Update::getUpdateForm($id));
    }
]);

$router->post('/news/update:id',[
    /**
     * @param $request
     * @return Response
     */ function($request) : Response
    {
        return Pages\Update::Update($request);
    }
]);

$router->delete('/news/delete:id', [
    /**
     * @param $id
     * @return Response
     */ function($id) : Response
    {
        return Pages\Delete::delete($id);
    }
]);
