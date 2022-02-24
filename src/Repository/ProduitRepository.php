<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function search($filter){
        $query = $this->createQueryBuilder('p')->leftJoin('p.parent', 'category');

        if (!is_null($filter["searchBar"])){
            $query->where('p.nom LIKE :nom')
                  ->orWhere('p.description LIKE :nom')
                  ->orWhere('category.nom LIKE :nom')
                  ->setParameter('nom', '%'.$filter['searchBar'].'%');

        }

        if (!is_null($filter["category"])){
            $query->andWhere('category = :category')->setParameter('category', $filter['category']);
        }

        if (!empty($filter["nbStar"])){
            $query->andWhere('p.nbStar IN (:array)')->setParameter('array', $filter['nbStar']);
        }

        if(!is_null($filter["prixMin"])){
            $query->andWhere('p.prix > :prixMin')->setParameter('prixMin', $filter['prixMin']);
        }

        if(!is_null($filter["prixMax"])){
            $query->andWhere('p.prix < :prixMax')->setParameter('prixMax', $filter['prixMax']);
        }


        return $query->getQuery()->getResult();
    }
}
