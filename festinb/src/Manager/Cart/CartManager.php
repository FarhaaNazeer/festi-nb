<?php

namespace App\Manager\Cart;

use App\Entity\Cart;
use App\Entity\User;
use App\Services\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CartManager
{
    public const ENDPOINT = 'http://localhost/api/carts';

    public function __construct(
        private HttpClientInterface $client,
        protected StripeService $stripeService,
        private EntityManagerInterface $em
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

    public function assignCart(Cart $cart, User $user)
    {
        $cart->setUserCart($user);
    }

    public function validateCart(Cart $cart) {

        $cartItems = $cart->getCartItems();
        $cart->setQuantity(count($cartItems));

        $total = 0;

        foreach ($cartItems as $cartItem) {
            $subtotal = $cartItem->getItemPrice() * $cartItem->getQuantity();
            $total += $subtotal;
        }

        $cart->setAmount($total);
        $cart->setState($cart::STATE_VALIDATE);
    }

    /**
     * @param Cart $cart
     * @return string|null
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function intentSecret(Cart $cart): ?string
    {
        $intentPayment = $this->stripeService->paymentIntent($cart);

        return $intentPayment['client_secret'] ?? null;
    }

    /**
     * @param array $stripeParams
     * @param Cart $cart
     * @return array
     */
    public function stripe(array $stripeParams, Cart $cart): array
    {
        $resource = null;
        $data = $this->stripeService->stripeFeedback($stripeParams, $cart);

        if (null !== $data) {
            $resource = [
                'stripeBrand' => $data['charges']['data'][0]['payment_method_details']['card']['brand'],
                'stripeLast4' => $data['charges']['data'][0]['payment_method_details']['card']['last4'],
                'stripeId' => $data['charges']['data'][0]['id'],
                'stripeStatus' => $data['charges']['data'][0]['status'],
                'stripeToken' => $data['client_secret']
            ];
        }

        return $resource;
    }

    /**
     * @param array $resource
     * @param Cart $cart
     * @param User $user
     * @return void
     */
    public function createSubscription(array $resource, Cart $cart)
    {
        $cart->setBrandStripe($resource['stripeBrand']);
        $cart->setIdChargeStripe($resource['stripeId']);
        $cart->setLast4Stripe($resource['stripeLast4']);
        $cart->setPaymentMethod(Cart::PAYMENT_STRIPE);
        $cart->setStripeChargePrice($cart->getAmount());
        $cart->setStripeStatus($resource['stripeStatus']);
        $cart->setStripeToken($resource['stripeToken']);
        $cart->setUpdatedAt(new \DateTime());

        $this->em->flush($cart);
    }
}