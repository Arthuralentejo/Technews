<?php 
require __DIR__.'/vendor/autoload.php';

use App\http\Router;
use App\http\Response;
use App\Controller\Pages\Home;

define('URL', 'http://localhost:80');

$Router = new Router(URL);

$Router->get('/',[
  function(){
    return new Response(200,Home::getHome());
  }
]);