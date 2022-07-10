<?php

namespace App\Assembler\Cart;

use App\Assembler\AbstractAssembler;
use App\Assembler\Ticket\TicketAssembler;
use App\Dto\Cart\CartDto;
use App\Entity\Cart;
use App\Repository\TicketRepository;

class CartAssembler extends AbstractAssembler
{

    public function __construct(
    ) {}

    public function transform(Cart $cart): CartDto
    {
        if (!$cart instanceof Cart) {
            throw new \TypeError(sprintf("Argument 1 passed to %s() must be an instance of %s, %s given", __METHOD__,  CartDto::class, get_debug_type($cart)));
        }

        $cartDto                    = new CartDto();
        $cartDto->uuid              = $cart->getUuid();
        $cartDto->reference         = $cart->getReference();
        $cartDto->state             = $cart->getState();
        $cartDto->amount            = $cart->getAmount();
        $cartDto->payment_method    = $cart->getPaymentMethod();
        $cartDto->created_at        = $cart->getCreatedAt();
        $cartDto->updated_at        = $cart->getUpdatedAt();

        return $cartDto;
    }

    public function reverseTransform(CartDto $cartDto, Cart $cart = null): Cart
    {
        if (!$cartDto instanceof CartDto) {
            throw new \TypeError(sprintf("Argument 1 passed to %s() must be an instance of %s, %s given", __METHOD__, CartDto::class, get_debug_type($cartDto)));
        }

        $cart ??= new Cart();
        $cart->setReference(uniqid());
        $cart->setState($cartDto->state ?? $cartDto::STATE_NEW);
        $cart->setAmount($cartDto->amount ?? 0);
        $cart->setQuantity($cartDto->quantity ?? 0);

        return $cart;
    }
}