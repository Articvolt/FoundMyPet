<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Annonce;
use App\Entity\Message;
use App\Form\AnnonceType;
use App\Form\CommentaireType;
use App\HttpClient\NominatimHttpClient;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AnnonceController extends AbstractController
{

    #[Route("/annonce/add/{id}", name: "annonce_show")]
    #[Route("/annonce/{id}/editMessage/{idMessage}", name: "message_edit")]
    #[ParamConverter('annonce', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('message', options: ['mapping' => ['idMessage' => 'id']])] 

public function showOrEditMessage(Annonce $annonce, NominatimHttpClient $nominatim , ManagerRegistry $doctrine, Message $message = null, Request $request) 
{
    $user = $this->getUser();
    $edit = $message ? true : false;

    if (!$message) {
        $message = new Message();
    }

    $form = $this->createForm(CommentaireType::class, $message);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $entityManager = $doctrine->getManager();

        if (!$edit) {
            $message->setAnnonce($annonce);
            $message->setMembre($user);
            $message->setdateMessage(new \DateTime('now'));
        }
        
        //prepare
        $entityManager->persist($message);
        //execute
        $entityManager->flush();
        
        return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);
    }

    // leaflet

    // récupère l'adresse complète (adresse+CP+ville)
    $adresse = $annonce->AdresseCompleteAPI();
    // récupère la réponse JSON de la requête HTTP
    $datageo= $nominatim->getLocation($adresse);

    return $this->render( 'annonce/show.html.twig', [
        'annonce' => $annonce,
        'form' => $form->createView(),
        'edit' => $edit ? $message->getId() : null,
        'datageo' => $datageo,

    ]);
}

    //============================= SUPPRIMER MESSAGE ================================================
    
    #[Route("/annonce/{id}/deleteMessage/{idMessage}", name: "message_delete")]
    #[ParamConverter('annonce', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('message', options: ['mapping' => ['idMessage' => 'id']])] 
    #[IsGranted("ROLE_USER")]


    public function deleteMessage(ManagerRegistry $doctrine, Annonce $annonce, Message $message) 
    {

        $entityManager = $doctrine->getManager();

        $connect = $this->getUser();
        $user = $message->getMembre();
        if ($connect == $user || $this->isGranted('ROLE_ADMIN') ) {

        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);

        } else {
            throw new AccessDeniedException();
            return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);
        }
    }

    
    //============================= SUPPRIMER ANNONCE + IMAGE STOCKEE ================================================


    #[Route("/annonce/delete/{id}", name: "annonce_delete")]
    #[IsGranted("ROLE_USER")]

    public function delete(ManagerRegistry $doctrine, Request $request, Annonce $annonce)
    {
        $entityManager = $doctrine->getManager();

        $connect = $this->getUser();
        $user = $annonce->getMembre();
        if ($connect == $user || $this->isGranted('ROLE_ADMIN') ) {
            // Récupérer les images associées à l'annonce

            $images = $annonce->getImages();

            // Supprimer chaque fichier correspondant dans le dossier "upload"
            foreach ($images as $image) {

                $filePath = $this->getParameter('images_directory') . '/' . $image->getName();
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $entityManager->remove($annonce);
            $entityManager->flush();

            // redirection de la route en fonction de la page d'origine
            if (Request::create($request->headers->get('referer'))->getPathInfo() == $this->generateUrl('app_home')) {
                return $this->redirectToRoute('app_home');
            } else {
            return $this->redirectToRoute('app_profil');
            }
        } else {
            // message d'erreur en brut
            throw new AccessDeniedException();
            return $this->redirectToRoute('app_profil');
        }
    }

    //================================= FONCTION D'AFFICHAGE ET D'EDITION DE L'ANNONCE ============================


    #[Route("/annonce", name: "app_annonce")]
    #[Route("/annonce/edit/{id}", name: "annonce_edit")]

    public function ajoutEditAnnonce(ManagerRegistry $doctrine, Annonce $annonce = null, Request $request): Response
    {
        $annonces = $doctrine->getRepository(Annonce::class)->findAll();

        if (!$annonce) {
            $annonce = new Annonce();
        }

        // vérifie si nous sommes dans le cas d'édition de l'annonce
        $isEdit = $annonce !== null && $annonce->getId() !== null;

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        $connect = $this->getUser();
        $user = $annonce->getMembre();

        
        // Si les données du formulaires sont sousmises et validées alors :
            if ($form->isSubmitted() && $form->isValid()) {
                
                // si c'est l'ajout d'une annonce alors on peux ajouter une image
                if (!$isEdit) {
                    // récupère les images transmises
                    $image = $form->get('image')->getData();

                    // génération d'un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                    // copie du fichier dans le dossier upload
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
                    // stocke l'image dans la base de données (son nom)
                    $img = new Image();
                    $img->setName($fichier);
                    if ($annonce !== null) {
                        // Ajouter l'image à l'annonce
                        $annonce->addImage($img);
                    }
                }
                              
                // initialise une instance de la classe "entitymanager" pour intéragir avec la base de données avec l'ORM Doctrine
                $entityManager = $doctrine->getManager();

                // récupère les données du formulaire
                $annonce = $form->getData();
                // ajoute la date actuelle à la donnée "dateCreation"
                $annonce->setdateCreation(new \DateTime('now'));
                // ajoute l'utilisateur connecté
                $membre = $this->getUser();
                $annonce->setMembre($membre);
      
                //prepare
                $entityManager->persist($annonce);
                //execute
                $entityManager->flush();

                // après validation retourne sur la page d'accueil
                return $this->redirectToRoute('app_home');
            }
        
        return $this->render('annonce/index.html.twig', [
            'formAddAnnonce' => $form->createView(),
            'annonces' => $annonces,
            'edit' => $annonce->getId(),

        ]);
    }

    
}
