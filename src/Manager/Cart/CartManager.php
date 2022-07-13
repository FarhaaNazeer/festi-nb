<?php

namespace App\Manager\Cart;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CartManager
{
    public const ENDPOINT = 'http://localhost/api/carts';

    public function __construct(
        private HttpClientInterface $client,
    ) {}

    public function getCart(string $uuid)
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/api/cart/'.$uuid,
            [
                'headers' => [
                    'Accept' =>'application/json'
                ]
            ]
        );

        return current($response->toArray(true));
    }


    public function post(array $data)
    {
        $response = $this->client->request(
            'POST',
            self::ENDPOINT,
            [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json',
//                    'Content-Type' => 'application/json',
                ]
            ]
        );

        return $response->toArray();
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}