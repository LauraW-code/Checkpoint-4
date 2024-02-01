<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\BackgroundRepository;
use App\Entity\Background;
use App\Form\BackgroundType;
use Vich\UploaderBundle\Handler\DownloadHandler;

#[Route('/admin', name:'admin_')]
class BackgroundController extends AbstractController
{
    #[Route('/showBackgrounds', name:'show_backgrounds')]
    public function showBackgrounds(BackgroundRepository $backgroundRepository): Response
    {
        $backgrounds = $backgroundRepository->findAll();

        return $this->render('admin/show_backgrounds.html.twig', ['backgrounds' => $backgrounds]);
    }

    #[Route('/newBackground', name:'new_background')]
    public function newBackground(
        Background $background,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $background = new Background();

        $form = $this->createForm(BackgroundType::class, $background);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($background);
            $entityManager->flush();

            return $this->redirectToRoute('admin_show_backgrounds');
        }

        return $this->render('admin/new_background.html.twig', ['form' => $form]);
    }

    #[Route('/editBackground/{id}', name:'edit_background')]
    public function editBackground(
        Background $background,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(BackgroundType::class, $background);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            $this->addFlash('success', 'The background has been successfully edited');

            return $this->redirectToRoute('admin_show_backgrounds');
        }

        return $this->render('admin/edit_background.html.twig', [
            'form' => $form->createView(),
            'background' => $background
        ]);
    }

    #[Route('/deleteBackground/{id}', name:'delete_background')]
    public function deleteBackground(
        Background $background,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->remove($background);
        $entityManager->flush();

        $this->addFlash('success', 'This background has been successfully removed');

        return $this->redirectToRoute('admin_show_backgrounds');
    }
}
