{% extends 'base.html.twig' %}

{% block title %} Ajouter une recette{% endblock %}

{% block body %}

<div class="container mt-4">
    <h1>Ajouter une recette</h1>

    {# {{ include('admin/recipe/_form.html.twig', {form: form, button: 'Ajouter'}) }} #}


    {{ form_start(form) }}
    <div class="row">
        <div class="col-md-12">{{ form_row(form.name) }}</div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">{{ form_row(form.category) }}</div>
                <div class="col-md-4">{{ form_row(form.image) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <p>Ingrédients</p>
        <div class="col-md-8">
            <p>TEST</p>
            <div class="row">
                {# <div class="">{{ form_row(form.recipeIngredients) }}</div> #}
                    {% for ingredient in form.recipeIngredients %}
                        <div class="">{{ form_row(ingredient.quantity) }}</div>
                <div class="">{{ form_row(ingredient.measured) }}</div>
                <div class="">{{ form_row(ingredient.ingredients) }}</div>
                {% endfor %}
            </div>
        </div>
        <p>TEST</p>
    </div>
    <div class="row">
        {# {{ dump(form.recipeIngredients) }} #}
            {# <div class="col-md-4">{{ form_row(form.recipeIngredients) }}</div> #}
            {% for ingredient in form.recipeIngredients %}
                <div class="">{{ form_widget(ingredient.quantity) }}</div>
        <div class="">{{ form_widget(ingredient.measured) }}</div>
        <div class="">{{ form_widget(ingredient.ingredients) }}</div>
        {% endfor %}
        {# <div class="col-md-4">{{ form_widget(form.vars.prototype.recipeIngredients) }}</div> #}
        </div>
    <div class="col-md-8">
        <p>Etapes</p>
        <div class="row">
            {# <div class="col-md-4">{{ form_row(form.steps) }}</div> #}
                {% for step in form.steps %}
                    <div class="step">{{ form_widget(step.numberStep) }}</div>
            <div class="step col-md-8">{{ form_widget(step.description) }}</div>
            {% endfor %}
        </div>
    </div>
    <a href="#" id="add_ingredient" class="btn btn-primary">Ajouter quantité</a>
    <br />
    <br />
    <br />
    <a href="#" id="add_step" class="btn btn-primary">Ajouter une étape</a>
    <br />
    <br />
    <br />
    <a href="#" id="add_ingredient_test" class="btn btn-primary">Ajouter ingrédient</a>
    {{ form_rest(form) }}
    <button class="btn btn-primary">Ajouter</button>
</div>
{% endblock %}

{% block javascripts %}
<script>
    $(document).ready(function () {

            ////////////////////////////////////////////////////
            //  AJOUT DES QUANTITE ET MESURE POUR INGREDIENT  //
            ////////////////////////////////////////////////////

            // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
            var container1 = $('div#recipe_recipeIngredients');


    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index1 = container1.find(':input').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
            $('#add_ingredient').click(function (e) {
        addCategory1(container1, index1);

    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
});

// On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
            if (index1 == 0) {
        addCategory1(container1, index1);
    } else {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        container1.children('div').each(function () {
            addDeleteLink1($(this));
        });
    }

            // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var container2 = $('div#recipe_recipeIngredients_0_ingredients');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index2 = container2.find(':input').length;


    ///////////////////////////////////
    //  AJOUT DU NOM DE L INGREDIENT //
    ///////////////////////////////////

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
            $('#add_ingredient_test').click(function (e) {
            addCategory1(container2, index2);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
            if (index2 == 0) {
            addCategory1(container2, index2);
        } else {
            // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
            container2.children('div').each(function () {
                addDeleteLink1($(this));
            });
        }

        // La fonction qui ajoute un formulaire CategoryType
            function addCategory1(contain, ind) {
                // Dans le contenu de l'attribut « data-prototype », on remplace :
                // - le texte "__name__label__" qu'il contient par le label du champ
                // - le texte "__name__" qu'il contient par le numéro du champ
                var template1 = contain.attr('data-prototype')
            .replace(/__name__label__/g, 'INGREDIENT n°' + (ind + 1))
            .replace(/__name__/g, ind)
            ;

        // On crée un objet jquery qui contient ce template1
        var prototype1 = $(template1);

        // On ajoute au prototype1 un lien pour pouvoir supprimer la catégorie
        addDeleteLink1(prototype1, ind);

                // On ajoute le prototype1 modifié à la fin de la balise <div>
            contain.append(prototype1);

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            ind++;
        }

        // La fonction qui ajoute un lien de suppression d'une catégorie
            function addDeleteLink1(proto, ind) {
                // Création du lien
                var deleteLink1 = $('<a href="#" class="btn btn-danger">Supprimer ingrédient</a>');

            // Ajout du lien
            proto.append(deleteLink1);

            // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
                deleteLink1.click(function (e) {
                proto.remove();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            ind--;

            return false;
        });
    }

    //////////////////////////////////////////////////////
    //  AJOUT DES ETAPES ET DESCRIPTION DE LA RECETTE  //
    /////////////////////////////////////////////////////

            // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
            var $container = $('div#recipe_steps');

            // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
            var index = $container.find(':input').length;

            // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
            $('#add_step').click(function (e) {
                    addCategory($container);

                e.preventDefault(); // évite qu'un # apparaisse dans l'URL
                return false;
            });

            // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
            if (index == 0) {
                    addCategory($container);
                } else {
                    // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
                    $container.children('div').each(function () {
                        addDeleteLink($(this));
                    });
                }
    
    
                // La fonction qui ajoute un formulaire CategoryType
            function addCategory($container) {
                // Dans le contenu de l'attribut « data-prototype », on remplace :
                // - le texte "__name__label__" qu'il contient par le label du champ
                // - le texte "__name__" qu'il contient par le numéro du champ
                var template = $container.attr('data-prototype')
                    .replace(/__name__label__/g, 'ETAPE n°' + (index + 1))
                    .replace(/__name__/g, index)
                    ;
                // On crée un objet jquery qui contient ce template
                var $prototype = $(template);

                // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
                addDeleteLink($prototype);

                // On ajoute le prototype modifié à la fin de la balise <div>
                    $container.append($prototype);
    
                    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
                    index++;
                }
    
                // La fonction qui ajoute un lien de suppression d'une catégorie
            function addDeleteLink($prototype) {
                // Création du lien
                var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
    
                    // Ajout du lien
                    $prototype.append($deleteLink);
    
                    // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
                $deleteLink.click(function (e) {
                        $prototype.remove();

                    e.preventDefault(); // évite qu'un # apparaisse dans l'URL

                    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
                    index--;

                    return false;
                });
            }
        })
    </script>
                {% endblock %}