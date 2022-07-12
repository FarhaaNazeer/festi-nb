<?php

namespace App\DoctrineManager\Cart;

use App\Entity\Cart;
use App\Repository\CartRepository;

class DoctrineCartManager
{

    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function getCart(string $uuid): Cart
    {
        return current($this->cartRepository->findBy(['uuid' => $uuid]));
    }

}