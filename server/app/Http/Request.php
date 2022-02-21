<?php

namespace App\Http;

/**
 * Class Request
 *
 * @package App\Http
 */
class Request
{
    /**
     * @var Router
     */
    private Router $router;
    /**
     * @var string
     */
    private string $httpMethod;
    /**
     * @var string
     */
    private string $uri;
    /**
     * @var array
     */
    private array $queryParams = [];
    /**
     * @var array
     */
    private array $postVars = [];
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? [];
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getUri() : string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }
}