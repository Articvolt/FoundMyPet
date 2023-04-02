<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Model\RechercheData;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(AnnonceRepository $annonceRepository, Request $request): Response
    {
        $annonces = $annonceRepository->findAll();

        $rechercheData = new RechercheData();
        // création du formulaire
        $form = $this->createForm(RechercheType::class, $rechercheData);
        // récupèration de la requête par le formulaire
        $form->handleRequest($request);

        // condition si formulaire validé et vérifié
        if ( $form->isSubmitted() && $form->isValid()) {
            dd($rechercheData);
        }

        return $this->render('recherche/index.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView(),
        ]);
    }
}
