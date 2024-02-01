<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\CharacterRepository;
use App\Entity\Character;
use App\Entity\Background;
use App\Entity\Effect;
use App\Entity\Contact;
use App\Form\CharacterType;
use Vich\UploaderBundle\Handler\DownloadHandler;

#[Route('/admin', name:'admin_')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name:'dashboard')]
    public function indexDashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/characters', name:'characters')]
    public function showCharacters(
        CharacterRepository $characterRepository
    ): Response {
        $characters = $characterRepository->findAll();

        return $this->render('admin/show_characters.html.twig', ['characters' => $characters]);
    }

    #[Route('/newCharacter', name:'new_character')]
    public function newCharacter(
        Request $request,
        Character $character,
        EntityManagerInterface $entityManager
    ): Response {
        $character = new Character();

        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('admin_characters');
        }

        return $this->render('admin/new_character.html.twig', ['form' => $form]);
    }

    #[Route('/editCharacter/{id}', name: 'edit_character')]
    public function editCharacter(
        Request $request,
        Character $character,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CharacterType::class, $character);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            $this->addFlash('success', 'The character has been edited successfully');

            return $this->redirectToRoute('admin_characters');
        }


        return $this->render('admin/edit_character.html.twig', [
            'form' => $form->createView(),
            'character' => $character
        ]);
    }

    #[Route('deleteCharacter/{id}', name: 'delete_character')]
    public function deleteCharacter(
        Request $request,
        Character $character,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->remove($character);
        $entityManager->flush();

        $this->addFlash('success', 'This character has been successfully removed');

        return $this->redirectToRoute('admin_characters');
    }
}
