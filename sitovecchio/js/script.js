// JavaScript Document
$(document).ready(function(){
   $(window).scroll(function(){
       if ($(this).scrollTop() > 250) {
           $('.scrolltotop').fadeIn();
       }
       else {
           $('.scrolltotop').fadeOut();
       }
});
$('.scrolltotop').click(function(){
       $("html, body").animate({ scrollTop: 0 }, 800);
       return false;
       });

$('.chiudi').show();
$('.apri').hide();	
    $('.chiudi').click(function(){
	  $('#modellini').animate({"height": "-=90px"}, "slow");
	  $('#modellini_sn2').hide();
	  $('.chiudi').hide();
	  $('.apri').show();
	  });    
    $('.apri').click(function(){
	  $('#modellini').animate({"height": "+=90px"}, "slow");
	  $('#modellini_sn2').show();
	  $('.apri').hide();
	  $('.chiudi').show();
	  });

//FINESTRA CARRELLO
$("#cart_open").hide();
 //al click sul trigger
 $(".numero_cart").click(
	function(){
    //faccio apparire il box precedentemente nascosto
    $("#cart_open").slideToggle();
    //setinterval crea un timer che esegue le operazioni in esso contenute
    setInterval(function() {
            },5000);
    });
//FINE FINESTRA CARRELLO 
});

$(document).ready(function() {
  var menu = $("#carrello_ds");
  var posizione = menu.position();

  // intercettiamo qui l'evento "scroll"                 
  $(window).scroll(function() {
    // "$(window).scrollTop()" ci dice di quanto abbiamo scrollato la pagina
    if ($(window).scrollTop() >= posizione.top) {
      // abbiamo scrollato oltre il div, dobbiamo bloccarlo
      menu.addClass("fixed");
    } else {
      // abbiamo scrollato verso l'alto, sopra il div, possiamo sbloccarlo
      menu.removeClass("fixed"); 
    }
  });
});
