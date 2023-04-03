<?php

namespace App\Controller;


use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnonceRepository $annonceRepository, Request $request , PaginatorInterface $paginatorInterface): Response
    {
        $data = $annonceRepository->findBy([], ['dateCreation' =>'DESC']);
        $annonces = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1), 9
        );

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

}
