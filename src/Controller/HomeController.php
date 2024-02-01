<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Entity\Background;
use App\Entity\Effect;
use App\Repository\CharacterRepository;
use App\Repository\BackgroundRepository;
use App\Repository\EffectRepository;
use Vich\UploaderBundle\Handler\DownloadHandler;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/downloads', name:'app_downloads')]
    public function downloadPage(
        CharacterRepository $characterRepository,
        BackgroundRepository $backgroundRepository,
        EffectRepository $effectRepository
    ): Response {
        $backgrounds = $backgroundRepository->findAll();
        $characters = $characterRepository->findAll();
        $effects = $effectRepository->findAll();

        return $this->render('home/downloads.html.twig', [
            'characters' => $characters,
            'backgrounds' => $backgrounds,
            'effects' => $effects
        ]);
    }

    #[Route('downloadCharacter/{id}', name:'app_download_character')]
    public function downloadCharacter(
        Character $character,
        DownloadHandler $downloadHandler
    ): Response {
        return $downloadHandler->downloadObject($character, $fileField = 'pictureFile');
    }

    #[Route('downloadBackground/{id}', name:'app_download_background')]
    public function downloadBackground(
        Background $background,
        DownloadHandler $downloadHandler
    ): Response {
        return $downloadHandler->downloadObject($background, $fileField = 'pictureFile');
    }

    #[Route('downloadEffect/{id}', name:'app_download_effect')]
    public function downloadEffect(
        Effect $effect,
        DownloadHandler $downloadHandler
    ): Response {
        return $downloadHandler->downloadObject($effect, $fileField = 'pictureFile');
    }
}
