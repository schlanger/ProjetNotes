<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route('/redirect', name: 'app_redirect',methods: ['GET'])]
    public function redirectsection(UserInterface $user)
    {
        if ($this->getUser()) {
            $user = $this->getUser();
            switch ($user->getRoles()[0]) {
                case "ROLE_USER":
                    return $this->redirectToRoute('app_note_index');

                case "ROLE_ADMIN":
                    return $this->redirectToRoute('app_home');
            }
        }
        return $this->redirectToRoute('app_login');
    }
}
