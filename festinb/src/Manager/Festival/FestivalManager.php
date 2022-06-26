<?php

namespace App\Manager\Festival;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FestivalManager
{
    public function __construct(private HttpClientInterface $client)
    {}

    public function findAll() : array
    {
        $response =  $this->client->request(
            'GET',
            'http://localhost/api/festivals',
        );

        $jsonReponse = $response->toArray();
        return json_decode($jsonReponse[0]);
    }
}