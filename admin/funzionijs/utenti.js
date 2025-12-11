jQuery(document).ready(function () {
   // jQuery('input:checkbox, input:radio, select.uniformselect, input:file').uniform();

   jQuery("#form_utenti").submit(

      function () {
         jQuery.post("functionload.php", jQuery("#form_utenti").serialize(),
            function (data) {
               //Se ci sono errori in fase di registrazione 
               if (data.errore != 'no') {
                  jQuery('#err_mess').html('<div style="color:red;">' + data.errore + '</div>').fadeIn(1000);
               }
               else {
                  jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);
                  setTimeout(function () { window.location.href = "utenti.php"; }, 1500);
               }
            },
            "json"
         );

      }
   );

});

