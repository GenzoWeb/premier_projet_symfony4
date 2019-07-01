$(document).ready(function () {

    //////////////////////////////////////////////////////
    //  AJOUT DES INGREDIENTS DE LA RECETTE  //
    /////////////////////////////////////////////////////

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#recipe_recipeIngredients');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    console.log($container);
    console.log(index);

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ingredient').click(function (e) {
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
            .replace(/__name__label__/g, 'INGREDIENT n°' + (index + 1))
            .replace(/__name__/g, index)
            ;
        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        console.log('ici c\'est l\'index avant incrémentation ' + index);


        // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
        var $container1 = $('div#recipe_recipeIngredients_' + index + '_ingredients');
        var template1 = $container1.attr('data-prototype')
            .replace(/__name__label__/g, 'INGREDIENT n°' + (index + 1))
            .replace(/__name__/g, index)
            ;
        var $prototype1 = $(template1);
        $container1.append($prototype1);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;



        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
        var index1 = $container1.find(':input').length;

        console.log('Dans add category')
        console.log($container);
        console.log(index);
        console.log('ici nom ingrédient');
        console.log($container1);
        console.log(index1);
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


    //////////////////////////////////////////////////////
    //  AJOUT DES ETAPES ET DESCRIPTION DE LA RECETTE  //
    /////////////////////////////////////////////////////

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $containerStep = $('div#recipe_steps');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var indexStep = $containerStep.find(':input').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_step').click(function (e) {
        addCategoryStep($containerStep);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (indexStep == 0) {
        addCategoryStep($containerStep);
    } else {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        $containerStep.children('div').each(function () {
            addDeleteLinkStep($(this));
        });
    }


    // La fonction qui ajoute un formulaire CategoryType
    function addCategoryStep($containerStep) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $containerStep.attr('data-prototype')
            .replace(/__name__label__/g, 'ETAPE n°' + (indexStep + 1))
            .replace(/__name__/g, indexStep)
            ;
        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLinkStep($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $containerStep.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        indexStep++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLinkStep($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function (e) {
            $prototype.remove();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            indexStep--;

            return false;
        });
    }
})