<?php

namespace App\Resolver\Cart;

use App\Assembler\Ticket\TicketAssembler;
use App\DoctrineManager\Cart\DoctrineCartManager;
use App\Dto\Cart\CartItemDto;
use App\Entity\CartItem;

class CartResolver
{
    public function __construct(
     private DoctrineCartManager $doctrineCartManager,
     private TicketAssembler $ticketAssembler
    ){}

    public function itemExistsInCart(CartItemDto $cartItemDto): ?CartItem
    {
        $cart = $this->doctrineCartManager->getCart($cartItemDto->cart->uuid);
        $cartItems = $cart->getCartItems();

        foreach ($cartItems->toArray() as $itemInCart) {
            $ticket = $this->ticketAssembler->transform($itemInCart->getTicket());

            if ($ticket->uuid === $cartItemDto->tickets->uuid){
                $this->updateItemQuantity($cartItemDto->quantity, $itemInCart);
                return $itemInCart;
            }
        }
        return null;

    }

    public function updateItemQuantity(int $addingQuantity, CartItem $cartItem) : CartItem
    {
        $oldQuantity = $cartItem->getQuantity();
        $newQuantity = $oldQuantity + $addingQuantity;

        $cartItem->setQuantity($newQuantity);

        return $cartItem;
    }
}