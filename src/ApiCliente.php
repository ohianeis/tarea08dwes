<?php

namespace Oianeis\ApiNba;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiCliente
{
    protected $cliente;
    protected $url;
    protected $key = 'af54b801-6983-4fb9-a59e-500041ea6191';
    public function __construct()
    {

        $this->url = "https://api.balldontlie.io/v1/";
        $this->cliente = new Client([
            'base_uri' => $this->url,
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "{$this->key}",

            ],
            'verify' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'certs' . DIRECTORY_SEPARATOR . 'cacert.pem'
        ]);
    
    }

    public function getDatos($endpoint, $query = [])
    {
        try {
            //resuelve id de teams vacio array si no es id xk si no me da error
            if (is_numeric($query)) {
                $url = "{$endpoint}/{$query}";
                $query = []; 
            } else {
                $url = $endpoint;
            }
    
            $datos = $this->cliente->get($url, [
                'query' => is_array($query) ? $query : []
            ]);
            return json_decode($datos->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}
