<?php

namespace App\Controller;

use DateTime;
use App\Entity\Message;
use App\Form\CommentaireType;
use App\Repository\AnnonceRepository;
use App\Repository\messageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    #[Route('/annonce/{id}/commentaire', name: 'app_commentaire')]
    public function index($id, ManagerRegistry $doctrine, AnnonceRepository $annonceRepository,  Request $request): Response
    {
        $annonceId = $annonceRepository->find($id);
        $user = $this->getUser(); 

        $message= new Message();
        $form = $this->createForm(CommentaireType::class, $message);
        $form->handleRequest($request);

        // Si les données du formulaires sont sousmises et validées alors :
            if ($form->isSubmitted() && $form->isValid()) {
                
                // initialise une instance de la classe "entitymanager" pour intéragir avec la base de données avec l'ORM Doctrine
                $entityManager = $doctrine->getManager();
        
                $message = $form->getData();
                $message->setAnnonce($annonceId);
                $message->setMembre($user);
                $message->setdateCreation(new DateTime('now'));
        
                //prepare
                $entityManager->persist($message);
                //execute
                $entityManager->flush();

                return $this->redirectToRoute('annonce_show');
        }

        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
}
