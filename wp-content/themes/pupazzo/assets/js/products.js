$(document).ready(function () {
    var user_id = $('.add-to-cart').data('uid');

    var limit = 3;
    var o = 0;
    var p = $(".p-w-r-bottom");
    var offset = p.offset();
    if(window.location.href == 'http://demo.pupazzo.ge/%E1%83%9E%E1%83%A0%E1%83%9D%E1%83%93%E1%83%A3%E1%83%A5%E1%83%A2%E1%83%94%E1%83%91%E1%83%98' || window.location.href == 'https://demo.pupazzo.ge/products'){
        $(window).on("scroll", function() {

            var scrollHeight = offset.top + p.height() + 200;
            var scrollPosition = $(window).height() + $(window).scrollTop();
            if(scrollPosition > scrollHeight){
                o += 3;
                $.ajax({
                    type: "POST",
                    url: "ajax/ajax.php",
                    timeout: 3000,
                    async: false,
                    data:{
                        limitChange: limit,
                        o: o
                    },
                    success: function (data) {

                        data = JSON.parse(data);
                        if(data.length != 0) {
                            data.forEach(function (e, x) {
                                if(e.sale_price != "0" && e.sale_price != null){
                                    var sale_p = '<div class="p-new-price">\n'+
                                    '               <span>'+ e.sale_price +' GEL</span>\n'+
                                    '             </div>\n';
                                    var _price = '<div class="p-old-price">\n'+
                                    '                   <span>'+ e.price +' GEL</span>\n' +
                                    '              </div>\n';
                                    var pp = '<div class="p-p-sale"><span>-'+ Math.round(100-(e.sale_price*100)/e.price) +'%</span></div>';
                                    var dp = e.sale_price;
                                    var _noth =  '';
                                }else{
                                    var sale_p = '';
                                    var _price = '<div class="p-new-price">\n'+
                                    '               <span>'+ e.price +' GEL</span>\n'+
                                    '             </div>\n';
                                    var pp = "";
                                    var dp = e.price;
                                    var _noth =  '';
                                }
                                
                                
                                
                                if(e.isNew == 1){
                                    var _new = '<div class="p-p-new"><span>NEW</span></div>';
                                    var _noth =  '';
                                }else if(e.sale_price != "0"){
                                    var _noth =  '';
                                    var _new = ''; 
                                }else{
                                    var _new = ''; 
                                    var _noth = '<div class="p-p-nothing"></div>';
                                }
                                

                                if(user_id != 0){
                                    var atf = '<div class="atf-img atf"><img src="assets/images/icons/heart-cyan.svg" alt=""></div>';
                                }else{
                                    var atf = '<a href="/პროფილი"><div class="atf-img atf"><img src="assets/images/icons/heart-cyan.svg" alt=""></div></a>';
                                }


                                $('.p-w-r-bottom .row').append(
                                    '<div class="col-lg-4 col-md-6 p-b-product" data-price="'+ dp +'">\n' +
                                    '        <div class="p-p-box">\n' +
                                    '            <div class="p-p-info">\n' +
                                    pp + _new + _noth +
                                    '                <div class="p-p-image">\n' +
                                    '                    <a href="/პროდუქტი/'+ e.slug_ka +'">\n' +
                                    '                        <img src="assets/images/products/'+ e.mainImage +'" alt="">\n' +
                                    '                    </a>\n' +
                                    '                </div>\n' +
                                    '                <div class="p-p-action">\n' +
                                    '                    <div class="add-to-cart" data-pId="'+ e.id +'" data-uId="'+ user_id +'">\n' +
                                    '                        <div class="atc-img">\n' +
                                    '                            <img src="assets/images/icons/cart.svg" alt="">\n' +
                                    '                        </div>\n' +
                                    '                    </div>\n' +
                                    '                    <div class="add-to-favorites"  data-pId="'+ e.id +'" data-uId="'+ user_id +'">\n' +
                                    atf +
                                    '                    </div>\n' +
                                    '                </div>\n' +
                                    '            </div>\n' +
                                    '            <div class="p-p-title">\n' +
                                    '                <a href="/პროდუქტი/'+ e.slug_ka +'">\n' +
                                    '                    <span>'+ e.title_ka +'</span>\n' +
                                    '                </a>\n' +
                                    '            </div>\n' +
                                    '            <div class="p-p-price">\n' +
                                    sale_p + _price +  
                                    '            </div>\n' +
                                    '        </div>\n' +
                                    '    </div></div>'
                                )
                            });
                        }
                    }
                });
            }
        });
    }


    //SORTING
    var options = {
        'ყველა პროდუქტი' : 0,
        'ფასის ზრდადობით': 1,
        'ფასის კლებადობით': 2,
        'ფასდაკლებული': 3,
        'მხოლოდ ახალი': 4
    }
    
    $('#sort-by').on('click', function () {
        if(!$('.dropdown-select').hasClass('active')){
            var x = options[$('input[name="p_type"]').val()];
            if(x == 0){
                var a = window.location.href;
                a = a.split('?');
                window.location.href = a[0];
            }
            if(x == 1){
                var a = window.location.href;
                a = a.split('?');
                window.location.href = a[0]+"?price_asc="+x;
            }
            if(x == 2){
                var a = window.location.href;
                a = a.split('?');
                window.location.href = a[0]+"?price_desc="+x;
            }
            if(x == 3){
                var a = window.location.href;
                a = a.split('?');
                window.location.href = a[0]+'?sort='+ x;
            }
            if(x == 4){
                var a = window.location.href;
                a = a.split('?');
                window.location.href = a[0]+'?new='+ x;
            }

        }
    });


});