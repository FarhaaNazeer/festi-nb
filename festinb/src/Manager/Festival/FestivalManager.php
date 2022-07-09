<?php

namespace App\Manager\Festival;

use App\Entity\Festival;
use App\Interface\ManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FestivalManager
{
    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer
    ) {}

    public function get() : array
    {
        $response =  $this->client->request(
            'GET',
            'http://localhost/api/festivals',
        );

        $jsonResponse = $response->toArray();
        return json_decode($jsonResponse[0]);
    }


    public function post(Request $request)
    {
        // TODO: Implement post() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
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