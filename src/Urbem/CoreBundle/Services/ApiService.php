<?php

namespace Urbem\CoreBundle\Services;

use GuzzleHttp;
use Symfony\Component\HttpFoundation;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class ApiService
{
    private $client;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['default' => true]);
    }

    /**
     * @param $url
     * @param null $parameters
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($url, $headerApi = null)
    {
        $headers = [];
        if (!empty($headerApi)) {
            $headers = ['headers' => $headerApi];
        }

        return $this->send($url, $headers, 'get');
    }

    /**
     * @param $url
     * @param null $parameters
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($url, $headerApi = null, $parameters = null)
    {
        $options = [];
        if (!empty($headerApi)) {
            $options = array_merge([
                'headers' => $headerApi
            ], $options);

        }
        if (!empty($parameters) && is_array($parameters)) {
            $options = array_merge([
                'form_params' => $parameters
            ], $options);
        }

        return $this->send($url, $options, 'post');
    }

    /**
     * @param $url
     * @param $headers
     * @param $method
     * @param $parameters
     * @return array
     */
    protected function send($url, $options, $method)
    {
        try {
            $res = $this->client->{$method}($url, $options);
            $code = $res->getStatusCode();
            $content = $res->getBody()->getContents();
        } catch (RequestException $e) {
            $code = 500;

            $content = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $content = Psr7\str($e->getResponse());
            }
        }

        return [
            'statusCode' => $code,
            'content' => $content
        ];
    }
}
