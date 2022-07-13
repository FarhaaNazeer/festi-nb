<?php

namespace App\Manager\Cart;

use App\Manager\BaseManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CartItemManager
{
    public const ENDPOINT = 'http://localhost/api/cartItems';

    public function __construct(
        private HttpClientInterface $client,
    ) {}

    public function post(array $data)
    {
        $response = $this->client->request(
            'POST',
            self::ENDPOINT,
            [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]
        );

        return $response->toArray();
    }
}