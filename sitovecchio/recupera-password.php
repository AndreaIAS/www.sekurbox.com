<?php 
include 'include/connessione.php';
include "include/lingua.php"; 			
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
include 'include/leggi_immagine.inc.php';
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
			}									
			},
		messages: {
			email: "Email errata"
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
                    <?php $pagina="login"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                    <div class="form">
		<?php
				if (isset($_POST['recupera'])) 
				{	
					$query = "SELECT * FROM clienti WHERE email = '" . mysql_real_escape_string($_POST['email']) . "'";	
					$Risultato=mysql_query($query, $db);
					if(mysql_num_rows($Risultato) == 0)
					{
						echo "<p><span class='inevidenza_errore'>";
						if ($lingua=="it") { echo "L'email da te indicata non &egrave; presente nel nostro database. <a href='http://www.sekurbox.com/it/recupera-password.html'>Riprova</a> o procedi alla<a href='http://www.sekurbox.com/it/registrati.html'> registrazione</a>"; }
						else {echo "The email address you specified does not exist in our database.<a href='http://www.sekurbox.com/uk/recupera-password.html'>Try again</a>
 or proceed to<a href='http://www.sekurbox.com/uk/registrati.html'>register</a>";}
						echo "</span></p>";
					}
					else
					{	
						while ($riga=mysql_fetch_array($Risultato))
						{
							$password=$riga['password'];
							$id_nazione=$riga['id_nazione'];
							$nome=$riga['nome'];
							$cognome=$riga['cognome'];
						}
						if ($id_nazione==106) 
						{ 
							$messaggio_utente='
							Gentile ' . $nome . ' ' . $cognome . '<br />
							la tua password è ' . $password . '';
						}
						else 
						{
							$messaggio_utente='
							Dear ' . $nome . ' ' . $cognome . '<br />
							your password is : ' . $password . '';
						}
						require 'class/PHPMailerAutoload.php';
						//Create a new PHPMailer instance
						$mail_utente = new PHPMailer();
						//Set who the message is to be sent from
						$mail_utente->setFrom('multimedia@gieffecomunicazione.com');
						//Set an alternative reply-to address
						$mail_utente->addAddress($_POST['email']);
						//Set the subject line
						$mail_utente->Subject = 'Recupero Password';
						//Read an HTML message body from an external file, convert referenced images to embedded,
						//convert HTML into a basic plain-text alternative body
						$mail_utente->msgHTML($messaggio_utente);
						//send the message, check for errors
						if (!$mail_utente->send())
						{
							echo "Mailer Error: " . $mail_utente->ErrorInfo;
						} 
						else	
						{	
							if ($lingua=="it") 
							{ 
								echo "<p><span class='inevidenza'>Ti abbiamo inviato la password sulla email da te indicata.</span></p>";
							}
							else
							{
								echo "<p><span class='inevidenza'>We have sent the password on the email address you specified.</span></p>";
							}
						}
					}
				}
				else
				{				
				?>	
                <form id="signupForm" method="post" action="http://www.sekurbox.com/<?php echo $lingua;?>/recupera-password.html">
    <div class="form_intestazione"><?php echo $recupera_password;?></div>
    <div class="form_row"><label>Email</label></div>                       
    <div class="form_row"><input type="text" name="email" /></div>
    <div class="form_row"></div>   
    <div class="form_row_button">
        <input class="entra" type="submit" value="<?php echo $recupera_password;?>" name="recupera" />              
    </div> 
</form>                        
<?php } ?>                       
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