<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/note')]
class NoteController extends AbstractController
{
    #[Route('/', name: 'app_note_index', methods: ['GET'])]
    #[IsGranted("ROLE_USER", message: "Seul un utilisateur peut voir ses notes")]
    public function index(NoteRepository $noteRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findBy(['user' => $this->getUser()]),
        ]);
    }


    #[Route('/{id}', name: 'app_note_show', methods: ['GET'])]
    #[IsGranted("ROLE_USER", message: "Seul un utilisateur peut voir ses notes")]
    public function show(Note $note): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }
}
