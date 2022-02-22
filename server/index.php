<?php

require __DIR__.'/bootstrap/app.php';

use App\Http\Router;


$router = Router::getInstance(URL);

require __DIR__.'/app/Http/routes/pages.php';

$router->run()->sendResponse();