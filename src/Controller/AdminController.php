<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(MembreRepository $membreRepository): Response
    {
        $membres = $membreRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'membres' => $membres,
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'admin_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Membre $membre, MembreRepository $membreRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) {
            $this->container->get('security.token_storage')->setToken(null);
            
            $membreRepository->remove($membre, true);
        }
        return $this->redirectToRoute('app_admin');
    }

}
