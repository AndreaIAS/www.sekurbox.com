<?php 
include 'include/connessione.php';
require 'include/auth.inc.php';
include "include/lingua.php"; 
include 'include/leggi_immagine.inc.php';
			
if ($lingua == "it")
{
$title = "AREA RISERVATA IDM";
$description = "";
}
else
{
$title = "IDM RESTRICTED AREA";
$description = "";
} 
include 'include/head.php';
$email = $_SESSION['email'];

$Risultato_user=mysql_query("SELECT * FROM clienti WHERE id_cliente = '" . mysql_real_escape_string($_SESSION['user']) . "'", $db);
	if (!$Risultato_user)
	{
		die ("La tabella selezionata non esiste" . mysql_error());
	}
    
$riga_user=  mysql_fetch_assoc($Risultato_user);       
?>
<script>
$(document).ready(function(){
	
	$('#azienda').hide();
	$( '#id_tipo_cliente' ).change(function() 
	{
		var tipo = $('#id_tipo_cliente').val();
		if (tipo=="1")
		{
			$('#privato').show();
			$('#azienda').hide();
		}
		if (tipo=="2")
		{
			$('#azienda').show();
			$('#privato').hide();
		}	
	});		

	$('#id_nazione').change(function() 
	{
		var tipo = $('#id_nazione').val();
		if (tipo=="106")
		{
			$('#provincia').show();
		}
		else
		{
			$('#provincia').hide();
		}	
	});
	});	
</script>
<script src="http://www.sekurbox.com/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$().ready(function() {

	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
                      
                        codice_esterno: {
                            
                        remote: {url:"http://www.sekurbox.com/include/verificacodicesconto.php"  , 
                                 type: "post",
                                 data:{tipologia:"<?php echo $riga_user['id_tipologia_cliente'];?>" }
                                }
                        },
			email: {
				required: true,
				email: true,
                                remote: "http://www.sekurbox.com/include/verificaemail.php"
			},	
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},					 
			nome:
			{
				required: true,
				minlength: 2
			},
			cognome:
			{
				required: true,
				minlength: 2
			},
			
			ragione_sociale:
			{
				required: true,
				minlength: 2
			},
			partita_iva:
			{
				required: true,
				minlength: 2
			},
			codice_fiscale:
			{
				required: true,
				minlength: 2
			},										
			indirizzo:
			{
				required: true,
				minlength: 2
			},
			citta:
			{
				required: true,
				minlength: 2
			},
			cap:
			{
				required: true,
				minlength: 2
			}									
																					
		},
		messages: {
                
                       
                         codice_esterno: {
			
				remote: "<?php if ($lingua=="it") {echo "Codice sconto inesistente"; } else {echo "This discount code not exist";}?>"
			},
                         email: {
				required: "<?php if ($lingua=="it") {echo "inserisci un indirizzo email valido"; } else {echo "please enter a valid email address";}?>",
                        remote: "<?php if ($lingua=="it") {echo "Email gi&agrave; presente nei nostri registri"; } else {echo "Email address already exist";}?>"
			},
			
			password: {
				required: "<?php if ($lingua=="it") {echo "inserisci la password"; } else {echo "please enter password";}?>",
				minlength: "<?php if ($lingua=="it") {echo "deve essere lunga almeno 5 caratteri"; } else {echo "must be at least 5 characters";}?>"
			},
			confirm_password: {
				required: "<?php if ($lingua=="it") {echo "inserisci la password"; } else {echo "please enter password";}?>",
				minlength: "<?php if ($lingua=="it") {echo "deve essere lunga almeno 5 caratteri"; } else {echo "must be at least 5 characters";}?>",
				equalTo: "<?php if ($lingua=="it") {echo "inserisci la stessa password"; } else {echo "please enter the same passwords";}?>"
			},
			nome: "<?php if ($lingua=="it") {echo "inserisci il nome"; } else {echo "please insert your name";}?>",
			cognome: "<?php if ($lingua=="it") {echo "inserisci il cognome"; } else {echo "please insert your surname";}?>",
			ragione_sociale: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			partita_iva: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			codice_fiscale	: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",	
			indirizzo: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			citta: "<?php if ($lingua=="it") {echo "inserisci la tua citt&agrave;"; } else {echo "please insert your city";}?>",
			cap: "<?php if ($lingua=="it") {echo "inserisci il cap della tua citt&agrave;"; } else {echo "please insert zip code of your city";}?>"
					
			}
	});
});
</script>
<head>
<body>
<div id="contenuto">
	<div id="contenuto2">
    	<div id="top">
			<?php include 'include/top.php'; ?>
        </div>
        <div id="testata">
			<?php include 'include/testata.php'; ?>
        </div>
		<div class="row_top">
        	<div id="titolo_pagina_sn">
                <div id="titolo_pagina">
                    <div id="stile_titolo_pagina">Login</div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / Login</div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="login"; include 'include/menu-sn-area-riservata.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">              
                <div class="form">
                	<?php include 'include/form-modifica-dati.php'; ?>
                </div>
            </div>
      </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html>