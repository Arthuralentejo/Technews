<?php

namespace App\Http;

use \Closure;

class Router{

  private $url = '';

  private $prefix = '';

  private $routes = [];

  private $request;

  public function __construct($url, $prefix = '')  {
    $this->request = new Request();
    $this->url = $url;
    $this->setPrefix();
  }

  private function setPrefix() {
    $parseURL = parse_url($this->url);

    $this->prefix = $parseURL['path'] ?? '';
  }

  private function addRoute($method, $route,$params = []) {
    foreach ($params as $key => $value) {
      if($value instanceof Closure){
         $params['controller'] = $value;
         unset($params[$key]);
         continue;
      }
    }
    
  }

  public function get($route, $params = [])  {
    return $this->addRoute('GET', $route, $params);

  }

  // public function post($route, $controller)  {
  //   $this->routes['POST'][$this->prefix . $route] = $controller;
  // }

  // public function run()  {
  //   $method = $_SERVER['REQUEST_METHOD'];
  //   $uri = $this->url;

  //   if (array_key_exists($uri, $this->routes[$method])) {
  //     $controller = $this->routes[$method][$uri];
  //     $controller = new $controller;
  //     $controller->index();
  //   } else {
  //     echo '404';
  //   }
  // }
}
