<?php defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class Http_service{
    
    protected $CI;

    protected $params;
    
    protected $http;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->params = $params;
    }

    public function client($base_url = NULL)
    {
        $this->http = new GuzzleHttp\Client(array(
            'base_uri' => $base_url,
            'headers' => array(
                'content-type' => 'application/json'
            ),
        ));

        return $this;
    }

    public function request($method, $path, $options = array())
    {
        $response = $this->http->request($method, urlencode($path), array_merge(array(
            'query' => array(),
            'json' => array(),   
            'form_params' => array(),
        ), $options));

        return ($response->getStatusCode()) ? json_encode((string) $response->getBody()) : $response->getReasonPhrase();
    }

    public function get($path, $options = array())
    {
        return $this->request('GET', $path, $options = array());
    }

    public function post($path, $options = array())
    {
        return $this->request('POST', $path, $options = array());
    }

    /**
     * Asyn
     */
    
    public function a_request($method, $path)
    {
        $promise = $client->requestAsync($method, urlencode($path), [
            'query' => $query, //['foo' => 'bar'],
            'body' => $file, //fopen('/path/to/file', 'r') //\GuzzleHttp\Psr7\stream_for('hello!'),
            'json' => $json, //['foo' => 'bar'],    
            'form_params' => $form_params, 
            // [ //application/x-www-form-urlencoded
            //     'field_name' => 'abc',
            //     'other_field' => '123',
            //     'nested_field' => [
            //         'nested' => 'hello'
            //     ]
            // ]
        ]);

        $promise->then(function (ResponseInterface $res) {
            $code = $res->getStatusCode(); // 200
            $reason = $res->getReasonPhrase(); // OK
            $res->getHeaders();
            $res->getBody();
        },function (RequestException $e) {
            $e->getMessage();
            $e->getRequest()->getMethod();
        });
    }
}