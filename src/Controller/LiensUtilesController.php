<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LiensUtilesController extends AbstractController
{
    #[Route('/liens/utiles', name: 'app_liens_utiles')]
    public function index(): Response
    {
        return $this->render('liens_utiles/index.html.twig', [
            'controller_name' => 'LiensUtilesController',
        ]);
    }
}
