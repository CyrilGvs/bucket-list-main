<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home')]
class HomeController extends AbstractController
{


    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/aboutus', name: '_about_us')]
    public function aboutus(): Response
    {
        return $this->render('home/aboutus.html.twig');
    }
}
