<?php

namespace App\Controller\Back;

//use App\Assembler\Festival\FestivalAssembler;
//use App\Assembler\Ticket\TicketAssembler;
use App\Dto\User\UserDto;
use App\Entity\User;
use App\Form\RegistrationFormType;
//use App\Manager\Ticket\TicketManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends  AbstractController
{

    public function __construct(
//        private TicketManager $manager,
        private UserRepository $partnerRepository,
        private EntityManagerInterface $entityManager,
//        private TicketAssembler $assembler,
//        private FestivalAssembler $festivalAssembler
    ) {}

    #[Route('/partners', name: 'partners')]
    public function get(): Response
    {
        $partners = $this->partnerRepository->findAll();

        return $this->render('back/partner/index.html.twig', [
            'partners' => $partners
        ]);
    }

    #[Route('/partner/create', name: 'partner_create')]
    public function create(Request $request): Response
    {
        $partner = new User();

        $form = $this->createForm(RegistrationFormType::class, $partner);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $data = $form->getData();

                $partnerDto = new UserDto();
                $partnerDto->firstname = $data->getFirstname();
                $partnerDto->lastname = $data->getLastname();
                $partnerDto->email = $data->getEmail();
                $partnerDto->roles = $data->getRoles();

                $partner = $this->assembler->reverseTransform($partnerDto);

                $this->entityManager->persist($partner);
                $this->entityManager->flush();

                $this->addFlash('success', 'Le partenaire a été créé avec succès');
                $this->redirectToRoute('app_back_partner_create');
            }
        }

        return $this->render('back/partner/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/partner/update/{uuid}', name: 'partner_update')]
    public function update(Partner $partner, Request $request): Response
    {
        $form = $this->createForm(RegistrationType::class, $partner);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $this->entityManager->persist($partner);
                $this->entityManager->flush();

                $this->addFlash('success', 'Le partenaire a été modifié avec succès');
                $this->redirectToRoute('app_back_partners');
            }
        }

        return $this->render('back/partner/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/partner/delete/{uuid}', name: 'partner_delete')]
    public function delete(Partner $partner): Response
    {

//        if ($cartItems = $ticket->getCartItems()) {
//            foreach ($cartItems as $cartItem) {
//                $ticket->removeCartItem($cartItem);
//            }
//        }

        $this->entityManager->remove($partner);
        $this->entityManager->flush();

        $this->addFlash('danger', 'Votre partenaire a bien été supprimé');
        return $this->redirectToRoute('app_back_partners');
    }
}