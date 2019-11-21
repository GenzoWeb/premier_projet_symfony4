$(document).ready(function () {

    ///////////////////////////////////////////
    //  AJOUT DES INGREDIENTS DE LA RECETTE  //
    ///////////////////////////////////////////

    var $container = $('div#recipe_recipeIngredients');
    var index = $container.find(':input').length;

    $('#add_ingredient').click(function (e) {
        addCategory($container);
        e.preventDefault();
        return false;
    });

    if (index == 0) {
        for (var i = 0; i < 3; i++) {
            addCategory($container);
        }
    } else {
        $container.children('div').each(function () {
            addDeleteLink($(this));
        });
    }

    function addCategory($container) {
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/__name__/g, index)
            ;
        
        var $prototype = $(template);
        addDeleteLink($prototype);
        $container.append($prototype);
        
        var $container1 = $('div#recipe_recipeIngredients_' + index + '_ingredients');
        var template1 = $container1.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/__name__/g, index)
            ;

        var $prototype1 = $(template1);
        $container1.append($prototype1);
        $("#recipe_recipeIngredients legend:contains('Ingredients')").html("Nom de l'ingrédient :");
        var $blockRIIndex = $('div#recipe_recipeIngredients_' + index);
        $blockRIIndex.addClass("block-ingredients");
       

        var $blockNameIngredient = $('div#recipe_recipeIngredients_' + index + '_ingredients').parent();
        $blockNameIngredient.addClass("block-name-ingredient");
        var $inputNameIngredient = $('div#recipe_recipeIngredients_' + index + '_ingredients').children();
        $inputNameIngredient.addClass("input-name-ingredient");

        index++;
    }

    function addDeleteLink($prototype) {
        var $deleteLink = $('<i class="fas fa-times-circle" title="supprimer"></i>');
        $prototype.append($deleteLink);   

        $deleteLink.click(function (e) {
            $prototype.remove();
            e.preventDefault();
            //index--;
            return false;
        });
    }


    //////////////////////////////////////////////////////
    //  AJOUT DES ETAPES ET DESCRIPTION DE LA RECETTE  //
    /////////////////////////////////////////////////////

    var $containerStep = $('div#recipe_steps');
    var indexStep = $containerStep.find(':input').length;

    $('#add_step').click(function (e) {
        addCategoryStep($containerStep);
        e.preventDefault();
        return false;
    });

    if (indexStep == 0) {
        for (var i = 0; i < 3; i++) {
            addCategoryStep($containerStep);
        }
    } else {
        $containerStep.children('div').each(function () {
            addDeleteLinkStep($(this));
        });
    }

    function addCategoryStep($containerStep) {
        var template = $containerStep.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/__name__/g, indexStep)
            ;

        var $prototype = $(template);
        addDeleteLinkStep($prototype);
        $containerStep.append($prototype);
        var $blockRSIndex = $('div#recipe_steps_' + indexStep);
        $blockRSIndex.css({"float":"left"});

        indexStep++;
    }

    function addDeleteLinkStep($prototype) {
        var $deleteLink = $('<div class="deleteLinkStep"><i class="fas fa-times-circle" title="Supprimer"></i></div>');
        $prototype.append($deleteLink);

        $deleteLink.click(function (e) {
            $prototype.remove();
            e.preventDefault();
            indexStep--;
            return false;
        });
    }
})