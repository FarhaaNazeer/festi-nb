<?php

namespace App\Manager\Festival;

use App\Entity\Festival;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FestivalManager
{
    public function __construct(private HttpClientInterface $client, private SerializerInterface $serializer)
    {}

    public function findAll() : array
    {
        $response =  $this->client->request(
            'GET',
            'http://localhost/api/festivals',
        );

        $jsonResponse = $response->toArray();
        return json_decode($jsonResponse[0]);
    }

    public function findOneBySlug(string $slug) : Festival
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/api/festivals/' . $slug

        );

        $jsonResponse = $response->toArray();
        $festival = $this->serializer->deserialize($jsonResponse[0], Festival::class, 'json');

        return $festival;
    }
}