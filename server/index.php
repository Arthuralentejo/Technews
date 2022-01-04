<?php 
require __DIR__.'/bootstrap/app.php';

use App\http\Router;

$router = new Router(URL);

include __DIR__.'/routes/pages.php';

$router->run()->sendResponse();