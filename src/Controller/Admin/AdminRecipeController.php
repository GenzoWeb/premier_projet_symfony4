<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Entity\RecipeSearch;
use App\Form\RecipeSearchType;
use App\Repository\RecipeRepository;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeIngredientRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @Route("/recipes", name="admin.recipe.index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search = new RecipeSearch();
        $form = $this->createForm(RecipeSearchType::class, $search);
        $form->handleRequest($request);
        
        $recipes = $paginator->paginate(
            $this->recipeRepo->findAllQuery($search),
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('admin/recipe/index.html.twig', [
            'recipes' => $recipes,
            'current_menu' => 'admin',
            'form'    => $form->createView()
        ]);
    }

    /**
     * @Route("/recipe/create", name="admin.recipe.new")
     */
    public function new(Request $request, ValidatorInterface $validator)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $numberSteps = count($recipe->getSteps());     
 
            for($i = 0; $i < $numberSteps; $i++)
            {
                $recipe->getSteps()[$i]->setNumberStep($i + 1);
            }

            $recipe->setCreatedAt(new \DateTime());
            $this->em->persist($recipe);
            $this->em->flush();
            $this->addflash('success', 'Recette ajoutée avec succés');

            return $this->redirectToRoute('admin.recipe.index');
        }

        $errors = $validator->validate($recipe);

        return $this->render('admin/recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
            'current_menu' => 'admin',
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/recipe/{id}", name="admin.recipe.delete", methods="DELETE")
     */
    public function delete(Recipe $recipe, Request $request)
    {
        
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->get('_token')))
        {
            foreach($recipe->getRecipeIngredients() as $recipeIngredient) 
            {
                foreach($recipeIngredient->getIngredients() as $ingredient) 
                {
                    $this->em->remove($ingredient);
                }
                $this->em->remove($recipeIngredient);
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
            $recipe->setUpdatedAt(new \DateTime());
            $this->em->flush();
            $this->addflash('success', 'Recette modifiée avec succés');
            
            return $this->redirectToRoute('admin.recipe.index');
        }
        
        return $this->render('admin/recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
            'current_menu' => 'admin'
        ]);
    }
}