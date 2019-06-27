<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\RecipeIngredient;
use App\Repository\StepRepository;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeIngredientRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{

    public function __construct(RecipeRepository $recipeRepo, StepRepository $stepRepo, CategoryRepository $categoryRepo, IngredientRepository $ingredientRepo, RecipeIngredientRepository $recipeIngredientRepo)
    {
        $this->recipeRepo = $recipeRepo;
        $this->stepRepo = $stepRepo;
        $this->categoryRepo = $categoryRepo;
        $this->ingredientRepo = $ingredientRepo;
        $this->recipeIngredientRepo = $recipeIngredientRepo;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $recipes =$this->recipeRepo->findLatest();

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'Isaline',
            'recipes' => $recipes
        ]);
    }
        
    /**
     * @Route("/recettes", name="recipes")
    */
    public function recipes()
    {
        $recipes = $this->recipeRepo->findAll();
        return $this->render('recipe/recipes.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * @Route("/recettes/{id}", name="recipe_show")
     */
    public function show(Recipe $recipe)
    {

        //Récupération valeur quantity et mesure et nom de l'ingrédient
        // $ingredientArray = [];
        // for( $j = 0; $j < count($ingredients); $j++)
        // {
        //     $quantityIngredient = $this->recipeIngredientRepo->findQuantityMeasured($ingredients[$j]['id']);
        //     $nameIngredient = $this->ingredientRepo->findNameIngredient($ingredients[$j]['id']);
        //     array_push($ingredientArray, $quantityIngredient[0]);
        //     array_push($ingredientArray[$j], $nameIngredient[0]);
        // }

        // $steps = $this->stepRepo-> find($recipe);


        //récupération des id pour les recipe_ingredient correspondant à la recette
        $ingredients = $this->recipeIngredientRepo->findIdRecipeIngredient($recipe);
        
        //Nombre d'aliments
        $number = count($ingredients);

        $ingredientArray = [];
        for( $i = 0; $i < count($ingredients); $i++)
        {
            $test= $this->ingredientRepo->findNameIngredient($ingredients[$i]['id']);
            array_push($ingredientArray, $test[0]);
        }

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
            'number' => $number,
            'ingredientArray' => $ingredientArray
            // 'steps'  => $steps,
            // 'ingredients' => $ingredients,
            // 'nameIngredient' => $nameIngredient,
            // 'ingredientArray' => $ingredientArray,
        ]);
    }

    /**
     * @Route("/category/{name}", name="recipes_category")
    */
    public function category($name)
    {
        $category = $this->categoryRepo->findBy(array('name' => $name));
        $recipes = $this->recipeRepo->findBy(array('category' => $category));

        if ($recipes){
            return $this->render('recipe/category.html.twig', [
                'name' => $name,
                'category' => $category,
                'recipes' => $recipes
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
    }

    // /**
    //  * @Route("/entrees", name="recipes_starters")
    // */
    // public function starters()
    // {
    //     $category = $this->categoryRepo->findBy(array('name' => 'entree'));
    //     $recipes = $this->recipeRepo->findBy(array('category' => $category));

    //     return $this->render('recipe/starters.html.twig', [
    //         'recipes' => $recipes
    //     ]);
    // }

    // /**
    //  * @Route("/plats", name="recipes_main_courses")
    // */
    // public function mainCourses()
    // {
    //     $category = $this->categoryRepo->findBy(array('name' => 'plat'));
    //     $recipes = $this->recipeRepo->findBy(array('category' => $category));

    //     return $this->render('recipe/main_courses.html.twig', [
    //         'recipes' => $recipes
    //     ]);
    // }

    // /**
    //  * @Route("/desserts", name="recipes_desserts")
    // */
    // public function desserts()
    // {
    //     $category = $this->categoryRepo->findBy(array('name' => 'dessert'));
    //     $recipes = $this->recipeRepo->findBy(array('category' => $category));

    //     return $this->render('recipe/desserts.html.twig', [
    //         'recipes' => $recipes
    //     ]);
    // }

    /**
     * @Route("/recherche", name="recipe_search")
    */
    public function recipes_search()
    {
        return $this->render('recipe/search.html.twig');
    }
    /**
     * @Route("/Connexion", name="login")
    */
    public function login()
    {
        return $this->render('recipe/login.html.twig');
    }
}
