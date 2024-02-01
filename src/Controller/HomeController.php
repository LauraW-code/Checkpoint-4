<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Repository\CharacterRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/downloads', name:'app_downloads')]
    public function downloadPage(
        CharacterRepository $characterRepository
    ): Response {
        $characters = $characterRepository->findAll();

        return $this->render('home/downloads.html.twig', ['characters' => $characters]);
    }
}
