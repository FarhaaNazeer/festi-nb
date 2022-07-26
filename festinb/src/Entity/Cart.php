<?php

namespace App\Entity;

use App\Repository\CartRepository;
use App\Traits\EntityIdTrait;
use App\Traits\StripeTrait;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    public const STATE_NEW = 'new';
    public const STATE_PENDING = 'pending';
    public const STATE_VALIDATE = 'validate';

    public const EUR_CURRENCY = 'eur';

    public const PAYMENT_STRIPE = 'stripe';


    use EntityIdTrait;
    use TimestampTrait;
    use StripeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $reference;

    #[ORM\Column(type: 'string', length: 255)]
    private $state;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'cart')]
    private $userCart;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private $amount;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $payment_method;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItem::class)]
    private $cartItems;



    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getUserCart(): ?User
    {
        return $this->userCart;
    }

    public function setUserCart(?User $userCart): self
    {
        $this->userCart = $userCart;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(?string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems[] = $cartItem;
            $cartItem->setCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }

        return $this;
    }
}
