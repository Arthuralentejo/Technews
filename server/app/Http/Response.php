<?php

namespace App\Http;
/**
 * Class Response
 *
 * @package App\Http
 */
class Response
{
    /**
     * @var int
     */
    private int $httpCode = 200;
    /**
     * @var array
     */
    private array $headers = [];
    /**
     * @var
     */
    private $body;
    /**
     * @var string
     */
    private string $contentType;
    /**
     * @var
     */
    private $content;

    /**
     * @param $httpCode
     * @param $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->contentType = $contentType;
    }

    /**
     * @param string contentType
     * @return void
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @return void
     */
    private function addCorsPolicy()
    {
        $this->addHeader('Access-Control-Allow-Origin', '*');
        $this->addHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->addHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }

    /**
     * @return void
     */
    private function sendHeaders()
    {
        $this->addCorsPolicy();
        http_response_code($this->httpCode);
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * @return void
     */
    public function sendResponse()
    {

        $this->sendHeaders();
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            default:
                break;
        }
    }
}