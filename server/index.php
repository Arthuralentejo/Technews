<?php

require __DIR__.'/bootstrap/app.php';
require __DIR__.'app/Http/routes/pages.php';

use App\Http\Router;

$router = new Router(URL);



$router->run()->sendResponse();