<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER", message: "Seul un utilisateur peut modifier son compte")]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if ($this->isGranted("ROLE_ADMIN"))
        {
            return $this->redirectToRoute('error_page', [], Response::HTTP_SEE_OTHER);
        }
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($user->getId() != $this->getUser()->getId()){
            return $this->redirectToRoute('error_page', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager->flush();

        }

        return $this->render('user/edit.html.twig', [
            'users' => $userRepository->findBy(['id'=> $this->getUser()]),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
