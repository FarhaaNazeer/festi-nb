<?php

namespace App\Controller\Front;

use App\Manager\Cart\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function __construct(
        public CartManager $cartManager
    ) {}

    #[Route('/create-cart', name: 'app_front_create_cart', options: ['expose' => true])]
    public function createCart(Request $request): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, JSON_THROW_ON_ERROR);
        $response = $this->cartManager->post($data);

        if (Response::HTTP_CREATED !== $response[1]) {
            throw new \Exception('La création du panier n\'a pas pu être effectuée', $response[1]);
        }

        $cart = json_decode($response[0], true);

        return new JsonResponse(
            $cart['uuid'],
            Response::HTTP_OK
        );
    }
}