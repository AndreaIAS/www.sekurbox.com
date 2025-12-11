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
if (isset($_POST['registrami'])) {	
$id_tipologia_cliente=$_POST['id_tipologia_cliente'];
$codice_sconto=$_POST['codice_esterno'];
$password = $_POST['password'];
$email = $_POST['email'];
$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$data_di_nascita='1981-12-12';
$data_di_nascita = date('Y-m-d', strtotime(str_replace('/', '-', $data_di_nascita)));
$codice_fiscale=$_POST['codice_fiscale'];
$ragione_sociale=$_POST['ragione_sociale'];
$partita_iva = $_POST['partita_iva'];
$indirizzo=$_POST['indirizzo'];
$citta=$_POST['citta'];
$id_provincia=$_POST['id_provincia'];
$id_nazione = $_POST['id_nazione'];
$id_regione = $_POST['id_regione'];
$cap=$_POST['cap'];
$telefono_fisso = $_POST['telefono_fisso'];
$telefono_cellulare = $_POST['telefono_cellulare'];
if($id_tipologia_cliente==2 OR $id_tipologia_cliente==3){$attivo='no';}else{$attivo='si';}
$attivo='si';
if($id_nazione==106) {$lingua_url="it";} else {$lingua_url="uk";}
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'http://www.sekurbox.com/'.$lingua_url.'/registrazione-confermata.html';


$query = 'INSERT INTO clienti (id_tipologia_cliente, password, email, nome, cognome, data_di_nascita, codice_fiscale, ragione_sociale, partita_iva, indirizzo, citta, id_provincia, id_nazione, id_regione, cap, telefono_fisso, telefono_cellulare,codice_sconto,attivo) VALUES
("' . mysql_real_escape_string($id_tipologia_cliente) . '",
"' . mysql_real_escape_string($password) . '",
"' . mysql_real_escape_string($email) . '",
"' . mysql_real_escape_string($nome) . '",
"' . mysql_real_escape_string($cognome) . '",
"' . mysql_real_escape_string($data_di_nascita) . '",
"' . mysql_real_escape_string($codice_fiscale) . '",
"' . mysql_real_escape_string($ragione_sociale) . '",
"' . mysql_real_escape_string($partita_iva) . '",
"' . mysql_real_escape_string($indirizzo) . '",
"' . mysql_real_escape_string($citta) . '",
"' . mysql_real_escape_string($id_provincia) . '",
"' . mysql_real_escape_string($id_nazione) . '",
"' . mysql_real_escape_string($id_regione) . '",
"' . mysql_real_escape_string($cap) . '",
"' . mysql_real_escape_string($telefono_fisso) . '",
"' . mysql_real_escape_string($telefono_cellulare) . '",
"' . mysql_real_escape_string($codice_sconto). '",   
"' .$attivo.'")';

if (mysql_query($query, $db))
    {
	//CREAZIONE CODICE CLIENTE
	$last_id = mysql_insert_id();
	
        if ($id_tipologia_cliente==1){
             
         $tipoutente='Privato';    
         }
	 if ($id_tipologia_cliente==2)
	{
        $tipoutente='Installatore'; 
	$codice_per_privato="P-".substr(md5(uniqid(mt_rand(), true)) , 0, 8).$last_id;
        $query_codice = 'UPDATE clienti SET codice_per_privato = "' . $codice_per_privato . '" WHERE id_cliente = "' . $last_id . '"';
	mysql_query($query_codice, $db);
	}
	else if ($id_tipologia_cliente==3)
	{
        $tipoutente='Rivenditore';    
	$codice_per_privato="P-".substr(md5(uniqid(mt_rand(), true)) , 0, 3).$last_id;
        $codice_per_installatore="I-".substr(md5(uniqid(mt_rand(), true)) , 0, 3).$last_id;
        $query_codice = 'UPDATE clienti SET codice_per_privato = "' . $codice_per_privato . '" WHERE id_cliente = "' . $last_id . '"';
	mysql_query($query_codice, $db);
        $query_codice = 'UPDATE clienti SET codice_per_installatore = "' . $codice_per_installatore . '" WHERE id_cliente = "' . $last_id . '"';
	mysql_query($query_codice, $db);
	}	
	
	
	




$query_punti_cliente = 'INSERT INTO punti (id_cliente, punti) VALUES
("' .$last_id . '",
"0")';
mysql_query($query_punti_cliente, $db);
	
	//EMAIL
	require 'class/PHPMailerAutoload.php';
	$date = date("d/m/Y H:i:s");
	
	//ALERT NUOVO UTENTE REGISTRATO
	$alert='
	Registrazione del ' . $date . '<br /> 
	--------------------------------------------------------<br />
        Tipologia Utente:' . $tipoutente . '<br /> 
	Nome: ' . $_POST['nome'] . '<br />
	Cognome: ' . $_POST['cognome'] . '<br />
	Email: ' . $_POST['email'] . '<br />
	--------------------------------------------------------<br />';
        
          if ($id_tipologia_cliente==1){
         
                 $alert.='CODICE SCONTO : ';
                 if($codice_sconto!='')  $alert.=$codice_sconto; else  $alert.=$nesscodi;
                 $alert.='<br />--------------------------------------------------------<br />';                     
          }
          
          if ($id_tipologia_cliente==2){
              
              $alert.='CODICE SCONTO : ';
              if($codice_sconto!='')  $alert.=$codice_sconto; else  $alert.=$nesscodi;
              $alert.='<br />';
              $alert.='<span style="color:red">Ricordati di attivare l\'utente dal panello</span><br />';
              $alert.='--------------------------------------------------------<br />';
              
              $alert.='CODICE PER PRIVATO : ' . $codice_per_privato . '
               <br />--------------------------------------------------------<br />'; }
   
         
          if ($id_tipologia_cliente==3){
              
           $alert.='CODICE PER PRIVATO : ' . $codice_per_privato . '<br />
           CODICE PER INSTALLATORE : ' . $codice_per_installatore . '<br />   
         <br />--------------------------------------------------------<br />'; 
         $alert.='<span style="color:red">Ricordati di attivare l\'utente dal panello</span><br />'; 
                                         }
         
	$alert.='<br />Registrazione utente eseguita sul sito http://www.sekurbox.com';
	
	//Create a new PHPMailer instance
	$mail_alert = new PHPMailer();
	//Set who the message is to be sent from
	$mail_alert->setFrom('info@sekurbox.com');
	//Set an alternative reply-to address
	//$mail_alert->addAddress('multimedia@gieffecomunicazione.com');
        $mail_alert->addAddress('info@sekurbox.com');
	//Set the subject line
	$mail_alert->Subject = 'Nuovo utente registrato';
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail_alert->msgHTML($alert);
	//send the message, check for errors
	if (!$mail_alert->send()){
	echo "Mailer Error: " . $mail_alert->ErrorInfo;
	} else {
    echo "Message sent!";
	}
	
	//EMAIL DI CONFERMA E INVIO DATI		
	if ($id_nazione==106) { 
	$messaggio_utente='
	Grazie per esserti registrato  (' . $date . ')<br />
	Conserva questa email con i tuoi dati per effettuare il login<br /> 
	--------------------------------------------------------<br />
	Email: ' . $_POST['email'] . '<br />
	Password: ' . $_POST['password'] . '
	<br />--------------------------------------------------------<br />';
        
            
         if ($id_tipologia_cliente!=3 AND $codice_sconto!=''){$messaggio_utente.='CODICE SCONTO : ' . $codice_sconto . '
         <br />--------------------------------------------------------<br />'; }
      
        
         if ($id_tipologia_cliente==2){$messaggio_utente.='CODICE PER PRIVATO : ' . $codice_per_privato . '
         <br />Inviando questo codice ad un utente registrato sul nostro sito come privato, gli permetterai di usufruire dei prezzi
         con lo sconto privato.<br /> Tu guadagnerai punti securbox ad ogni suo acquisto.<br />--------------------------------------------------------<br />'; }
         
          if ($id_tipologia_cliente==3){$messaggio_utente.='CODICE PER PRIVATO : ' . $codice_per_privato . '<br />
           CODICE PER INSTALLATORE : ' . $codice_per_installatore . '<br />   
         <br />Inviando uno di questi codici ad un utente registrato sul nostro sito come privato, o come installatore, gli permetterai di usufruire dei prezzi
         con lo sconto privato o installatore.<br /> Tu guadagnerai punti securbox ad ogni suo acquisto.<br >/
         --------------------------------------------------------<br />'; }
        
	
	$messaggio_utente.='www.sekurbox.com';
	}
	else {
	$messaggio_utente='
	Thank you for registering  (' . $date . ')<br />
	Keep this email with your details to login<br /> 
	--------------------------------------------------------<br />
	Email: ' . $_POST['email'] . '<br />
	Password: ' . $_POST['password'] . '';	
        
           
         if ($id_tipologia_cliente!=3 AND $codice_sconto!=''){$messaggio_utente.='DISCOUNT CODE : ' . $codice_sconto . '
         <br />--------------------------------------------------------<br />'; }
      
        
         if ($id_tipologia_cliente==2){$messaggio_utente.='CODE FOR USER PRIVATE  : ' . $codice_per_privato . '
         <br />--------------------------------------------------------<br />'; }
         
          if ($id_tipologia_cliente==3){$messaggio_utente.='CODE FOR USER PRIVATE : ' . $codice_per_privato . '<br />
           CODE FOR USER INSTALLER : ' . $codice_per_installatore . '<br />   
         <br />--------------------------------------------------------<br />'; }
	}
	//Create a new PHPMailer instance
	$mail_utente = new PHPMailer();
	//Set who the message is to be sent from
	$mail_utente->setFrom('info@sekurbox.com');
	//Set an alternative reply-to address
	$mail_utente->addAddress($_POST[email]);
       // $mail_utente->addAddress('clapton_ci@yahoo.it');
	//Set the subject line
	$mail_utente->Subject = 'Registrazione sul sito sekurbox.com';
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail_utente->msgHTML($messaggio_utente);
	//send the message, check for errors
	if (!$mail_utente->send()){
	echo "Mailer Error: " . $mail_utente->ErrorInfo;
	} else {
    echo "Message sent!";
	}
	//redirect to thank-you.html page.
	header("Location: " . $redirect);
    }
    else
    {
	echo "<p>Registrazione non riuscita. Riprovare la procedura di registrazione. Grazie.</p>";
	echo $query;
    }
}
?>
<script src="http://www.sekurbox.com/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$().ready(function() {

	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
                    
                        codice_esterno: {
                            
                        remote: {url:"http://www.sekurbox.com/include/verificacodicesconto.php"  ,
                                 type: "post",
                                 data:{tipologia:function() { return $('select[name=id_tipologia_cliente]').val()} }
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
			},																										
			agree: "required"
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
			data_di_nascita: "<?php if ($lingua=="it") {echo "inserisci la tua data di nascita"; } else {echo "enter your date of birth";}?>",
			ragione_sociale: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			partita_iva: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			codice_fiscale	: "<?php if ($lingua=="it") {echo "inserisci il tuo codice fiscale"; } else {echo "please insert your address";}?>",	
			indirizzo: "<?php if ($lingua=="it") {echo "inserisci il tuo indirizzo"; } else {echo "please insert your address";}?>",
			citta: "<?php if ($lingua=="it") {echo "inserisci la tua citt&agrave;"; } else {echo "please insert your city";}?>",
			cap: "<?php if ($lingua=="it") {echo "inserisci il cap della tua citt&agrave;"; } else {echo "please insert zip code of your city";}?>",
			agree: "<?php if ($lingua=="it") {echo "Accetta le note legali di questo sito"; } else {echo "accepts the legal notices on this site";}?>"
		}
	});
});

$(document).ready(function(){
	
	$('#azienda').hide();
	$( '#id_tipologia_cliente').change(function() 
	{
		var tipo = $('#id_tipologia_cliente').val();
		if (tipo=="1")
		{
			$('#privato').show();
			$('#codice').show();
			$('.codice_label').html('Hai un codice venditore o installatore?');
			$('#azienda').hide();
		}
		if (tipo=="2")
		{
			$('#azienda').show();
			$('#privato').hide();
			$('#codice').show();
			$('.codice_label').html('Hai un codice rivenditore? Inseriscilo, altrimenti richiedilo. Puoi inserirlo anche in seguito');
		}
		if (tipo=="3")
		{
			$('#azienda').show();
			$('#privato').hide();
			$('#codice').hide();
		}			
	});		

	$('#id_nazione').change(function() 
	{
		var id_nazione = $('#id_nazione').val();
		if (id_nazione=="106")
		{
			$('#provincia').show();
			$('#regione').show();
		}
		else
		{
			$('#provincia').hide();
			$('#regione').hide();
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
                    <div id="stile_titolo_pagina"><?php echo $registrati;?></div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $registrati;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="registrati"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                <div class="form">
                    	<?php include 'include/form-registrazione.php'; ?>
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