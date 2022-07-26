<?php

namespace App\Controller\Front;

use App\Entity\Address;
use App\Entity\Cart;
use App\Form\CartAddressType;
use App\Manager\Cart\CartItemManager;
use App\Manager\Cart\CartManager;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $session;
    public function __construct(
        public CartManager $cartManager,
        public CartItemManager $cartItemManager,
        public CartRepository $cartRepository
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

    #[Route('/cart-macro', name: 'get_cart', options: ['expose' => true])]
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

    #[Route('/cart', name: 'cart_front')]
    public function cartFront(Request $request): Response
    {
        $session = new Session();

        if ($cart = $session->get('cartUuid')) {
            $cart = json_decode($this->cartManager->getCart($request->getSession()->get('cartUuid')), true);
        }

        return $this->render('front/cart/index.html.twig', ['cart' => $cart]);
    }

    #[Route('/cart/redirect', name: 'cart_redirect')]
    public function cartRedirect(): Response
    {
        return $this->redirectToRoute('app_front_login');
    }

    #[Route('/cart/{uuid}/validate', name: 'cart_validate')]
    public function cartValidate(string $uuid, EntityManagerInterface $em)
    {
        $cart = $this->cartRepository->findOneByUuid($uuid);

        if(!$cart) {
            throw new \Exception('Cart not found');
        }

        $this->cartManager->assignCart($cart, $this->getUser());
        $this->cartManager->validateCart($cart);

        $em->flush();

        return $this->redirectToRoute('app_front_cart_address', ['uuid' => $uuid]);
    }

    #[Route('/cart/{uuid}/address', name: 'cart_address')]
    public function cartAddress(string $uuid, Request $request, EntityManagerInterface $em)
    {
        $cart = $this->cartRepository->findOneByUuid($uuid);

        if(!$cart) {
            throw new \Exception('Cart not found');
        }

        $address = new Address();
        $form = $this->createForm(CartAddressType::class, $address);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $user = $this->getUser();
                $address->setUserAddress($user);
                $address->setIsEnable(true);

                $em->persist($address);
                $em->flush();

                return $this->redirectToRoute('app_front_cart_payment', ['uuid' => $cart->getUuid()]);
            }
        }

        return $this->render('front/cart/address.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

    #[Route('/cart/{uuid}/payment', name: 'cart_payment')]
    public function cartPayment(string $uuid): Response
    {
        $cart = $this->cartRepository->findOneByUuid($uuid);

        if(!$cart) {
            throw new \Exception('Cart not found');
        }

        return $this->render('front/cart/payment.html.twig', [
            'cart' => $cart,
            'intentSecret' => $this->cartManager->intentSecret($cart)
        ]);
    }

    #[Route('/cart/{uuid}/subscription', name: 'cart_subscription')]
    public function subscription(Cart $cart, Request $request)
    {
        if ($request->isMethod('POST')){

            $resource = $this->cartManager->stripe($_POST, $cart);

            if (null !== $resource) {

                $this->cartManager->createSubscription($resource, $cart);
                return $this->render('front/cart/payment_response.html.twig', [
                    'response' => 'success',
                    'cart' => $cart
                ]);
            }
        }
    }


    #[Route('/cart/delete', name: 'delete_cart', methods: ['POST'], options: ['expose' => true])]
    public function deleteCartItem(Request $request): Response
    {
        $content = $request->getContent();
        $cartUuid = json_decode($content, true, JSON_THROW_ON_ERROR);
        $response = $this->cartItemManager->delete($cartUuid['ticket']['uuid']);
        return $response;
    }
}
