$(document).ready(function(){
  if (window.location.pathname != '/') {
      $('.navbar-fixed-top').css("background-color", "#1F1F1F");
   }
   else {  
    $(window).bind('scroll', function() {
      var distance = $(window).height() - 100;
      if ($(window).scrollTop() >= distance) {
        $('.navbar-fixed-top').addClass('scrolled');
      }
      else {
        $('.navbar-fixed-top').removeClass('scrolled');
      }
    });

    $("#container").css("text-align", "center");
    // $("#header").css("background-color", "#000000");
   }
});