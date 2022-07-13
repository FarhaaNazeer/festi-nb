<?php

namespace App\Dto\Address;

class AddressDto
{
    /**
     * @var string|null
     */
    public ?string $street = null;

    /**
     * @var string|null
     */
    public ?string $zipcode = null;

    /**
     * @var string|null
     */
    public ?string $city = null;

    /**
     * @var string|null
     */
    public ?string $country = null;

    /**
     * @var string|null
     */
    public ?string $is_default = null;

    /**
     * @var string|null
     */
    public ?string $is_enable = null;
}