<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Annonce>
 *
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function save(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Annonce[] Returns an array of Annonce objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonce
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// public function rechercherAnnonces($espece, $tatoue, $puce, $sexeAnimal, $category, $ville, $nomAnimal)
// {
//     $queryBuilder = $this->createQueryBuilder('a')
//         ->innerJoin('a.category', 'c')
//         ->andWhere('c.nom = :category')
//         ->setParameter('category', $category);

//         if (!empty($espece)) {
//             $queryBuilder
//                 ->andWhere('a.espece = :espece')
//                 ->setParameter('espece', $espece->getEspece());
//         }
        
//         if (!empty($tatoue)) {
//             $queryBuilder
//                 ->andWhere('a.tatoue = :tatoue')
//                 ->setParameter('tatoue', $tatoue->getTatoue());
//         }
        
//         if (!empty($puce)) {
//             $queryBuilder
//                 ->andWhere('a.puce = :puce')
//                 ->setParameter('puce', $puce->getPuce());
//         }
        
//         if (!empty($sexeAnimal)) {
//             $queryBuilder
//                 ->andWhere('a.sexeAnimal = :sexeAnimal')
//                 ->setParameter('sexeAnimal', $sexeAnimal->getSexeAnimal());
//         }
        
//         if (!empty($ville)) {
//             $queryBuilder
//                 ->andWhere('a.ville = :ville')
//                 ->setParameter('ville', $ville->getVille());
//         }
        
//         if (!empty($nomAnimal)) {
//             $queryBuilder
//                 ->andWhere('a.nomAnimal LIKE :nomAnimal')
//                 ->setParameter('nomAnimal', '%'.$nomAnimal.'%');
//         }

//         return $queryBuilder->getQuery()->getResult();
// }
}
