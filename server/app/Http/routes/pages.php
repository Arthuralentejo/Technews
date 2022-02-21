<?php

use App\Http\Response;
use App\Controller\Pages;
use App\Http\Router;

/**
 * @var Router $router
 */

$router->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);
$router->get('/news',[
    function($request){
        return new Response(200,Pages\News::getNewsPage($request));
    }
]);
$router->get('/news:page',[
    function($request){
        return new Response(200,Pages\News::getNewsPage($request));
    }
]);
$router->get('/news:id',[
    function($id){
        return new Response(200,Pages\News::getSingleNewsPage($id));
    }
]);
$router->get('/publish',[
    function(){
        return new Response(200,Pages\Publish::getPublishForm());
    }
]);
$router->post('/publish',[
    function($request){
        return Pages\Publish::publish($request);
    }
]);
$router->get('/news/update:id',[
    function($id){
        return new Response(200,Pages\Update::getUpdateForm($id));
    }
]);

//let me try this
$router->post('/news/update:id',[
    function($request){
        return Pages\Update::Update($request);
    }
]);


// $router->put('/news/update/{id}',[
//   function($id){
//     return Pages\Update::Update($id);
//   }
// ]);

$router->delete('/news/delete:id',[
    function($id){
        return Pages\Delete::delete($id);
    }
]);
