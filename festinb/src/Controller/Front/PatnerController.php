<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\RegistrationFormType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PatnerController extends AbstractController
{
    #[Route('/patners/login', name: 'login_patners')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(RegistrationFormType::class, new User());


        return $this->render('front/patner/index.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'form' => $form->createView()

            ]);
    }
}
