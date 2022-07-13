<?php

namespace App\Dto\User;

use App\Dto\Address\AddressDto;

class UserDto
{
    /**
     * @var string|null
     */
    public ?string $firstname = null;

    /**
     * @var string|null
     */
    public ?string $lastname = null;

    /**
     * @var string|null
     */
    public ?string $email = null;

    /**
     * @var array|null
     */
    public ?array $roles = null;

    /**
     * @var AddressDto|null
     */
    public $addresses = null;
}