<?php

namespace App\Dto\Cart;

use App\Dto\Ticket\TicketDto;

class CartItemDto
{
    /**
     * @var string|null
     */
    public ?string $uuid = null;

    /**
     * @var CartDto|null
     */
    public $cart = null;


    /**
     * @var TicketDto|null
     */
    public $tickets = null;

    /**
     * @var float|null
     */
    public ?float $itemPrice = null;

    /**
     * @var int|null
     */
    public ?int $quantity = null;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $created_at = null;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $updated_at = null;
}