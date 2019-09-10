<?php

namespace App\Entity;

class RecipeSearch {

    /**
     *
     * @var string|null
     */
    private $ingredient;

    /**
     *
     * @var string|null
     */
    private $nameRecipe;
    
    /**
     *
     * @var string|null
     */
    private $nameCategory;

    /**
     * Get the value of ingredient
     *
     * @return  string|null
     */ 
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set the value of ingredient
     *
     * @param  string|null  $ingredient
     *
     * @return  self
     */ 
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get the value of nameRecipe
     *
     * @return  string|null
     */ 
    public function getNameRecipe()
    {
        return $this->nameRecipe;
    }

    /**
     * Set the value of nameRecipe
     *
     * @param  string|null  $nameRecipe
     *
     * @return  self
     */ 
    public function setNameRecipe($nameRecipe)
    {
        $this->nameRecipe = $nameRecipe;

        return $this;
    }

    /**
     * Get the value of nameCategory
     *
     * @return  string|null
     */ 
    public function getNameCategory()
    {
        return $this->nameCategory;
    }

    /**
     * Set the value of nameCategory
     *
     * @param  string|null  $nameCategory
     *
     * @return  self
     */ 
    public function setNameCategory($nameCategory)
    {
        $this->nameCategory = $nameCategory;

        return $this;
    }
}