<?php

namespace App\DataFixtures;

use App\Entity\Step;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\IngredientName;
use App\Entity\RecipeIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //faker librairie de fausse données (pour pas faire le use)
        $faker = \Faker\Factory::create('fr_FR');


         //Création de 3 catégories
        $category = new Category();
        $category1 = new Category();
        $category2 = new Category();
        $category->setName('entrées');
        $manager->persist($category);
        $category1->setName('plats');
        $manager->persist($category1);
        $category2->setName('desserts');
        $manager->persist($category2);

        //Création de 10 recettes (fakées)
        for ( $j = 1; $j <= 10; $j++)
        {

            $recipe = new Recipe();
            $recipe ->setName($faker->sentence())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);
            
            //Création de 5 ingrédients (fakées)
            for ( $l = 1; $l <= 5; $l++)
            {
                $ingredient = new Ingredient();
                $ingredient ->setName($faker->word());
                
                $recipeIngredient = new RecipeIngredient();
                $recipeIngredient ->setQuantity($faker->numberBetween($min = 1, $max = 10))
                                  ->setMeasured($faker->randomElement($array = array ('cl','gr','ml')))
                                  ->addIngredient($ingredient);
                
                $manager->persist($recipeIngredient);

                $ingredient ->addRecipeIngredient($recipeIngredient);    
                $recipe->addRecipeIngredient($recipeIngredient);    

                $manager->persist($recipe);
                $manager->persist($ingredient);

                
            }

                // $recipe = new Recipe();
                // $recipe ->setName($faker->sentence())                                             
                //         ->setImage($faker->imageUrl())
                //         ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                //         ->setCategory($category)    
                //         ->addRecipeIngredient($recipeIngredient);    
                
                // $manager->persist($recipe);

            // Création entre 4 et 5 étapes pour réaliser une recette (fakées)
            for ( $m = 1; $m <= mt_rand(4, 6); $m++)
            {
                $step = new Step();
                $step ->setNumberStep($m)
                    ->setDescription($faker->paragraph())
                    ->setSteps($recipe);
                
                $manager->persist($step);
            }
        }
        $manager->flush();
    }
}