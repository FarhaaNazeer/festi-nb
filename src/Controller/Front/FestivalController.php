<?php

namespace App\Controller\Front;

use App\Manager\Festival\FestivalManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    public function __construct(private FestivalManager $manager)
    {}

    #[Route('/festivals', name: 'festivals')]
    public function index(): Response
    {
        $festivals = $this->manager->get();

        return $this->render('front/festival/index.html.twig', [
            'festivals' => $festivals
        ]);
    }

    #[Route('/festival/{slug}', name: 'festival')]
    public function festivalBySlug(string $slug): Response
    {
        $festival = $this->manager->findOneBySlug($slug);

        return $this->render('front/festival/single.html.twig', [
            'festival' => $festival
        ]);
    }
}