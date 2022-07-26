<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait StripeTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stripe_token;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $brand_stripe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $last4_stripe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $id_charge_stripe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stripe_status;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stripe_charge_price;

    public function getStripeToken(): ?string
    {
        return $this->stripe_token;
    }

    public function setStripeToken(?string $stripe_token): self
    {
        $this->stripe_token = $stripe_token;

        return $this;
    }

    public function getBrandStripe(): ?string
    {
        return $this->brand_stripe;
    }

    public function setBrandStripe(?string $brand_stripe): self
    {
        $this->brand_stripe = $brand_stripe;

        return $this;
    }

    public function getLast4Stripe(): ?string
    {
        return $this->last4_stripe;
    }

    public function setLast4Stripe(?string $last4_stripe): self
    {
        $this->last4_stripe = $last4_stripe;

        return $this;
    }

    public function getIdChargeStripe(): ?string
    {
        return $this->id_charge_stripe;
    }

    public function setIdChargeStripe(?string $id_charge_stripe): self
    {
        $this->id_charge_stripe = $id_charge_stripe;

        return $this;
    }

    public function getStripeStatus(): ?string
    {
        return $this->stripe_status;
    }

    public function setStripeStatus(?string $stripe_status): self
    {
        $this->stripe_status = $stripe_status;

        return $this;
    }

    public function getStripeChargePrice(): ?string
    {
        return $this->stripe_charge_price;
    }

    public function setStripeChargePrice(?string $stripe_charge_price): self
    {
        $this->stripe_charge_price = $stripe_charge_price;

        return $this;
    }
}