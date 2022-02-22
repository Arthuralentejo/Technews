<?php
use App\Utils\View;

require __DIR__.'/../vendor/autoload.php';


// Isso vai carregar o arquivo .env
App\Utils\Enviroment::load(__DIR__.'/../');

define('URL', getenv('URL'));

View::init([
    'URL' => URL,
]);
