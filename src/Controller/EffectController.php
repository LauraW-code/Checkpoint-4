<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\EffectRepository;
use App\Entity\Effect;
use App\Form\EffectType;
use Vich\UploaderBundle\Handler\DownloadHandler;

#[Route('/admin', name:'admin_')]
class EffectController extends AbstractController
{
    #[Route('/showEffects', name:'show_effects')]
    public function showEffects(EffectRepository $effectRepository): Response
    {
        $effects = $effectRepository->findAll();

        return $this->render('admin/show_effects.html.twig', ['effects' => $effects]);
    }

    #[Route('/newEffect', name:'new_effect')]
    public function newEffect(
        Effect $effect,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $effect = new Effect();

        $form = $this->createForm(EffectType::class, $effect);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($effect);
            $entityManager->flush();

            return $this->redirectToRoute('admin_show_effects');
        }

        return $this->render('admin/new_effect.html.twig', ['form' => $form]);
    }

    #[Route('/editEffect/{id}', name:'edit_effect')]
    public function editEffect(
        Effect $effect,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(EffectType::class, $effect);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            $this->addFlash('success', 'The effect has been successfully edited');

            return $this->redirectToRoute('admin_show_effects');
        }

        return $this->render('admin/edit_effect.html.twig', [
            'form' => $form->createView(),
            'effect' => $effect
        ]);
    }

    #[Route('/deleteEffect/{id}', name:'delete_effect')]
    public function deleteEffect(
        Effect $effect,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->remove($effect);
        $entityManager->flush();

        $this->addFlash('success', 'This effect has been successfully removed');

        return $this->redirectToRoute('admin_show_effects');
    }
}
