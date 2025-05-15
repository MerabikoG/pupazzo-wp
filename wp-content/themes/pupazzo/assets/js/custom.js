(function (wp, $) {

  function translate(geo, eng) {
    if (getCookie('language') != "") {
      if (getCookie('language') == "geo") {
        return geo;
      } else {
        return eng;
      }
    }

    return geo;
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
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

  function updateTotalPrice() {
    var priceDivs = $('.product-info');
    var total = 0;
    for (var i = 0; i < priceDivs.length; i++) {
      total += parseFloat($(priceDivs[i]).find('.c-product-price').find('span').text()) * parseInt($(priceDivs[i]).find('.product-quantity').find('span.itemQty').text());
    }

    $('.total-price').text(total.toFixed(2) + "₾");
  }

  $(document).ready(function () {

    $('.owl-carousel').owlCarousel({
      items: 1,
      dots: true
    })

    //Add To Favorite
    $(document).on('click', '.add-to-favorites', function () {
      var product_id = this.dataset.pid,
        user_id = this.dataset.uid,
        title = $(this).parent().parent().next('.p-p-title').find('span').text(),
        itemImage = $(this).parent().prev('.p-p-image').find('img').attr('src');

      $.ajax({
        type: "POST",
        url: "/ajax/ajax.php",
        data: {
          addToFavorite: product_id,
          user_id: user_id
        },
        success: function (data) {

        }
      });

      $('.addToFavorite .n-item-title').find('strong').text(title);
      $('.addToFavorite').find('img').attr('src', itemImage);

      $('.addToFavorite').animate({
        'bottom': "25px"
      }, 500);

      setTimeout(function () {
        $('.addToFavorite').animate({
          'bottom': "-150px"
        }, 500);
      }, 2500);
    });
  })


  $('.categories-block .hasChild > a').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.hasChild').find('.children').toggleClass('d-none');
  })

  $('.menu-products').on('click', function (e) {
    e.preventDefault();
    $('.products-categories-menu').toggleClass('active');
  })

  // $('.slider-carousel-main').slick({
  //   slidesToShow: 1,
  //   slidesToScroll: 1,
  //   arrows: false,
  //   fade: true,
  //   asNavFor: '.slider-carousel'
  // });

  // $('.slider-carousel').slick({
  //   slidesToShow: 4,
  //   asNavFor: '.slider-carousel-main',
  //   focusOnSelect: true
  // });

  $('.show-filters').on('click', function (e) {
    e.preventDefault();

    $('.collapsed-on-mobile').toggleClass('show')
  })

  $('.p-w-active').closest('.children').removeClass('d-none')
  $('.p-w-active').closest('.hasChild').addClass('p-w-active')

  jQuery(document).ready(function (e) {
    function t(t) {
      e(t).bind("click", function (t) {
        t.preventDefault();
        e(this).parent().fadeOut()
      })
    }
    e(".dropdown-toggle").click(function () {
      var t = e(this).parents(".button-dropdown").children(".dropdown-menu").is(":hidden");
      e(".button-dropdown .dropdown-menu").hide();
      e(".button-dropdown .dropdown-toggle").removeClass("active");
      if (t) {
        e(this).parents(".button-dropdown").children(".dropdown-menu").toggle().parents(".button-dropdown").children(".dropdown-toggle").addClass("active")
      }
    });
    e(document).bind("click", function (t) {
      var n = e(t.target);
      if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-menu").hide();
    });
    e(document).bind("click", function (t) {
      var n = e(t.target);
      if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-toggle").removeClass("active");
    })
  });

})(window.wp, jQuery);

function initMap() {
  var uluru = {lat: 41.793220, lng: 44.755336};
  var map = new google.maps.Map(document.getElementById('map'), {zoom: 18, center: uluru});

  var icon = {
    url: "https://pupazzo.ge/assets/images/icons/logo-bear.svg", // url
    scaledSize: new google.maps.Size(40, 40), // scaled size
    origin: new google.maps.Point(0,0), // origin
    anchor: new google.maps.Point(0, 0) // anchor
  };
  var marker = new google.maps.Marker({
    position: uluru,
    icon: icon,
    map: map
  });
}