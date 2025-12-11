<?php 
include 'include/connessione.php';
include "include/lingua.php"; 

include 'include/leggi_immagine.inc.php';
			
if ($lingua == "it")
{
$title = "";
$description = "";
}
else
{
$title = "";
$description = "";
} 
include 'include/head.php'; 

if(!isset($_SESSION['user'])){ header("Location: http://www.sekurbox.com/".$lingua."/cassa-step-1.html");}
?>	
<script>
$(document).ready(function()
{
	$( '#nazione' ).change(function() 
	{
		var id = $(this).val();
		if (id!=106)
		{
			$('#provincia').hide();
		}
		else
		{
			$('#provincia').show();
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
			email: {
				required: true,
				email: true
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
			data_di_nascita:
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
			id_provincia:
			{
				required: true
			},			
			cap:
			{
				required: true,
				minlength: 2
			},																											
			agree: "required"
		},
		messages: {
			email: "<?php if ($lingua=="it") {echo "inserisci un indirizzo email valido"; } else {echo "please enter a valid email address";}?>",
			nome: "<?php if ($lingua=="it") {echo "inserisci il nome"; } else {echo "please insert your name";}?>",
			cognome: "<?php if ($lingua=="it") {echo "inserisci il cognome"; } else {echo "please insert your surname";}?>",
			data_di_nascita: "<?php if ($lingua=="it") {echo "inserisci la tua data di nascita"; } else {echo "enter your date of birth";}?>",
			ragione_sociale: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			partita_iva: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			codice_fiscale	: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",	
			indirizzo: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			citta: "<?php if ($lingua=="it") {echo "inserisci la tua citt&agrave;"; } else {echo "please insert your city";}?>",
			id_provincia: "inserisci la provincia",
			cap: "<?php if ($lingua=="it") {echo "inserisci il cap della tua citt&agrave;"; } else {echo "please insert zip code of your city";}?>",
			agree: "<?php if ($lingua=="it") {echo "Accetta le note legali di questo sito"; } else {echo "accepts the legal notices on this site";}?>"
		}
	});
});

$(document).ready(function(){

	$("#compare").hide();
	$("#altra_spedizione").click(function(){
	$("#compare").toggle();
	});
	
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
                    <div id="stile_titolo_pagina"><?php echo $carrello;?></div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $carrello;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row_content">
				<div class="box_step_cassa">
                	<div class="box_step_cassa_acceso"><?php echo $step_1;?></div>
                	<div class="box_step_cassa_spento"><?php echo $step_2;?></div>
                	<div class="box_step_cassa_spento"><?php echo $step_3;?></div>
                </div>
                <form id="signupForm" method="post" name='form' action="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-3.html">
                <div id="colonna_sn_form">
                    <div class="form">
                        <?php include 'include/form-1-step-2.php'; ?>
                    </div>
                    <div id="compare">
                        <div class="form">
                            <?php include 'include/form-2-step-2.php'; ?>
                        </div>
                    </div>
                </div> 
                 <div id="carrello_ds_fix">              
                    <div id="carrello_ds">
                        <div id="carrello_ds_intestazione"><?php echo $il_tuo_carrello;?></div>
                        <?php include 'include/carrello-destra.php'; ?>
                        <div id="carrello_ds_action">
                            <div id="continua"><input type="submit" value="<?php echo $continua;?>" name="continua" class="continua_step" /></div>
                        </div>
                    </div>
                </div>
               </form>	        
           </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
</body>
</html> 