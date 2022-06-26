<?php

namespace App\Controller\Front;

use App\Manager\Festival\FestivalManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FestivalController extends AbstractController
{
    public function __construct(private FestivalManager $manager, private SerializerInterface $serializer)
    {}

    #[Route('/festivals', name: 'app_front_festivals')]
    public function index(): Response
    {
        $festivals = $this->manager->findAll();

        return $this->render('front/festival/index.html.twig', [
            'festivals' => $festivals
        ]);
    }

}
