<?php

namespace App\Manager\Festival;

use App\Entity\Festival;
use App\Interface\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function PHPUnit\Framework\throwException;

class FestivalManager
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    public const ENDPOINT = 'http://localhost/api/festivals';

    public function getFestivals()
    {
        $response = $this->client->request(
            'GET',
            self::ENDPOINT
        );

        try {
            $jsonResponse = $response->toArray(true);
            return json_decode($jsonResponse[0]);
        }  catch (\Exception $e) {
            throwException($e);
            return [];
        }
    }

    public function getFilteredFestival(array $filters = []): array
    {
        $url = self::ENDPOINT.'/filtered';

        if (count($filters) > 0) {
            $url .= '?' . http_build_query($filters);
        }
        $response =  $this->client->request(
            'GET',
            $url
        );

        try {
            $jsonResponse = $response->toArray();
            return json_decode($jsonResponse[0]);
        } catch (\Exception $e) {
            throwException($e);
            return [];
        }
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

    public function findOneBySlug(string $slug)
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/api/festivals/' . $slug

        );
        $jsonResponse = $response->toArray(false);

        return json_decode($jsonResponse[0]);
    }
}
