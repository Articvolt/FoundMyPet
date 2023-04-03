<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnonceRepository $annonceRepository, Request $request , PaginatorInterface $paginatorInterface): Response
    {
        $data = $annonceRepository->findAll();
        $annonces = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1), 3
        );

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

}
