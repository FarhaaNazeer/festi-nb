<?php

namespace App\Manager\Cart;

use App\Entity\CartItem;
use App\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CartItemManager
{
    public const ENDPOINT = 'http://localhost/api/cartItems';

    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $em
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

    public function delete(string $uuid)
    {
        $cart = $this->em->getRepository(CartItem::class)->findBy(['uuid' => $uuid])[0];

        $this->em->getRepository(CartItem::class)->remove($cart);

        return new Response(
            'ok',
            Response::HTTP_OK
        );
    }
}
