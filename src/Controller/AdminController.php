<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    // seul les roles admin sont autorisés à effectuer cette action
    #[IsGranted('ROLE_ADMIN')]
    public function index(MembreRepository $membreRepository): Response
    {
        // requête DQL pour récupérer tout les membres
        $membres = $membreRepository->findAll();

        // appel de la vue
        return $this->render('admin/index.html.twig', [
            // ajout du paramètre membre précédemment appelé
            'membres' => $membres,
        ]);
    }
    // définition de la route avec son nom pour pouvoir l'appeler
    #[Route('/admin/delete/{id}', name: 'admin_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Membre $membre, ManagerRegistry $doctrine): Response
    {
        // supprimer le membre ciblé de la base de données
        $entityManager = $doctrine->getManager();
        // fonction anonymisation du memebre (set to NULL)
        $membre->delete();
        // fonction de suppression du membre
        $entityManager->remove($membre);
        $entityManager->flush();
        // ajoute une fenêtre d'informations
        $this->addFlash('success', 'Utilisateur supprimé avec succès !');

        return $this->redirectToRoute('app_admin');
    }

    // création d'une route pour afficher une vue "conditions d'utilisation"
    #[Route('/conditions-générales-d-utilisation', name: 'app_CGU')]
    public function CGU(): Response
    {
        return $this->render('home/CGU.html.twig', []);
    }

}
