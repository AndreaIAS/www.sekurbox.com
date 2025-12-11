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
if (isset($_POST['iscrivimi'])) 
{	
	$email = $_POST['email'];
	$nome=$_POST['nome'];
	$cognome=$_POST['cognome'];
	
	$query = 'INSERT INTO clienti (email, nome, cognome) VALUES
	("' . mysql_real_escape_string($email) . '",
	"' . mysql_real_escape_string($nome) . '",
	"' . mysql_real_escape_string($cognome) . '")';

	if (mysql_query($query, $db))
		{
			if ($lingua=="it") 
			{
				$messaggio_inviato = "<p>Grazie per esserti iscritto alla nostra newsletter.</p>";
			}
			else
			{
				$messaggio_inviato="<p>Thank you for signing up to our newsletter.</p>";
			}
		}
	else
		{
			echo "<p>Registrazione non riuscita. Riprovare la procedura di registrazione. Grazie.</p>";
		}
}
?>
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
			agree: "required"
		},
		messages: {
			email: "<?php if ($lingua=="it") {echo "inserisci un indirizzo email valido"; } else {echo "please enter a valid email address";}?>",
			nome: "<?php if ($lingua=="it") {echo "inserisci il nome"; } else {echo "please insert your name";}?>",
			cognome: "<?php if ($lingua=="it") {echo "inserisci il cognome"; } else {echo "please insert your surname";}?>",
			agree: "<?php if ($lingua=="it") {echo "Accetta le note legali di questo sito"; } else {echo "accepts the legal notices on this site";}?>"
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
                    <div id="stile_titolo_pagina"><?php echo $iscriviti_newsletter; ?></div>
                	<div id="briciole_di_pane">
                    	<a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $iscriviti_newsletter; ?>
                    </div>                
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="newsletter"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                <div class="form">
                   <?php include 'include/form-newsletter.php'; ?>
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