<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
class Router{

  private $url = '';

  private $prefix = '';

  private $routes = [];

  private $request;

  public function __construct($url, $prefix = '')  {
    $this->request = new Request($this);
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

    $params['vars'] = [];

    $patternVar = '/{(.*?)}/';

    if(preg_match_all($patternVar, $route, $matches)){
      $route = preg_replace($patternVar,'\(.*?\)',$route);
      $params['vars'] = $matches[1];
    }
    $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
    $this->routes[$patternRoute][$method] = $params;
  }

  public function get($route, $params = [])  {

    return $this->addRoute('GET', $route, $params);
  }
  public function post($route, $params = [])  {
    return $this->addRoute('POST', $route, $params);
  }
  public function put($route, $params = [])  {
    return $this->addRoute('PUT', $route, $params);
  }
  public function delete($route, $params = [])  {
    return $this->addRoute('DELETE', $route, $params);
  }

  private function getRoute(){
    $uri = $this->request->getUri();
    $uri = str_replace($this->prefix, '', $uri);
    $httpMethod = $this->request->getHttpMethod();
    foreach ($this->routes as $route => $methods) {
      if(preg_match($route, $uri,$matches)){

        if(isset($methods[$httpMethod])){
          unset($matches[0]);
          $keys =  $methods[$httpMethod]['vars'];
          $methods[$httpMethod]['vars'] = array_combine($keys, $this->request->getQueryParams());
          $methods[$httpMethod]['vars']['request'] = $this->request;
          return $methods[$httpMethod];
        }
        throw new Exception('Method not allowed', 405);
      }
    }
    throw new Exception('Not found', 404);
  }

  public function run()  {
    try {
      $route = $this->getRoute();
      if(!isset($route['controller'])){
        throw new Exception('Error Processing Request', 500);
      }
      $args = [];

      $reflection = new ReflectionFunction($route['controller']);
      foreach ($reflection->getParameters() as $parameter) {
        $name = $parameter->getName();
        $args[$name] = $route['vars'][$name] ?? '';
      }
      return call_user_func_array($route['controller'], $args);
    } catch (Exception $e) {
      return new Response($e->getCode(), $e->getMessage());
    }

  }

  public function getCurrentUrl()  {
    return $this->url.$this->request->getUri();
  }
}
