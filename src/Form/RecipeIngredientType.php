<?php

namespace App\Form;

use App\Entity\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('quantity', TextType::class)
            ->add('quantity', TextType::class, [
                'label' => 'Quantité :',
                // 'error_bubbling' => true
            ])
            ->add('measured', null, [
                'label' => 'Mesure :'
            ])
            // ->add('recipe', HiddenType::class)
            // ->add('ingredients')
            ->add('ingredients', CollectionType::class, [
                'entry_type' => IngredientType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            // ->add('ingredientName', EntityType::class, [
            //     'class' => IngredientName::class,
            //     'choice_label' => 'name',
            // ])
            // ->add('ingredientName', TextType::class , [
            //     'label' => 'Nom de la recette'
            // ])
            // ->add('ingredientName', CollectionType::class, [
            //         'entry_type' => IngredientName::class,
            //         'allow_add' => true,
            //         'allow_delete' => true,
            //         'by_reference' => false
            //     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}
