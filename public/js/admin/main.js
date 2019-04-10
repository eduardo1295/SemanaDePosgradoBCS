jQuery(function ($) {

  $(".sidebar-dropdown > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if ($(this).parent().hasClass("active")) {
      $(".sidebar-dropdown").removeClass("active");
      $(this).parent().removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this).next(".sidebar-submenu").slideDown(200);
      $(this).parent().addClass("active");
    }
  });

  var alterClass = function () {
    var ww = document.body.clientWidth;
    if (ww < 992) {
      $('#menuAd').removeClass('toggled');
    } /*else if (ww >= 768) {
      $('#menuAd').addClass('toggled');
    };*/
  };
  $(window).resize(function () {
    alterClass();
  });

  //Fire it when the page first loads:
  alterClass();

  //toggle sidebar overlay
  $("#overlay").click(function () {
    $(".page-wrapper").toggleClass("toggled");
  });


  $("#close-sidebar").click(function () {
    $(".page-wrapper").toggleClass("toggled");
  });

  $("#show-sidebar").click(function () {
    $(".page-wrapper").toggleClass("toggled");
  });

});