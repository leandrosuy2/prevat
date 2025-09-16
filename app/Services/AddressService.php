<?php

namespace App\Services;

use App\Models\Uf;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Exception;

class AddressService
{
    public function consultCEP($postalCode = null)
    {
        $countZip = strlen($postalCode);

        if($countZip === 9) {
            $client = new Client();
            $request = new Request('GET', 'https://viacep.com.br/ws/'.$postalCode.'/json/'); // create request

            $response = $client->send($request);

            $return = [];

            $result = json_decode($response->getBody()->getContents());

            if(isset($result->erro)){
                return [
                    'code' => 400,
                    'title' => 'Cep Não Encontrado',
                    'message' => 'Por favor verifique se o cep foi digitado corretamente!'
                ];

            } else {
                $return['logradouro'] = $result->logradouro ?? '';
                $return['bairro'] = $result->bairro ?? '';
                $return['localidade'] = $result->localidade ?? '';
                $return['uf'] = $result->uf ?? '';

                return [
                    'code' => 200,
                    'data' => $return
                ];
            }

        } else {
            return [
                'code' => 400,
                'title' => 'Cep Não Encontrado',
                'message' => 'Por favor verifique se o cep foi digitado corretamente!'
            ];
        }


    }

    public function apiBrasilCep(String $zipcode = null)
    {
        $client = new Client();

        $headers = [
            'Content-Type'=>'application/json',
            "Accept" => "application/json",
            'Authorization'=>'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3BsYXRhZm9ybWEuYXBpYnJhc2lsLmNvbS5ici9hdXRoL2xvZ2luIiwiaWF0IjoxNjg0MTgzOTcyLCJleHAiOjE3MTU3MTk5NzIsIm5iZiI6MTY4NDE4Mzk3MiwianRpIjoiQk9XdzVQVXFTaGhrY1p5dCIsInN1YiI6IjI4NzkiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.UJYkQ3-xQWa7pmX6ztRa3sh6P6UUNuA0YR1Wit19Zn8',
            'SecretKey'=>'23f1c789-62ab-4650-af53-0612cc667088',
            'PublicToken'=>'8IAZn7HKq7QJWbh37N3GOOeRVY',
            'DeviceToken'=>'3b7c0e1b-91f5-41ae-af13-149e01c28bd2',
        ];

        $body = [
            'query' => $zipcode
        ];

        $request = new Request('PUT', 'https://cluster.apigratis.com/api/v1/correios/address', $headers, json_encode($body)); // create request

        $response = $client->send($request); // send request

        dd(json_decode($response->getBody()->getContents()));

    }

    public function getEstados()
    {

    }
}
