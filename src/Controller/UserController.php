<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{   
    #[Route('/user', name: 'app_profil')]
    public function profil(AnnonceRepository $annonceRepository): Response
    {
        $user = $this->getUser(); 
        $annonces = $annonceRepository->findBy(['membre' => $user]);


        return $this->render('user/profil.html.twig', [
            'annonces' => $annonces
        ]);
    }

    #[Route('/deleteUser/{id}', name: 'app_deleteUser')]
    public function deleteCompte(ManagerRegistry $doctrine, Membre $membre): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Impossible de supprimer ce compte !');
            return $this->redirectToRoute('app_home');
        }

        $this->container->get('security.token_storage')->setToken(null);
        
        $entityManager = $doctrine->getManager();
        $entityManager->remove($membre);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
  
}
