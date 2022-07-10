<?php

namespace App\Controller\Api;

use App\Assembler\Cart\CartAssembler;
use App\Dto\Cart\CartDto;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CartController extends AbstractController
{
    public function __construct(
        private CartRepository $repository,
        private SerializerInterface $serializer,
        private CartAssembler $cartAssembler,
        private EntityManagerInterface $entityManager,
    )
    {}

    #[Route('/api/carts', name: 'carts', methods: ['GET'])]
    public function getCarts(): JsonResponse
    {
        $carts = $this->serializer->serialize(
            $this->repository->findAll(),
            JsonEncoder::FORMAT
        );

        return new JsonResponse([
            $carts,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;charset=UTF-8'],
            true
        ]);
    }

    #[Route('/api/carts', name: 'createCart', methods: ['POST'])]
    public function createTicket(CartDto $cartDto): JsonResponse
    {
        try {
            $cart = $this->cartAssembler->reverseTransform($cartDto);

            $this->entityManager->persist($cart);
            $this->entityManager->flush();

            return new JsonResponse([
                $this->serializer->serialize(
                    $this->cartAssembler->transform($cart),
                    'json'
                ),
                Response::HTTP_CREATED,
                ['Content-Type' => 'application/json'],
                true
            ]);
        } catch (\Exception $e) {
           return $this->json($e->getMessage(), $e->getCode());
        }
    }
}