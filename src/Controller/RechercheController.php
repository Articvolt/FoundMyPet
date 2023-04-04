<?php

namespace App\Controller;

use App\Entity\Annonce;

use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(AnnonceRepository $annonceRepository, PaginatorInterface $paginatorInterface , ManagerRegistry $doctrine, Request $request): Response
    {
        $annonces = $annonceRepository->findAll();

        $form = $this->createFormBuilder()
        
            ->add('espece', ChoiceType::class, [
                'choices' => [
                    'chat' => 'chat',
                    'chien' => 'chien',
                ],
                'required' => false,
                'label' => 'Espèce',
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'label' => 'Ville',
            ])
            
            ->add('rechercher', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // dd($data);1

            $qb = $annonceRepository
                ->createQueryBuilder('a');

            if ($data['espece']) {
                $qb->andWhere('a.espece = :espece')
                    ->setParameter('espece', $data['espece']);
            }

            if ($data['ville']) {
                $qb->andWhere('a.ville LIKE :ville')
                    ->setParameter('ville', '%' . $data['ville'] . '%');
            }

            $annonces = $qb->getQuery()
                ->getResult();

            return $this->render('recherche/index.html.twig', [
                'form' => $form->createView(),
                'annonces' => $annonces,
            ]);
        }

        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces,
        ]);

        // return $this->render('recherche/index.html.twig', [
        //     'annonces' => $annonces,
        // ]);
    }
}
