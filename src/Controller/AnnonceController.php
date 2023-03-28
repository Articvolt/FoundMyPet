<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    #[Route("/annonce/{id}", name: "annonce_show")]

    public function show(Annonce $annonce): Response
    {
        return $this->render('home/show.html.twig', [
            'annonce' => $annonce
        ]);
    }


    //============================= SUPPRIMER ANNONCE + IMAGE STOCKEE ================================================


    #[Route("/annonce/delete/{id}", name: "annonce_delete")]

    public function delete(ManagerRegistry $doctrine, Annonce $annonce)
    {
        $entityManager = $doctrine->getManager();

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

        return $this->redirectToRoute('app_home');
    }

    //================================= FONCTION D'AFFICHAGE ET D'EDITION DE L'ANNONCE ============================


    #[Route("/annonce", name: "app_annonce")]
    #[Route("/annonce/{id}/edit", name: "annonce_edit")]

    public function index(ManagerRegistry $doctrine, Annonce $annonce = null, Request $request): Response
    {
        $annonces = $doctrine->getRepository(Annonce::class)->findAll();

        if (!$annonce) {
            $annonce = new Annonce();
        }

        // vérifie si nous sommes dans le cas d'édition de l'annonce
        $isEdit = $annonce !== null && $annonce->getId() !== null;

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        // Si les données du formulaires sont sousmises et validées alors :
        if ($form->isSubmitted() && $form->isValid()) {

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
                $img = new Images();
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
            'edit' => $annonce->getId()
        ]);
    }
}