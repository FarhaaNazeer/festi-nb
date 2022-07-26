<?php

namespace App\Services;

use App\Entity\Cart;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeService
{
    protected $privateKey;
    protected $generator;

    public function __construct(
        UrlGeneratorInterface $generator
    ) {
        if ('dev' === $_ENV['APP_ENV']) {
            $this->privateKey = $_ENV['STRIPE_PRIVATE_KEY_TEST'];
        }

        $this->generator = $generator;

    }

    /**
     * @param Cart $cart
     * @return \Stripe\PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function paymentIntent(Cart $cart)
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 2,
                'exp_year' => 42,
                'cvc' => '424',
            ],
        ]);


        return \Stripe\PaymentIntent::create([
            'amount' => $cart->getAmount() * 100,
            'currency' => Cart::EUR_CURRENCY,
            'automatic_payment_methods' => ['enabled' => true],
            "payment_method"=> $paymentMethod,
            'confirm' => true,
            'return_url' => 'http://localhost:8000/'.$this->generator->generate('app_front_cart_subscription', [
                'uuid' => $cart->getUuid()
                ])
        ]);
    }

    public function payment(
        int $amount,
        string $currency,
        string $description,
        array $stripeParams
    )
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        $paymentIntent = null;

        if (isset($stripeParams['stripeIntentId'])) {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($stripeParams['stripeIntentId']);
        }

        if ('succeeded' === $stripeParams['stripeIntentStatus']) {
            // TODO
        } else {
            $paymentIntent->cancel();
        }

        return $paymentIntent;
    }

    /**
     * @param array $stripeParams
     * @param Cart $cart
     * @return \Stripe\PaymentIntent|null
     */
    public function stripeFeedback(array $stripeParams, Cart $cart)
    {
        return $this->payment(
            $cart->getAmount() * 100,
            Cart::EUR_CURRENCY,
            $cart->getReference(),
            $stripeParams
        );
    }
}