<?php

namespace App\Controller;

use App\Entity\Customisation;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
        return $this->render('account/login.html.twig', [
            'error' => $errors,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): Response
    {

        $user = new User();

        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $customisationRepository = $manager->getRepository(Customisation::class);
            $customisation =  $customisationRepository->findOneBy(['codeAuth' => $form->get('codeAuth')->getData(), 'isActive' => true]);
            if (!$customisation) {
                $this->addFlash('danger', 'Code d\'activation invalide');
                return $this->redirectToRoute('account_register');
            }
            $hash = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre compte a bien été crée ! Vous pouvez maintenant vous connecter.'
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/register.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout(){

    }
}
