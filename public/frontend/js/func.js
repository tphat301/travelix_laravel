function isExist(data) {
    return data.length;
}

function goTop() {
    /* Back To Top */
    $(window).scroll(function(){
    if($(this).scrollTop() > 100) $('.scrollToTop').fadeIn();
    else $('.scrollToTop').fadeOut();
    });

    $('body').on("click",".scrollToTop",function() {
        $('html, body').animate({scrollTop : 0},800);
        return false; 
    }); 
}

function chatFanpage() {
    /* Chat Facebook */
    $(".js-facebook-messenger-box").on("click", function(){
        $(".js-facebook-messenger-box, .js-facebook-messenger-container").toggleClass("open"), $(".js-facebook-messenger-tooltip").length && $(".js-facebook-messenger-tooltip").toggle()
    }), $(".js-facebook-messenger-box").hasClass("cfm") && setTimeout(function(){
        $(".js-facebook-messenger-box").addClass("rubberBand animated")
    }, 3500), $(".js-facebook-messenger-tooltip").length && ($(".js-facebook-messenger-tooltip").hasClass("fixed") ? $(".js-facebook-messenger-tooltip").show() : $(".js-facebook-messenger-box").on("hover", function(){
        $(".js-facebook-messenger-tooltip").show()
    }), $(".js-facebook-messenger-close-tooltip").on("click", function(){
        $(".js-facebook-messenger-tooltip").addClass("closed")
    }));
    $(".search_open").click(function(){
        $(".search_box_hide").toggleClass('opening');
    });
}

function preLoading() {
    $(window).on('load', function(event) {
        $('body').removeClass('preloading');
        // $('.loader').delay(1000).fadeOut('fast');
        $('.bx_loader').delay(500).fadeOut('fast');
    });
}
