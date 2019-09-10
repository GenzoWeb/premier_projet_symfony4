<?php

namespace App\Repository;

use App\Entity\RecipeIngredient;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method RecipeIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeIngredient[]    findAll()
 * @method RecipeIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeIngredientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RecipeIngredient::class);
    }

    // public function findIdRecipeIngredient($recipe)
    // {
    //     return $this->createQueryBuilder('r')
    //     ->join('r.recipe', 'n')
    //     ->select('r.id')
    //     ->where('n.id = :rId')
    //     ->setParameter('rId', $recipe)
    //     ->getQuery()
    //     ->getResult();
    // }

    // public function findNameRecipeIngredient($id)
    // {
    //     return $this->createQueryBuilder('r')
    //     ->select('r.ingredientName')
    //     ->where('r.id = :rId')
    //     ->setParameter('rId', $id)
    //     ->getQuery()
    //     ->getResult();
    // }

    // public function findQuantityMeasured($id)
    // {
    //     return $this->createQueryBuilder('r')
    //         ->select('r.quantity', 'r.measured')
    //         ->andWhere('r.id = :recipe')
    //         ->setParameter('recipe', $id)
    //         ->getQuery()
    //         ->getResult();
    // }

    // /**
    //  * @return RecipeIngredient[] Returns an array of RecipeIngredient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipeIngredient
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
