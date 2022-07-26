<?php

namespace App\Controller\Front;

use App\Manager\Festival\FestivalManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    public function __construct(private FestivalManager $manager)
    {}


    #[Route('festivals', name: 'festivals')]
    public function index() : Response
    {
        $festivals = $this->manager->getFestivals();

        return $this->render('front/festival/index.html.twig', [
            'festivals' => $festivals
        ]);
    }

    #[Route('filtered/festivals', name: 'filtered_festivals')]
    public function getFilteredFestivals(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $formData = $request->request->all()['search_bar_form'];
            foreach ($formData as $key => $value) {
                if ($value == '') {
                    unset($formData[$key]);
                }
            }
            $festivals = $this->manager->getFilteredFestival($formData);
        } else {
            $festivals = $this->manager->getFilteredFestival();
        }

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
