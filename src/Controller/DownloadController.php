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

#[Route('/downloads', name:'download_')]
class DownloadController extends AbstractController
{
    //Page that displays all characters available for download
    #[Route('/characters', name:'characters')]
    public function charactersDownload(CharacterRepository $characterRepository): Response
    {
        $characters = $characterRepository->findAll();

        return $this->render('downloads/characters.html.twig', ['characters' => $characters]);
    }

    //Page that displays all backgrounds available for download
    #[Route('/backgrounds', name:'backgrounds')]
    public function backgroundsDownload(BackgroundRepository $backgroundRepository): Response
    {
        $backgrounds = $backgroundRepository->findAll();

        return $this->render('downloads/backgrounds.html.twig', ['backgrounds' => $backgrounds]);
    }

    //Page that displays all effects available for download
    #[Route('/effects', name:'effects')]
    public function effectsDownload(EffectRepository $effectRepository): Response
    {
        $effects = $effectRepository->findAll();

        return $this->render('downloads/effects.html.twig', ['effects' => $effects]);
    }
}
