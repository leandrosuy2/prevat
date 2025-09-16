<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class CNPJService
{
    public function consultCNPJ($cnpj = null)
    {
        $cnpj = str_replace(['.', '-', '/'],'', $cnpj);

        try {
            $client = new Client();

            $request = new Request('GET', 'https://api-publica.speedio.com.br/buscarcnpj?cnpj='.$cnpj);
            $response = $client->sendAsync($request)->wait();

            return json_decode($response->getBody()->getContents(), true); // return response object

        } catch (RequestException $e) {
            return [
                'status' => 'error',
                'code' => 503,
                'title' => 'Serviço Indisponível',
                'message' => 'Serviço temporáriamente indisponivel'
            ];
        }

    }

}
