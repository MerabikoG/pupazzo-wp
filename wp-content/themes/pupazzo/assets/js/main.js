$(document).ready(function () {
    $(document).scrollTop(0);
    var pageUrl = window.location.href;
    $('body').delay(300).show();


   //JS URL
    $("button.user-acc").on('click', function () {
        window.location.href = "/"+translate('პროფილი', 'account');
    });

    $(".sm-user").on('click', function () {
        window.location.href = "/"+translate('პროფილი', 'account');
    });

    $(".sm-cart").on('click', function () {
        window.location.href = "/"+translate('კალათა', 'cart');
    });

    $("button.favorite").on('click', function () {
        window.location.href = "/"+translate('ფავორიტები', 'favorites');
    });

    $(".sm-favorite").on('click', function () {
        window.location.href = "/"+translate('ფავორიტები', 'favorites');
    });
    
    $('.s-marker').on('click', function(){
        window.location.href = "/"+translate('კონტაქტი', 'contact');
    });
    
    $('.s-chat').on('click', function(){
        var win = "https://www.facebook.com/messages/t/Pupazzo.toys";
        window.open(win,'_blank');
    });

    //****************************************//

    //Sidebar Effect
    $('.s-phone').on('mouseover', function(){
       $(this).addClass('s-hovered');
 
    });
    
    $('.s-phone').on('mouseout', function(){
       $(this).removeClass('s-hovered');
    });

    //Show Cart Modal
    $("button.btn_cart").on('click', function () {
        var color = $(this).css('backgroundColor');
        color == 'rgb(27, 173, 162)' ?   $(this).css("background", 'rgba(0,0,0,0)') : $(this).css("background", 'rgb(27, 173, 162');

       $('.cart').toggle();
    });

    //Show Modal Menu List
    $('.mc-modal').on('mouseover', function () {
        var active_class = $(this).attr('class').split(' ')[1];

        var k = active_class.substr(active_class.length - 1);

        $('.menu'+k).css('display', 'block');
        $('li.menu-category').css('color', 'rgb(27, 173, 162');
        $('.cart').hide();
        $("button.btn_cart").css("background", 'rgba(0,0,0,0)');
                var saleText = $('.sale_h3');
        var productImg = $('img.cat-img');
        var productLink = $('.randProductLink');
            
        productImg.attr('src', '');
        productLink.attr('href', ""); 
        saleText.text('');
    });

    $('.mc-modal').on('mouseout', function () {
        var active_class = $(this).attr('class').split(' ')[1];

        var k = active_class.substr(active_class.length - 1);
        $('.menu'+k).css('display', 'none');
        $('li.menu-category').css('color', 'rgb(255, 255, 255');

    });

    $('.menu-modal').on('mouseover', function () {
        $(this).css('display', 'block');
        $('li.menu-category').css('color', 'rgb(27, 173, 162');
    });

    $('.menu-modal').on('mouseout', function () {
        $(this).css('display', 'none');
        $('li.menu-category').css('color', 'rgb(255, 255, 255');
    });


    //Sidebar hover effect
    $('.sidebar div').on('mouseover', function () {
       var img = $(this).find('img').attr('data-icon');
       $(this).find('img').attr('src', 'assets/images/icons/'+ img +'-cyan.png')
    });

    $('.sidebar div').on('mouseout', function () {
        var img = $(this).find('img').attr('data-icon');
        $(this).find('img').attr('src', 'assets/images/icons/'+ img +'.png')
    });



    //SM Menu sidebar slider
    $('.sm-menu-icon').on('click', function () {
        var wW = $(window).width();
        if( wW <= 425){
            $('.sm-menu-sidebar').width(wW-2);
        }else{
            wW = 400;
            $('.sm-menu-sidebar').width(wW-2);

        }
        $('.sm-menu-sidebar').css('display', 'block');

           $('#sm-header').addClass('opened');
           $('.sm-menu-sidebar').animate({
               'margin-left': '0px',
            'overflow-y': 'scroll'

           },800);
           $('body').not('footer').animate({
               'margin-left': wW+'px'
           }, 800);
            $('body').css('overflow', 'hidden');


    });

    $('.sm-m-close').on('click', function () {

        var wW = $(window).width();
        if( wW <= 425){
            $('.sm-menu-sidebar').width(wW-2);
        }else{
            wW = 400;
        }

        $('#sm-header').removeClass('opened');
        $('.sm-menu-sidebar').animate({
            'margin-left': -wW+'px'
        },800);
        $('body').not('footer').animate({
            'margin-left': '0px'
        }, 800);
        $('body').css('overflow-y', 'scroll');
    });

    $(window).resize(function(){
        var wW = $(window).width();

        $('#sm-header').removeClass('opened');
        $('.sm-menu-sidebar').css({
            'display': 'none',
            'margin-left': "-400px"
        });
        $('body').not('footer').css({
           'margin-left': '0px'
        });
        $('body').css('overflow-y', 'scroll');

        if(wW < 992){
            $('.p-p-header').css({
                'margin-bottom' : '50px',
                'display': 'block'
            });
            $('.p-p-wrapper').show();
        }


        $('#modal-filter').hide();
    });


    //Get RandProducts Limit 1 For each Category
    var products;
    (function randProduct(){
        $.ajax({
                type: "POST",
                url: "/ajax/ajax.php",
                data: {
                    randProduct : 1,
                },
                success: function(data){
                     try {
                        products = JSON.parse(data);
                    } catch(e) {
                        products = [];
                    }
                    
                }
        })
    })();
    
    //Show Subcategory Image on Modal Menu
    $('.menu2 .modal-submenu_list a').on('mouseover', function(){
        $('.carousel-indicators').hide()
        var cat_id = this.dataset.cat;
        
        var currProduct = products.filter(function(k,v){
            if(k.main_cat == cat_id)
                return k;
        });

        var saleText = $('.sale_h3');
        var productImg = $('img.cat-img');
        var productLink = $('.randProductLink');

        if(currProduct == false){
            productImg.attr('src', '');
            productLink.attr('href', ""); 
            saleText.text('');
        }else{
            productImg.attr('src', 'assets/images/products/'+currProduct[0].mainImage);
            productLink.attr('href', '/'+translate('პროდუქტი/', 'product/')+translate(currProduct[0].slug_ka,currProduct[0].slug )); 

            // var sale = Math.round(100 - (currProduct[0].sale_price * 100)/currProduct[0].price);
            // if(sale > 2){
            //     saleText.text("SALE "+ sale + "%");
            // }else{
                // }
                    saleText.text("");
        }

    });

    $('.menu-modal').on('mouseover', function(){
        $('.carousel-indicators').hide()
    })

    $('.menu-modal').on('mouseleave', function(){
        $('.carousel-indicators').show()
    })

    // Rollin Rollin
    var leftX = 0;
    function rollin(x, y){
        $('body').css('overflow-x', 'hidden');


        // 1 , 2
        $('.bottom-line-'+x).animate({
            'left': '100%'
        }, 20000 , function(){$('.bottom-line-'+x ).css('left', '-100%')});

        // 2 , 1
        $('.bottom-line-'+y).animate({
            'left': '0'
        }, 20000);
    };

    var x = 1;
    var y = 2;
    // rollin(1, 2);
    setInterval(function(){

        x = y;
        x == 1 ? y = 2 : y = 1;
        // rollin(x, y);

    }, 20000);



    $('button.owl-prev > span').text('').html('<img src="assets/images/icons/left-arrow.svg" />')
    $('button.owl-next > span').text('').html('<img src="assets/images/icons/right-arrow.svg" />')




    //Scroll action
    if($(window).height() > 900 && $(window).width() > 992){
        var pH = $(window).height()-$('header').height() - 75;
        var ppH = $('.p-p-header').height();
        $('.p-p-header').css('margin-top', (pH-ppH)/2 + 'px');
    }
        $(window).on( 'scroll', function(){
       // var wH = $('body').position().top;
       var wH = $('html,body').scrollTop();
       if(wH > 30){
            $('.p-p-wrapper').css({
                'display': 'block'
            });
            $('.p-p-header').animate({
                'margin-bottom' : '50px',
                'margin-top' : '0'
            }, 700);
       }
    });

        if($(window).width() < 992 ){
            $('.p-p-header').css({
                'margin-bottom' : '50px',
                'display': 'block'
            });
            $('.p-p-wrapper').show();
        }else{
            $('.p-p-header').css({
                'margin-bottom' : '500px',
                'display': 'block'
            });
        }



    //Selecting Category
    $('.p-w-c-m-list li').on('click', function(){
        $(this).toggleClass('p-w-active');

    });


     //Styling Accordion
    $('.p-w-c-m-header').on('click', function () {
       $('.p-w-c-m-header').removeClass('p-active');
       $(this).addClass('p-active');
    });


    //Toggle Additional Information
    $('.p-w-b-top button').on('click', function () {
        $('.p-w-b-top button').removeClass('i-h-active');
        $(this).addClass('i-h-active');

        $('.p-w-a-details').toggleClass('d-none');
    });


    //Change Product Quantity
    $('button.qty-count i').on('click', function () {

        if($(this).hasClass('fa-chevron-down')){
           var x = Number($(this).next('span').text());
           x != 1 ? x-- : x;
           $(this).next('span').text(x);
       }else{
            var x = Number($(this).prev('span').text());
            x != 10 ? x++ : x;
           $(this).prev('span').text(x);
       }
    });


    //Show Filter
    $('.p-p-filter button').on('click', function () {
       $('#modal-filter').show();
       $('body').css('overflow', "hidden").css("margin-left", '0');
        $('#sm-header').removeClass('opened');
        $('.sm-menu-sidebar').css({
            'display': 'none',
            'margin-left': "-400px",
        });
        // var offset;
        // var wW = $(window).width();
        // var wH = $(window).height();

        // var fH = $('#filter-accordion').height();

        // var p1 = Math.floor(fH / wH * 100);
        // var b = 140;

        // var p2 = Math.floor(b / wH * 100);

        // if(p1 + p2 < 100){
        //     offset = Math.floor((100-p1-p2) / 4);
        //     $('#filter-accordion').css('top', );
        //     $('.filter-bottom').css('bottom', offset+"%");

        //     $('.filter-bottom').css({
        //         'width' : '100%',
        //         'right' : '0',
        //         'top' : 'unset',
        //         'transform' : ' none',
        //         'bottom' : offset+"%"
        //     });

        //     $('#filter-price-slider').css({
        //         'width' : '50%',
        //         'margin-left' : '25%'
        //     });

        //     $('#filter-accordion').css({
        //         'width' : '100%',
        //         'left' : '50%',
        //         'transform' : 'translateX(-50%)',
        //         'top' : offset+"%"
        //     });
        // }else{
        //     $('.filter-bottom').css({
        //         'width' : '50%',
        //         'right' : '0',
        //         'top' : '50%',
        //         'transform' : 'translateY(-50%)',
        //         'bottom' : 'unset'
        //      });

        //     $('#filter-price-slider').css({
        //         'width' : '80%',
        //         'margin-left' : '10%'
        //     });

        //     $('#filter-accordion').css({
        //       'width' : '50%',
        //       'left' : '0',
        //         'transform' : 'none',
        //         'top' : '0'
        //     });
        // }
    });

    $('.f-a-wrapper li').on('click', function(){
        $(this).toggleClass('f-active');
    });

    //Close Filter
    $('.filter-close').on('click', function () {
        $('#modal-filter').hide();
        $('body').css('overflow-y', "scroll");
    });



    /*Dropdown Menu*/
    $('.dropdown-select').click(function () {
        $(this).attr('tabindex', 1).focus();
        // $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);
    });
    $('.dropdown-select').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });
    $('.dropdown-select .dropdown-menu li').click(function () {
        $(this).parents('.dropdown-select').find('span').text($(this).text());
        $(this).parents('.dropdown-select').find('input').attr('value', $(this).text());
        
        if($(this).parents('.dropdown-select').find('input').hasClass('s_count')){
            var link = window.location.search // + "&count=" + $(this).text()
            
            if(link.length == 0){
                window.location.href = window.location.href + "?count=" + $(this).text()
            }else{
                var x = window.location.search.split('?')[1].split('&')
                var newx = []
                let added = false;
                x.forEach(i => {
                    if(!added){
                        if(i.includes('count')){
                            var p = i.split('=')
                            i = p[0] + "=" + $(this).text()
                            added = true;
                        }else{
                            newx.push("count=" + $(this).text())
                            added = true;
                        }
                    }
                    
                    newx.push(i)
                })
                                
                window.location.href = window.location.pathname + "?" + newx.join('&')
            }
        }
        
        
    });
    /*End Dropdown Menu*/



    //Profile Tabs Switcher
    $('.u-p-switcher div').on('click', function () {

        var switcher = $('.switcher-blocks');

        $('.u-p-switcher div span').removeClass('u-p-active');
        $(this).find('span').addClass('u-p-active');

        if($(this).hasClass('order-b')){
            switcher.children().hide();
            switcher.find('.user-order-history').show();
        }else if($(this).hasClass('info-b')){
            switcher.children().hide();
            switcher.find('.user-profile-info').show();
        }else{
            switcher.children().hide();
            switcher.find('.user-profile-pass').show();
        }

    });


    //Add To Cart
    $(document).on('click','.add-to-cart', function () {
        var product_id = this.dataset.pid,
            user_id = this.dataset.uid,
            title = $(this).parent().parent().next('.p-p-title').find('span').text(),
            itemImage = $(this).parent().prev('.p-p-image').find('img').attr('src'),
            itemPrice1 = parseInt($(this).parent().parent().next().next('.p-p-price').find('.p-new-price').find('span').text()),
            itemPrice2 = parseInt($(this).parent().parent().next().next('.p-p-price').find('p-old-price').find('span').text()),
            itemPrice = itemPrice1 > itemPrice2 ? itemPrice2 : itemPrice1;

        var count = Number($('.badge').text());
        var xsCount = Number($('.xs-badge').text());


        $('.n-item-title').find('strong').text(title);
        $('.n-item-image img').attr('src', itemImage);

        $('.notification-alert').animate({
            'bottom' : "25px"
        }, 500);

        setTimeout(function () {
            $('.notification-alert').animate({
                'bottom' : "-150px"
            }, 500);
        }, 2500);

        var color = $('button.btn_cart').css('backgroundColor');
        color == 'rgb(27, 173, 162)' ?   $('button.btn_cart').css("background", 'rgba(0,0,0,0)') : $('button.btn_cart').css("background", 'rgb(27, 173, 162');
        $('.cart').show();
        $('.sm-cart').css("background", 'rgba(0,0,0,0)');

        $.ajax({
                   type: "POST",
                   url: "/ajax/ajax.php",
                   data: {
                       addToCart: 1,
                       product_id: product_id,
                       user_id: user_id
                   },
                   success: function (data) {
                        if(data != 1){
                            $('.cart-info').append(
                                '<div class="cart-products">\n' +
                                '                        <div class="product-pic">\n' +
                                '                            <img src="'+ itemImage +'" alt="">\n' +
                                '                        </div>\n' +
                                '                        <div class="product-info">\n' +
                                '                            <div class="product-name">\n' +
                                '                                <span>'+ title +'</span>\n' +
                                '                            </div>\n' +
                                '                            <div class="c-product-price">\n' +
                                '                                <span>'+ itemPrice +'₾</span>\n' +
                                '                            </div>\n' +
                                '                            <div class="product-quantity">\n' +
                                '                                <span> '+translate('რაოდენობა', 'QUANTITY')+': &nbsp; <span class="itemQty">1</span></span>\n'+
                                '                            </div>\n' +
                                '                        </div>\n' +
                                '                    </div>'
                            );
                            $('.badge').text(count+1);
                            $('.xs-badge').text(xsCount+1);
                            updateTotalPrice();
                            $('.cart-no-result').hide();

                        }else{
                            updateTotalPrice();
                        }
                   }
                });
    });

    //Update Total Price
    function updateTotalPrice(){
        var priceDivs = $('.product-info');
        var total = 0;
        for(var i = 0; i < priceDivs.length; i++){
            total += parseFloat($(priceDivs[i]).find('.c-product-price').find('span').text()) * parseInt($(priceDivs[i]).find('.product-quantity').find('span.itemQty').text());
        }

        $('.total-price').text(total.toFixed(2) + "₾");
    };

    updateTotalPrice();

    //Search
    $('.search-icon').on('click', function(){
        var q = $('input.search-input').val();

         window.location.href = '/'+translate('ძებნა', 'search')+'?q='+q;
    });
    
    //Search On Small Screen
    $('.sm-search-icon').on('click', function(){
        $("#sm-search").submit();
    });

    if(getCookie('language') != ""){
        if(getCookie('language') == "geo"){
            $('.lang-span').text("ENG");
        }else{
            $('.lang-span').text("GEO");
        }
    }
    
    
    $('.lang-span').on('click', function(){
        var lang = $(this).text().toLowerCase();
        
        setCookie('language', lang, 1);
        
        window.location.reload();
    })
    
        
    //Change Lang
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    
    //get Cookie
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    //Translate
    function translate(geo, eng){
       if(getCookie('language') != ""){
            if(getCookie('language') == "geo"){
                return geo;
            }else{
                return eng;
            }
       }     
       
       return geo;
    }
    
    $(".list_a").on("click",function(e){
        e.preventDefault();
        
        $(this).parent().find(".list_dropdownx").slideToggle();
    })
    



});







