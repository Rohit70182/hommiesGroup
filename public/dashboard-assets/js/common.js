$(document).ready(function () {
  // For Convert Bootstrap Navbar in Side Navbar
  $('.navbar-toggler').click(function(){
    $('#sidebar-nav').toggleClass('menu-show');
    $(this).toggleClass('collapsed');
    $('body').toggleClass('menu-open');
  });

  // Navbar Toggler Animation
  $('#nav-icon2').click(function(){
    $(this).toggleClass('open');
  });

  // Navbar Toggler Animation
  $('.SideBarToggler').click(function(){
    $('body').toggleClass('SideBarClose');
    $('#sidebar').toggleClass('sidebar-collaspe');
  });

});

$(window).resize( function() {
});
