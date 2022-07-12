<?php

namespace App\Controller\Front;

use App\DoctrineManager\Cart\DoctrineCartManager;
use App\Manager\Cart\CartItemManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartItemController extends AbstractController
{
    public function __construct(
        private CartItemManager $cartItemManager,
    ){}

    #[Route('/add-item', name: 'add_item', options: ['expose' => true])]
    public function addItem(Request $request): Response
    {
        $content = $request->getContent();
        $data = json_decode($content, true, JSON_THROW_ON_ERROR);

        $response = $this->cartItemManager->post($data);

        if (Response::HTTP_CREATED !== $response[1]) {
            throw new \Exception('L\'ajout du billet au panier n\'a pas pu s\'effectuer', $response[1]);
        }

        $cartItem = json_decode($response[0], true);


        return new JsonResponse(
            $cartItem
        );
    }
}