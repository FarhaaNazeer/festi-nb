<?php

namespace App\Controller\Api;

use App\Assembler\Festival\FestivalAssembler;
use App\Entity\Festival;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class FestivalController extends AbstractController
{
    public function __construct(
        private FestivalRepository $repository,
        private FestivalAssembler $festivalAssembler,
        private SerializerInterface $serializer,
        private  EntityManagerInterface $entityManager
    ) {}

    #[Route('/festivals', name: 'festivals', methods: ['GET'])]
    public function getFestivals() : JsonResponse
    {
        $festivals = $this->festivalAssembler->transformArray( $this->repository->findAll());

        return new JsonResponse([
           $this->serializer->serialize(
               $festivals,
               'json',
               ['groups' => 'festival_all']
           ),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;charset=UTF-8'],
            true
        ]);
    }

    #[Route('/festivals/filtered', name: 'festivals_filtered', methods: ['GET'])]
    public function getFilteredFestivals(Request $request): JsonResponse
    {
        $filters = $request->query->all();
        if (count($filters) > 0) {
            if (array_key_exists('begin_at', $filters)) {
                $filters['begin_at'] = new \DateTime($filters['begin_at']);
            }

            if (array_key_exists('end_at', $filters)) {
                $filters['end_at'] = new \DateTime($filters['end_at']);
            }

            $festivals = $this->repository->findByBetweenDate($filters);
        } else {
            $festivals = $this->repository->findAll();
        }

        return new JsonResponse([
            $this->serializer->serialize(
                $festivals,
                'json',
                ['groups' => 'festival_all']
            ),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;charset=UTF-8'],
            true
        ]);
    }

    #[Route('/festivals/{slug}', name: 'detailFestival', methods: ['GET'])]
    public function getFestivalBySlug(Festival $festival): JsonResponse
    {
        $festivalDto = $this->festivalAssembler->transform($festival);
        $festival = $this->serializer->serialize(
            $festivalDto,
            'json',
        );

        return new JsonResponse([
            $festival,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;charset=UTF-8'],
            true
        ]);
    }

    #[Route('/festivals', name: 'createFestival', methods: ['POST'])]
    public function createFestival(Request $request, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $festival = $this->serializer->deserialize($request->getContent(), Festival::class, 'json');
        $this->entityManager->persist($festival);
        $this->entityManager->flush();

        $jsonFestival = $this->serializer->serialize($festival, 'json');

        $location = $urlGenerator->generate('detailFestival', ['id' => $festival->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse([
            $jsonFestival,
            Response::HTTP_CREATED,
            ['Location' => $location],
            true
        ]);
    }


    #[Route('/festivals/{id}', name: 'createFestival', methods: ['PUT'])]
    public function updateFestival(Request $request, Festival $festival): JsonResponse
    {
        $updateFestival = $this->serializer->deserialize($request->getContent(), Festival::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE]);
        $contentArray = $request->toArray();


        return new JsonResponse([
            null,
            Response::HTTP_NO_CONTENT,
        ]);
    }


    #[Route('/festivals/{id}', name: 'deleteFestival', methods: ['DELETE'])]
    public function deleteFestival(Festival $festival): JsonResponse
    {
        $this->entityManager->remove($festival);
        $this->entityManager->flush();

        return new JsonResponse([
            null,
            Response::HTTP_NO_CONTENT,
        ]);
    }
}
