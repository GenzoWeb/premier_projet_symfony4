$(document).ready(function () {
    var count = $("#menu-list > li").length;
    var transY = "";
    var baseHeight = Math.ceil($('#menu').height());

    window.onresize = function () {
        var divMenu = Math.ceil($('#menu').height());

        if (document.body.clientWidth) {
            if (divMenu == baseHeight)
            {
                divSearchReset("0s");
            }

            if (($('#menu div').hasClass('show')) && (divMenu !== baseHeight)) 
            {
                divSearchDown("0s");
            }
        }
    }

    $('.navbar-toggler').click(function () {
        var divMenu = Math.ceil($('#menu').height());

        if (divMenu === baseHeight) {
            divSearchDown("0.35s");
        }

        if ($('#menu div').hasClass('show'))
        {
            divSearchReset("0.35s");
        }
    });

    function divSearchReset(duration)
    {
        transY = "translateY(0px)";
        $('#div-search').css({ "transform": transY, "transition-duration": duration });

    }

    function divSearchDown(duration)
    {
        if (count == 5) {
            transY = "translateY(200px)";
        }
        if (count == 6) {
            transY = "translateY(240px)";
        }
        if (count == 7) {
            transY = "translateY(280px)";
        }

        $('#div-search').css({ "transform": transY, "transition-duration": duration });
    }
})