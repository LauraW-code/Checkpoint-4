<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Entity\Backrgound;
use App\Entity\Effect;
use App\Entity\Contact;

#[Route('/admin', name:'admin_')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name:'dashboard')]
    public function indexDashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
