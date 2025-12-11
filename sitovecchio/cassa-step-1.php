<?php 
include 'include/connessione.php';
include "include/lingua.php";
include 'include/leggi_immagine.inc.php';
 
if ($lingua == "it")
{
$title = "Prodotti Marss: Domotica, Sicurezza, TVCC e Fibra Ottica Plastica";
$description = "Scopri tutti i nostri prodotti e le nostre offerte sulla domotica, sicurezza, TVCC e sulla fibra ottica plastica";
}
else
{
$title = "Marss Products: Home Automation, Security, CCTV and Plastic Optical Fiber";
$description = "Discover all our products and our offers on home automation, security, CCTV and plastic optical fiber";
} 
include 'include/head.php'; 

//filtra i valori in arrivo
$email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'http://www.sekurbox.com/' . $lingua . '/cassa-step-2b.html';

if (isset($_POST['login_btn'])) {
	$query = "SELECT * FROM clienti WHERE email = '" . mysql_real_escape_string($email) . "' AND password = '" . mysql_real_escape_string($password) . "'";
	$result = mysql_query($query, $db) or die(mysql_error($db));
	if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
        $id_cliente = $row['id_cliente'];
        $_SESSION['email'] = $email;
        $_SESSION['logged'] = 1;
        $_SESSION['user']=$id_cliente;
        header ('Refresh: 2; URL=' . $redirect);
        echo '<center><p>Login effettuato con successo</p>';
		echo '<img src="http://www.sekurbox.com/Admin/img/loaders/1d_2.gif">';
        echo '<p>Se non visualizzi la pagina ' .
            	'<a href="' . $redirect . '">clicca qui</a></p></center>';
        mysql_free_result($result);
        mysql_close($db);
        die();
    } else {
        // set these explicitly just to make sure
        $_SESSION['email'] = '';
        $_SESSION['logged'] = 0;
        $_SESSION['admin_level'] = 0;

 $error = '<span class="userpass_errata">Hai inserito un Nome Utente o una Password errata.</span>';
    }
    mysql_free_result($result);
}
?>
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
				<div id="cassa_step_1_colonna_sn">
                	<div class="intesta_table_cassa_step_1"><?php echo $acquisto_veloce;?></div>
                    <div class="content_cassa_step_1_sn">
                    	<div class="content_cassa_step_1_action"><div id="continua"><a href="http://www.sekurbox.com/<?php echo $lingua;?>/registrati.html"><?php echo $registrati;?></a></div></div>
                    	<div class="content_cassa_step_1_testo"><?php echo $solo_dati_importanti;?></div>
                    </div>
                </div>
                <div id="cassa_step_1_colonna_ds">
                    <div class="intesta_table_cassa_step_1"><?php echo $clienti_registrati;?></div>
                     <div class="content_cassa_step_1_ds">
						<?php
							if (isset($error)) {
								echo $error;
							}
                        ?>
			<form method="post" action="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-1.html">
                        	<label>EMAIL</label>
                        	<input type="text" name="email" />
                        	<label>PASSWORD</label>
                        	<input type="password" name="password" />
                            <input type="hidden" name="redirect" value="<?php echo $redirect ?>"/>
                        <div class="content_cassa_step_1_pwd_dimenticata"><a href="http://www.sekurbox.com/<?php echo $lingua;?>/recupera-password.html"><?php echo $password_dimenticata;?></a></div>
                        <div class="content_cassa_step_1_entra"><input type="submit" class="entra" value="Accedi" name="login_btn" /></div>
                        </form> 
                   </div>
                   <div class="content_cassa_step_1_sn_sotto"><?php echo $desideri_registrarti;?></div>		
                </div>
             <div class="row">
                <?php include 'include/footer.php'; ?>
            </div>       
     	</div>                
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html> 