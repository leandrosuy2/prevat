<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

class WsReceitaService
{
    public function consultCNPJ($cnpj = null)
    {
        $cnpj = str_replace(['.', '-', '/'],'', $cnpj);

        try {
            $client = new Client();

            $request = new Request('GET', 'https://receitaws.com.br/v1/cnpj/'.$cnpj);
            $response = $client->sendAsync($request)->wait();

            $result =  json_decode($response->getBody()->getContents(), true); // return response object

            if(isset($result->erro)){
                return [
                    'code' => 400,
                    'title' => 'Cep Não Encontrado',
                    'message' => 'Por favor verifique se o cep foi digitado corretamente!'
                ];

            }

            dd($response);


        } catch (ClientException $e) {
            // return exception error
            $response = $e->getResponse();
//            dd($response);
            $teste =  json_decode((string)($response->getBody()->getContents()));
            dd($teste);
        }

    }

}
