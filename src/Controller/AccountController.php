<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $errors = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('@EasyAdmin/page/login.html.twig', [
            'error' => $errors,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout(){

    }
}
