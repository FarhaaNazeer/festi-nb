<?php

namespace App\Dto\Cart;

use App\Dto\Ticket\TicketDto;
use App\Dto\User\UserDto;

class CartDto
{
    public const STATE_NEW = 'new';
    public const STATE_IN_PROCESS = 'in_process';

    /**
     * @var string|null
     */
    public ?string $uuid = null;

    /**
     * @var string|null
     */
    public ?string $reference = null;

    /**
     * @var string|null
     */
    public ?string $state = null;

    /**
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * @var int|null
     */
    public ?int $quantity = null;

    /**
     * @var string|null
     */
    public ?string $payment_method = null;


    /**
     * @var CartItemDto|null
     */
    public $items = null;

    /**
     * @var UserDto|null
     */
    public $user = null;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $created_at = null;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $updated_at = null;
}