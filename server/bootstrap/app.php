<?php 
require __DIR__.'/../vendor/autoload.php';


use App\Utils\View;

App\Utils\Enviroment::load(__DIR__.'/../');

define('URL', getenv('URL'));

View::init([
  'URL' => URL,
]);