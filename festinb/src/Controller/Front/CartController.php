<?php

namespace App\Controller\Front;

use App\Manager\Cart\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $session;
    public function __construct(
        public CartManager $cartManager
    ) {
        $this->session = new Session(new NativeSessionStorage(), new AttributeBag());
    }

    #[Route('/create-cart', name: 'create_cart', options: ['expose' => true])]
    public function createCart(Request $request): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, JSON_THROW_ON_ERROR);
        $response = $this->cartManager->post($data);

        if (Response::HTTP_CREATED !== $response[1]) {
            throw new \Exception('La création du panier n\'a pas pu être effectuée', $response[1]);
        }

        $cart = json_decode($response[0], true);
        $this->session->set('cartUuid', $cart['uuid']);

        return new JsonResponse(
            $cart,
            Response::HTTP_OK
        );
    }

    #[Route('/cart', name: 'get_cart', options: ['expose' => true])]
    public function getCart(Request $request): JsonResponse
    {
        $content = $request->getContent();

        $cartUuid = json_decode($content, true, JSON_THROW_ON_ERROR);
        $this->session->set('cartUuid', $cartUuid);
        if ($cartUuid === null) {
            $cart = [
                'items' => [],
            ];
        } else {
            $cart = json_decode($this->cartManager->getCart($cartUuid), true);
        }



        return new JsonResponse(
            [
                'html' => $this->render('front/macro/cart.html.twig', ['cart' => $cart])->getContent()
            ]
        );
    }

    #[Route('/cart-front', name: 'cart_front')]
    public function cartFront(Request $request): Response
    {
        $cart = json_decode($this->cartManager->getCart($request->getSession()->get('cartUuid')), true);

        return $this->render('front/cart/index.html.twig', ['cart' => $cart]);
    }
}
