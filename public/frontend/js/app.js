$(document).ready(function () {


    // AOS Animation Scroll Librabry
    AOS.init();

    // Owl carousel
    function OwlPage (){
    if(isExist($(".owl-page")))
    {
        $(".owl-page").each(function(){
            OwlData($(this));
        });
    }
    /*if(isExist($(".owl-tieuchi")))
    {
        $('.owl-tieuchi').owlCarousel({
            rewind: true,
            autoplay: true,
            loop: true,
            lazyLoad: true,
            mouseDrag: true,
            touchDrag: true,
            smartSpeed: 250,
            autoplaySpeed: 1000,
            nav: false,
            dots: false,
            responsiveClass:true,
            responsiveRefreshRate: 200,
            responsive: {
                0: {
                    items: 2,
                    margin: 10
                },
                481: {
                    items: 3,
                    margin: 10
                },
                769: {
                    items: 3,
                    margin: 10
                }
            }
        });
    }*/
};

    function OwlData(obj){
    if(!isExist(obj)) return false;
    var xsm_items = obj.attr("data-xsm-items");
    var sm_items = obj.attr("data-sm-items");
    var md_items = obj.attr("data-md-items");
    var lg_items = obj.attr("data-lg-items");
    var xlg_items = obj.attr("data-xlg-items");
    var rewind = obj.attr("data-rewind");
    var autoplay = obj.attr("data-autoplay");
    var loop = obj.attr("data-loop");
    var lazyLoad = obj.attr("data-lazyload");
    var mouseDrag = obj.attr("data-mousedrag");
    var touchDrag = obj.attr("data-touchdrag");
    var animations = obj.attr("data-animations");
    var smartSpeed = obj.attr("data-smartspeed");
    var autoplaySpeed = obj.attr("data-autoplayspeed");
    var autoplayTimeout = obj.attr("data-autoplaytimeout");
    var dots = obj.attr("data-dots");
    var nav = obj.attr("data-nav");
    var navText = false;
    var navContainer = false;
    var responsive = {};
    var responsiveClass = true;
    var responsiveRefreshRate = 200;

    if(xsm_items != '') { xsm_items = xsm_items.split(":"); }
    if(sm_items != '') { sm_items = sm_items.split(":"); }
    if(md_items != '') { md_items = md_items.split(":"); }
    if(lg_items != '') { lg_items = lg_items.split(":"); }
    if(xlg_items != '') { xlg_items = xlg_items.split(":"); }
    if(rewind == 1) { rewind = true; } else { rewind = false; };
    if(autoplay == 1) { autoplay = true; } else { autoplay = false; };
    if(loop == 1) { loop = true; } else { loop = false; };
    if(lazyLoad == 1) { lazyLoad = true; } else { lazyLoad = false; };
    if(mouseDrag == 1) { mouseDrag = true; } else { mouseDrag = false; };
    if(animations != '') { animations = animations; } else { animations = false; };
    if(smartSpeed > 0) { smartSpeed = Number(smartSpeed); } else { smartSpeed = 800; };
    if(autoplaySpeed > 0) { autoplaySpeed = Number(autoplaySpeed); } else { autoplaySpeed = 800; };
    if(autoplayTimeout > 0) { autoplayTimeout = Number(autoplayTimeout); } else { autoplayTimeout = 5000; };
    if(dots == 1) { dots = true; } else { dots = false; };
    if(nav == 1)
    {
        nav = true;
        navText = obj.attr("data-navtext");
        navContainer = obj.attr("data-navcontainer");

        if(navText != '')
        {
            navText = (navText.indexOf("|") > 0) ? navText.split("|") : navText.split(":");
            navText = [navText[0],navText[1]];
        }

        if(navContainer != '')
        {
            navContainer = navContainer;
        }
    }
    else
    {
        nav = false;
    };

    responsive = {
        0: {
            items: Number(xsm_items[0]),
            margin: Number(xsm_items[1])
        },
        481: {
            items: Number(sm_items[0]),
            margin: Number(sm_items[1])
        },
        769: {
            items: Number(md_items[0]),
            margin: Number(md_items[1])
        },
        1025: {
            items: Number(lg_items[0]),
            margin: Number(lg_items[1])
        },
        1200: {
            items: Number(xlg_items[0]),
            margin: Number(xlg_items[1])
        }
    };

    obj.owlCarousel({
        rewind: rewind,
        autoplay: autoplay,
        loop: loop,
        lazyLoad: lazyLoad,
        mouseDrag: mouseDrag,
        touchDrag: touchDrag,
        smartSpeed: smartSpeed,
        autoplaySpeed: autoplaySpeed,
        autoplayTimeout: autoplayTimeout,
        dots: dots,
        nav: nav,
        navText: navText,
        navContainer: navContainer,
        responsiveClass: responsiveClass,
        responsiveRefreshRate: responsiveRefreshRate,
        responsive: responsive
    });

    if(autoplay)
    {
        obj.on("translate.owl.carousel", function(event){
            obj.trigger('stop.owl.autoplay');
        });

        obj.on("translated.owl.carousel", function(event){
            obj.trigger('play.owl.autoplay',[autoplayTimeout]);
        });
    }

    if(animations && isExist(obj.find("[owl-item-animation]")))
    {
        var animation_now = '';
        var animation_count = 0;
        var animations_excuted = [];
        var animations_list = (animations.indexOf(",")) ? animations.split(",") : animations;

        obj.on("changed.owl.carousel", function(event){
            $(this).find(".owl-item.active").find("[owl-item-animation]").removeClass(animation_now);
        });

        obj.on("translate.owl.carousel", function(event){
            var item = event.item.index;

            if(Array.isArray(animations_list))
            {
                var animation_trim = animations_list[animation_count].trim();

                if(!animations_excuted.includes(animation_trim))
                {
                    animation_now = 'animate__animated ' + animation_trim;
                    animations_excuted.push(animation_trim);
                    animation_count++;
                }
                
                if(animations_excuted.length == animations_list.length)
                {
                    animation_count = 0;
                    animations_excuted = [];
                }
            }
            else
            {
                animation_now = 'animate__animated ' + animations_list.trim();
            }
            $(this).find('.owl-item').eq(item).find('[owl-item-animation]').addClass(animation_now);
        });
    }
};


OwlPage ();


    if(isExist('#select__checkout')) {
        $('#select__checkout').change(function() {
            let formCheckout = $('.form__checkout');
            let btnCheckout = $('.btn-checkout');
            let optionValue = $(this).find("option:selected").val();
            if(optionValue === 'vnpay') {
                formCheckout.attr("action", "http://localhost/travelix_laravel/order/vnpay/store");
                btnCheckout.attr('name','redirect');
                btnCheckout.prop('disabled', false);

            }
            if(optionValue === 'normal') {
                formCheckout.attr("action", "http://localhost/travelix_laravel/order/checkout/store");
                btnCheckout.attr('name','btn-chekout');
                btnCheckout.prop('disabled', false);
            }
            if(optionValue === 'momo') {
                formCheckout.attr("action", "http://localhost/travelix_laravel/order/momo/store");
                btnCheckout.attr('name','payUrl');
                btnCheckout.prop('disabled', false);
            }
        });
    }

    if(isExist($('input[name="code"]'))) {
        $('input[name="code"]').keypress(function (e) {
            if($(this).val() !== null) {
                $('.btn-coupon').prop('disabled', false);
            }
        });
    }


    if(isExist($('.remove__cart'))) {
        $(document).on('click','.remove__cart', function () {
            let rowId = $(this).data('rowid');
                $.ajax({
                method: 'DELETE',
                url: `http://localhost/travelix_laravel/order/delete/${rowId}`,  
                data: {rowId:rowId, _token: $("input[name='_token']").val()},
                success: function (data) {
                $('.total').html(data);
                $('.cart__main-'+rowId).html(data);      
                return false; 
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }             
            });
        });
    }
    

    if(isExist($('.qty__cart'))) {
        $('.qty__cart').change(function() {
            let id = $(this).data('id');
            let price = $(this).data('price');
            let qty = $(this).val();
            let rowId = $(this).attr("rowID");
            $.ajax({
                url: "http://localhost/travelix_laravel/order/update_ajax",
                data: {rowId:rowId, price:price, qty:qty, _token: $("input[name='_token']").val(),},
                dataType: "JSON",
                method: "POST",
                success: function(data) {
                    $(".subtotal-"+id).text(data["subTotal"]);
                    $(".total").text(data["total"]);
                    return false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });
    }
});