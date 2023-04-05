<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\PseudonymeType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{   
    #[Route('/user', name: 'app_profil')]
    #[IsGranted('ROLE_USER')]
    public function profil(Request $request, ManagerRegistry $doctrine, AnnonceRepository $annonceRepository): Response
    {
        $user = $this->getUser(); 
        $annonces = $annonceRepository->findBy(['membre' => $user]);

        // modification du pseudonyme
        $form = $this->createForm(PseudonymeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // initialise une instance de la classe "entitymanager" pour intéragir avec la base de données avec l'ORM Doctrine
            $entityManager = $doctrine->getManager();
            // récupère les données du formulaire
            $membre = $form->getData();
            $entityManager->persist($membre);
            $entityManager->flush();
        }

        return $this->render('user/profil.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteUser/{id}', name: 'app_deleteUser')]
    #[IsGranted('ROLE_USER')]
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
