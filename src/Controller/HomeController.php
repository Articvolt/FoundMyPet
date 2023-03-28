<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAll();

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    #[Route('/mon-profil', name: 'app_profil')]
    public function profil(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('home/profil.html.twig', [
        ]);
    }
}
