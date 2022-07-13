<?php

namespace App\Assembler\Cart;

use App\Assembler\AbstractAssembler;
use App\Assembler\Ticket\TicketAssembler;
use App\DoctrineManager\Cart\DoctrineCartManager;
use App\DoctrineManager\Ticket\DoctrineTicketManager;
use App\Dto\Cart\CartDto;
use App\Dto\Cart\CartItemDto;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Resolver\Cart\CartResolver;

class CartItemAssembler extends AbstractAssembler
{
    public function __construct(
        private TicketAssembler       $ticketAssembler,
        private DoctrineCartManager   $doctrineCartManager,
        private DoctrineTicketManager $doctrineTicketManager,
        private CartResolver          $cartResolver
    ) {}

    public function transform(CartItem $cartItem): CartItemDto
    {
        if (!$cartItem instanceof CartItem) {
            throw new \TypeError(sprintf("Argument 1 passed to %s() must be an instance of %s, %s given", __METHOD__, CartDto::class, get_debug_type($cartItem)));
        }

        $cartItemDto = new CartItemDto();
        $cartItemDto->uuid = $cartItem->getUuid();
        $cartItemDto->cart = $cartItem->getCart()->getUuid();
        $cartItemDto->tickets = $this->ticketAssembler->transform($cartItem->getTicket());
        $cartItemDto->quantity = $cartItem->getQuantity();
        $cartItemDto->itemPrice = $cartItem->getItemPrice();
        $cartItemDto->created_at = $cartItem->getCreatedAt();
        $cartItemDto->updated_at = $cartItem->getUpdatedAt();

        return $cartItemDto;
    }

    public function reverseTransform(CartItemDto $cartItemDto, CartItem $cartItem = null): CartItem
    {
        if (!$cartItemDto instanceof CartItemDto) {
            throw new \TypeError(sprintf("Argument 1 passed to %s() must be an instance of %s, %s given", __METHOD__, CartItemDto::class, get_debug_type($cartItemDto)));
        }

        if (!$cartItem = $this->cartResolver->itemExistsInCart($cartItemDto)) {

            $cartItem ??= new CartItem();
            $cartItem->setCart($this->doctrineCartManager->getCart($cartItemDto->cart->uuid));
            $cartItem->setTicket($this->doctrineTicketManager->getTicket($cartItemDto->tickets->uuid));
            $cartItem->setQuantity($cartItemDto->quantity);
            $cartItem->setItemPrice($cartItem->getTicket()->getPrice() * $cartItem->getQuantity());

            $this->assignCartItemToCart($cartItem, $cartItem->getCart());
        }

        return $cartItem;
    }

    public function assignCartItemToCart(CartItem $cartItem, Cart $cart)
    {
        $cart->addCartItem($cartItem);
    }
}
