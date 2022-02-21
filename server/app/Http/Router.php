<?php

namespace App\Http;

use Closure;
use Exception;
use ReflectionFunction;

/**
 * Class Router
 *
 * @package App\Http
 */
class Router
{

    /**
     * @var string
     */
    private string $url = '';

    /**
     * @var string
     */
    private string $prefix = '';

    /**
     * @var array
     */
    private array $routes = [];

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param String $url
     * @param string $prefix
     */
    public function __construct(string $url, string $prefix = '')
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * @return void
     */
    private function setPrefix(): void
    {
        $parseURL = parse_url($this->url);

        $this->prefix = $parseURL['path'] ?? '';
    }

    /**
     * @param string $method
     * @param String $route
     * @param array $params
     * @return void
     */
    private function addRoute(string $method, string $route, array $params = []): void
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }
        // $params['vars'] = [];
        $query = explode(':', $route)[1] ?? '';
        // if (!empty($query)) {
        //   $params['vars'][$query] = null;
        // }
        if (!empty($query)) {
            $patternVar = '\?[' . $query . ']+=[0-9]+';
            $route = preg_replace('(:' . $query . ')', $patternVar, $route);
        }
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * @param String $route
     * @param array $params
     * @return void
     */
    public function get(string $route, array $params = [])
    {
        $this->addRoute('GET', $route, $params);
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post(string $route, array $params = [])
    {
        $this->addRoute('POST', $route, $params);
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put(string $route, array $params = [])
    {
        $this->addRoute('PUT', $route, $params);
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete(string $route, array $params = [])
    {
        $this->addRoute('DELETE', $route, $params);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getRoute()
    {
        $uri = $this->request->getUri();
        $uri = str_replace($this->prefix, '', $uri);
        $httpMethod = $this->request->getHttpMethod();
        foreach ($this->routes as $route => $methods) {
            if (preg_match($route, $uri)) {
                if (isset($methods[$httpMethod])) {
                    $methods[$httpMethod]['vars'] = $this->request->getQueryParams();
                    $methods[$httpMethod]['vars']['request'] = $this->request;
                    return $methods[$httpMethod];
                }
                throw new Exception('Method not allowed', 405);
            }
        }
        throw new Exception('Not found', 404);
    }

    /**
     * @return Response|false|mixed
     */
    public function run()
    {
        try {
            $route = $this->getRoute();
            if (!isset($route['controller'])) {
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

    /**
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->url . explode('?', $this->request->getUri())[0];
    }
}
