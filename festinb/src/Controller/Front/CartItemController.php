<?php

namespace App\Controller\Front;

use App\DoctrineManager\Cart\DoctrineCartManager;
use App\Entity\CartItem;
use App\Manager\Cart\CartItemManager;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/update-item-qty', name: 'update_item_qty', options: ['expose' => true])]
    public function updateQtyItem(Request $request, EntityManagerInterface $em): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, JSON_THROW_ON_ERROR);

        $data['ticket']['qty'];

        $cartItem = $em->getRepository(CartItem::class)->findBy(['uuid' => $data['ticket']['uuid']])[0];

        $cartItem->setQuantity($data['ticket']['qty']);

        $em->persist($cartItem);
        $em->flush();

        return new JsonResponse(
            '',
            Response::HTTP_OK
        );
    }


    #[Route('/cart/items/validate', name: 'cart_items_validate', options: ['expose' => true])]
    public function cartItemsValidate(Request $request)
    {
        $content = $request->getContent();
        $data = json_decode($content, true, JSON_THROW_ON_ERROR);

        $response = $this->cartItemManager->post($data);

        if (Response::HTTP_CREATED !== $response[1]) {
            throw new \Exception('La commande n\'a pas pu être validée', $response[1]);
        }

        $cart = json_decode($response[0], true);

        return new JsonResponse(
            $cart,
            Response::HTTP_OK
        );
    }
}