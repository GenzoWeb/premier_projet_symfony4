<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\CommentType;
use App\Entity\Ingredient;
use App\Entity\RecipeSearch;
use App\Form\RecipeSearchType;
use App\Entity\RecipeIngredient;
use App\Repository\StepRepository;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeIngredientRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
    public function index(Request $request)
    {
        
        $search = new RecipeSearch();
        $form = $this->createForm(RecipeSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nameCategory = $search->getNameCategory();
            $categoryId = null;
            if(!is_null($nameCategory)){
                $categoryId = $nameCategory->getId();
            }
           
            return $this->redirect($this->generateUrl('recipes', [
                'nameRecipe' => $search->getNameRecipe(),
                'ingredient' => $search->getIngredient(),
                'nameCategory' => $categoryId
            ]));
        }

        $recipes = $this->recipeRepo->findLatest();

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'Isaline',
            'recipes' => $recipes,
            'form'    => $form->createView()
        ]);
    }
        
    /**
     * @Route("/recettes", name="recipes")
    */
    public function recipes(PaginatorInterface $paginator, Request $request) 
    {

        $search = new RecipeSearch();
        $form = $this->createForm(RecipeSearchType::class, $search);
        $form->handleRequest($request);

        $recipes = $paginator->paginate(
            $this->recipeRepo->findAllQuery($search),
            $request->query->getInt('page', 1),
            6
        );

                    dump($search);
            dump($recipes);
        return $this->render('recipe/recipes.html.twig', [
            'recipes' => $recipes,
            'form'    => $form->createView(),
            'current_menu' => 'recipes'
        ]);
    }

    /**
     * @Route("/recette/{id}", name="recipe_show")
     */
    public function show(Recipe $recipe, Request $request, ObjectManager $manager)
    {
        $recipes = $this->recipeRepo->findById($recipe);
        	
        //Formulaire pour les commentaires
        $comment= new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser()->getUserName();
            $comment->setRecipe($recipe)
                    ->setAuthor($user)
                    ->setCreatedAt(new \DateTime());
                    
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $recipe->getId()]);
        }


        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
            'commentForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{name}", name="recipes_category")
    */
    public function category($name, PaginatorInterface $paginator, Request $request)
    {
        $search = new RecipeSearch();

        $form = $this->createForm(RecipeSearchType::class, $search);
        $form->handleRequest($request);

        $recipes = $paginator->paginate(
            $this->recipeRepo->findByCategory($name),
            $request->query->getInt('page', 1),
            3
        );

        if ($recipes){
            return $this->render('recipe/category.html.twig', [
                'name' => $name,
                'recipes' => $recipes,
                'form'    => $form->createView(),
                'current_menu' => $name
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
    }
}
