<?php

namespace App\Manager\Cart;

use App\Entity\CartItem;
use App\Entity\User;
use App\Manager\BaseManager;
use App\Services\StripeServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CartItemManager
{
    public const ENDPOINT = 'http://localhost/api/cartItems';

    public function __construct(
        private HttpClientInterface $client,
        protected StripeServices $stripeService,
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

    public function intentSecret(CartItem $cartItem)
    {
        $intent = $this->stripeService->paymentIntent($cartItem);

        return $intent['client_secret'] ?? null;
    }

    public function stripe(array $stripeParameter, CartItem $cartItem)
    {
        $ressource = null;

        $data = $this->stripeService->stripe($stripeParameter, $cartItem);

        if($data) {
            $ressource = [
                'stripeBrand' => $data['charges']['data'][0]['payment_method_details']['card']['brand'],
                'stripeLast4' => $data['charges']['data'][0]['payment_method_details']['card']['last4'],
                'stripeId' => $data['charges']['data'][0]['id'],
                'stripeStatus' => $data['charges']['data'][0]['status'],
                'stripeToken' => $data['client_secret'],
            ];
        }

        return $ressource;
    }

    public function createSubscription(array $ressource, CartItem $cartItem, User $user)
    {
        $cart = $cartItem->getCart();
        $cart->setUserCart($user);
        $cart->setReference(uniqid('',false));

        $amount =0;
        foreach($cart->getCartItems() as $cartItem) {
            $cartItem->setCart($cart);
        }

        $cart->setBrandStripe($ressource['stripeBrand']);
        $cart->setLast4Stripe($ressource['stripeLast4']);
        $cart->setIdChargeStripe($ressource['stripeId']);
        $cart->setStatusStripe($ressource['stripeStatus']);
        $cart->setStripeToken($ressource['stripeToken']);
        $cart->setUpdatedAt(new \DateTime());

        $this->em->persist($cart);
        $this->em->flush();
    }
        
}  