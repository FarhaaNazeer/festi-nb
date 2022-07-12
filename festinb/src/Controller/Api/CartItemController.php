<?php

namespace App\Controller\Api;

use App\Assembler\Cart\CartItemAssembler;
use App\Dto\Cart\CartItemDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CartItemController extends AbstractController
{
    public function __construct(
        private CartItemAssembler $cartItemAssembler,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ) {}


    #[Route('/cartItems', name: 'createCartItems', methods: ['POST'])]
    public function createCartItems(CartItemDto $cartItemDto): JsonResponse
    {
        $cartItem = $this->cartItemAssembler->reverseTransform($cartItemDto);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return new JsonResponse([
            $this->serializer->serialize($this->cartItemAssembler->transform($cartItem),
                'json'
            ),
            Response::HTTP_CREATED,
            ['Content-Type' => 'application/json'],
            true
        ]);
    }

}