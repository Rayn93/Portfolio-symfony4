//STICKY MENU

$(window).scroll(function() {
    if ($(this).scrollTop() > 1){
        $('#header-top').addClass("sticky");
    }
    else{
        $('#header-top').removeClass("sticky");
    }
});


//Main function

$(document).ready(function () {



    //PREELOADER

    Pace.on("done", function(){
        $(".cover").fadeOut(2000);
    });

    //SCRIPTS FOR PROJECTS SUBPAGES

    if($('body').hasClass('projekty')){
        $('select').niceSelect();
    }


    // OSKRYPTOWANIE DLA MENU
    var $height = $(window).height();

    $("#header-top .traggle-menu").css("height", $height);

    $("#header-top .burger").click(function () {
        $(".traggle-menu").show("slide", { direction: "left" }, 500);
    });

    $(".close").click(function () {
        $(".traggle-menu").hide("slide", "right", 500);
    });

});


//PODMIANA KLASY PRZY SZEROKOŚCI OKNA 620PX DLA SEKCJI KATEGORIE
$(window).resize(function () {

    var width = $(window).width();
    if (width <= 767) {
        $("#cv .timeline li").removeClass("right").addClass("left")
    }

});





