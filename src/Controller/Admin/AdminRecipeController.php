<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeIngredientRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminRecipeController extends AbstractController
{

    public function __construct(RecipeRepository $recipeRepo, ObjectManager $em, RecipeIngredientRepository $recipeIngredientRepo, IngredientRepository $ingredientRepo)
    {
        $this->recipeRepo = $recipeRepo;
        $this->em = $em;
        $this->recipeIngredientRepo = $recipeIngredientRepo;
        $this->ingredientRepo = $ingredientRepo;
    }

    /**
     * @Route("/", name="admin.recipe.index")
     */
    public function index()
    {
        $recipes = $this->recipeRepo->findAll();

        return $this->render('admin/recipe/index.html.twig', [
            'controller_name' => 'Isaline',
            'recipes' => $recipes
        ]);
    }

    /**
     * @Route("/recipe/create", name="admin.recipe.new")
     */
    public function new(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $recipe->setCreatedAt(new \DateTime());
            $this->em->persist($recipe);
            $this->em->flush();
            $this->addflash('success', 'Recette ajoutée avec succés');
            return $this->redirectToRoute('admin.recipe.index');
        }

        return $this->render('admin/recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recipe/{id}", name="admin.recipe.delete", methods="DELETE")
     */
    public function delete(Recipe $recipe, Request $request)
    {
        //récupération des id pour les recipe_ingredient correspondant à la recette
        $recipeIngredients = $this->recipeIngredientRepo->findIdRecipeIngredient($recipe);

        $numberIngredient = count($recipeIngredients);

        $recipeIngredientArray = [];
        $ingredientArray = [];
        
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->get('_token')))
        {
            for( $i = 0; $i < $numberIngredient; $i++)
            {
                $recipeIngredientsRemove = $this->recipeIngredientRepo->findById($recipeIngredients[$i]['id']);
                $ingredient = $this->ingredientRepo->findIdIngredient($recipeIngredients[$i]['id']);
                $ingredientRemove = $this->ingredientRepo->findById($ingredient[0]['id']);

                array_push($recipeIngredientArray, $recipeIngredientsRemove[0]);
                array_push($ingredientArray, $ingredientRemove[0]);
                $this->em->remove($recipeIngredientArray[$i]);
                $this->em->remove($ingredientArray[$i]);
            }
            $this->em->remove($recipe);      
            $this->em->flush();
            $this->addflash('success', 'Recette supprimée avec succés');
        }
        
        return $this->redirectToRoute('admin.recipe.index');
    }

    /**
     * @Route("/recipe/{id}", name="admin.recipe.edit", methods="GET|POST")
     */
    public function edit(Recipe $recipe, Request $request)
    {
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addflash('success', 'Recette modifiée avec succés');
            return $this->redirectToRoute('admin.recipe.index');
        }

        return $this->render('admin/recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView()
        ]);
    }
}
