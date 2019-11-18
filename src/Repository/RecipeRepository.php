<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\ORM\Query;
use App\Entity\RecipeSearch;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @return Recipe[]
     */
    public function findLatest() : array
    {
        return $this->createQueryBuilder('r')
            ->setMaxResults(4)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;        
    }

    /**
     * @return Query
     */
    public function findAllQuery(RecipeSearch $search) : Query
    {
        $query = $this->createQueryBuilder('r')
                ->orderBy('r.createdAt', 'DESC');

        if($search->getNameRecipe())
        {
            $query = $query
                ->andWhere("r.name LIKE :nameRecipe")
                ->setParameter('nameRecipe', '%' . $search->getNameRecipe() . '%');
        }

        if($search->getIngredient())
        {
            $query = $query
                ->join('r.recipeIngredients', 'rI')
                ->join('rI.ingredients', 'i')
                ->andWhere("i.name LIKE :ingredient")
                ->setParameter('ingredient', '%' . $search->getIngredient() . '%');
        }

        if($search->getNameCategory())
        {
            $query = $query
                ->join('r.category', 'c')
                ->andWhere("c.id = :nameCategory")
                ->setParameter('nameCategory', $search->getNameCategory());
        }

        // $query = $query->orderBy('r.createdAt', 'DESC');

        return $query->getQuery();
    }

    public function findByCategory($category)
    {
        return $this->createQueryBuilder('r')
            ->join('r.category', 'c')
            ->andWhere("c.name = :cat")
            ->setParameter('cat', $category)
            ->getQuery()
            ->getResult()
        ;         
    }
    
    // /**
    //  * @return Recipe[] Returns an array of Recipe objects
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
    public function findOneBySomeField($value): ?Recipe
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
