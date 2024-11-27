$(document).ready(function () {
  // For Convert Bootstrap Navbar in Side Navbar
  $('.navbar-toggler').click(function () {
    $('#navbarNav').toggleClass('menu-show');
    $(this).toggleClass('collapsed');
    $('body').toggleClass('menu-open');
  });

  // Navbar Toggler Animation
  $('#nav-icon2').click(function () {
    $(this).toggleClass('open');
  });

});

new WOW().init();

// Header Fixed
$(window).on('load resize', function () {

});

$(window).on('scroll', function () {
  var sticky = $('.laundry-header-transparent'),
  scroll = $(window).scrollTop();
  if (scroll >= 250) {
    sticky.addClass('fixed');
  }
  else {
    sticky.removeClass('fixed');
  }
});
