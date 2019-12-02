$(document).ready(function () {
    var count = $("#menu-list > li").length;
    var transY = "";

    $('.navbar-toggler').click(function (e) {
        var divMenu = $('#menu').css("height");

        if (divMenu == '69px') {
            if (count == 5) {
                transY = "translateY(200px)";
            }
            if (count == 6) {
                transY = "translateY(240px)";
            }
            if (count == 7) {
                transY = "translateY(280px)";
            }

            $('#div-search').css({ "transform": transY, "transition-duration": "0.35s" });
        }

        if (divMenu == '269px' || divMenu == '309px' || divMenu == '349px') {
            transY = "translateY(0px)";
            $('#div-search').css({ "transform": transY, "transition-duration": "0.35s" });
        }
    });
})