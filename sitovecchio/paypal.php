<?php
include 'include/connessione.php';
include "include/lingua.php";
$filename ="/web/htdocs/www.sekurbox.com/home/log.txt";

if (!$handle = fopen($filename, 'a'))
{
     $msg = "Cannot open file ($filename)<br>";
     die ($msg);
}

fwrite($handle, "\n\n".date("d-m-y H:i:s")."start\n");

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

fwrite($handle, "\n\n".date("d-m-y H:i:s")."req: $req\n");

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

$msg .= "
$req
<br><br>
item_name = $item_name
<br>
item_number = <b>$item_number</b>
<br>
payment_status = <b>$payment_status</b>
<br>
payment_amount= <b>$payment_amount</b>
<br>
payment_currency = <b>$payment_currency</b>
<br>
txn_id = <b>$txn_id</b>
<br>
receiver_email = <b>$receiver_email</b>
<br>
payer_email = <b>$payer_email</b>
<br>
";

$datiordine="<br><br>
Oggetto = $item_name
<br>
Numero ordine = <b>$item_number</b>
<br>
Stao del pagamento = <b>$payment_status</b>
<br>
Costo totale= <b>$payment_amount</b>
<br>
Valuta = <b>$payment_currency</b>
<br>
Id transazione = <b>$txn_id</b>
<br>
Mail ricevente = <b>$receiver_email</b>
<br>
Mail acquirente = <b>$payer_email</b>
<br>";

fwrite($handle, "\n\n".date("d-m-y H:i:s")."MSG: $msg\n");




if($payment_status=="Completed" OR $payment_status == "Pending"){


$id_ordine=$item_number;  


$query = "UPDATE ordini SET pagato = 1
	  WHERE id_ordine = '" . $id_ordine . "'";
$Risultato = mysql_query($query, $db);

$query_tr = "SELECT * FROM ordini WHERE id_ordine = '".$id_ordine."' ";
$result_tr = mysql_query($query_tr);
$list_tr = mysql_fetch_array($result_tr);

$subtotale_ordine=$list_tr['subtotale'];

$queryc="SELECT *
         FROM clienti
         WHERE id_cliente='".$list_tr['id_cliente']."' ";
$resultc=mysql_query($queryc) or die(mysql_error());
$listc=  mysql_fetch_assoc($resultc);

$id_cliente=$listc['id_cliente'];

//PARTE DI GESTIONE DEI PUNTI
$puntitotali=0;
$punti_a_rivenditore=0;
$puntiarivinst=0;


if($listc['id_tipologia_cliente']==3){
    
    $variabile_punti_rivenditore=10;   
    $puntitotali=$subtotale_ordine/$variabile_punti_rivenditore;
       
}else if($listc['id_tipologia_cliente']==2){
    
    $variabile_punti_installatore=5;   
    $puntitotali=$subtotale_ordine/$variabile_punti_installatore;
    
    if($puntiinstallatore=='si'){
    
    $variabile_punti_codice_da_rivenditore=5;
    $punti_a_rivenditore=$subtotale_ordine/$variabile_punti_codice_da_rivenditore;
    
    $queryriv = "SELECT id_cliente 
                 FROM clienti WHERE attivo='si' 
                 AND codice_per_installatore='".$listc['codice_sconto']."' ";
    $resultriv=mysql_query($queryriv) or die(mysql_error());
    $listriv=mysql_fetch_assoc($resultriv);
    
    $query = "UPDATE punti
              SET
              punti = punti + ".$punti_a_rivenditore."
              WHERE
              id_cliente = '". $listriv['id_cliente']."' ";
    mysql_query($query, $db) or (mysql_error($db));
        
    }
    
       
}else if($listc['id_tipologia_cliente']==1){
    
    $variabile_punti_privato=5;   
    $puntitotali=$subtotale_ordine/$variabile_punti_privato;
    
    if($puntiprivato=='si'){
    
    $variabile_punti_codice_da_rivenditore=5;
    $variabile_punti_codice_da_installatore=3;
    
    $queryriv = "SELECT id_cliente,id_tipologia_cliente 
                 FROM clienti WHERE attivo='si' 
                 AND codice_per_privato='".$listc['codice_sconto']."' ";
    $resultriv=mysql_query($queryriv) or die(mysql_error());
    $listriv=mysql_fetch_assoc($resultriv);
    
    if($listriv['id_tipologia_cliente']==2){ $puntiarivinst=$subtotale_ordine/$variabile_punti_codice_da_installatore;   }
    else if($listriv['id_tipologia_cliente']==3){ $puntiarivinst=$subtotale_ordine/$variabile_punti_codice_da_rivenditore;   }
    
    $query = "UPDATE punti
              SET
              punti = punti + ".$puntiarivinst."
              WHERE
              id_cliente = '". $listriv['id_cliente']."' ";
    mysql_query($query, $db) or (mysql_error($db));
        
    }
    
    
}


// AGGIORNAMENTO DELLA TABELLA PUNTI
$query = "UPDATE punti
          SET
          punti = punti + ".$puntitotali."
          WHERE
          id_cliente = '". $id_cliente."' ";

mysql_query($query, $db) or (mysql_error($db));


    
require "class/class.phpmailer.php";
        $messaggio = new PHPmailer();
	$messaggio->IsHTML(true);
	//$messaggio->Host='Host SMTP';
	//definiamo le intestazioni e il corpo del messaggio
	$messaggio->From='multimedia@gieffecomunicazione.com';
	$messaggio->FromName = "Sekurbox.com";
	//$messaggio->AddAddress($email);
        $messaggio->AddAddress('clapton_ci@yahoo.it');

	$messaggio->Subject='Conferma pagamento ordine numero '.$ordine_id;
	$messaggio->Body="Gentile cliente,<br /> le confermiamo che abbiamo ricevuto il pagamento per l'ordine numero ".$ordine_id." da lei effettuato sul nostro sito.<br />
                          La ringraziamo per aver acquistato su sekurbox.com .<br /><br /><br />
                          <div style='font-size:13px;width:200px;float:left;'>
     Sito Internet: <a style='color: #19a9e5;' href='http://www.sekurbox.com'>Sekurbox.com</a><br />
     Email: <a style='color: #19a9e5;' href='mailto:info@sekurbox.com'>info@sekurbox.com</a><br />
     Telefono: </div>
     <div style='font-size:13px;width:300px;float:left;'>
     <a href='http://www.sekurbox.com'><img src='cid:servizio' alt='sekurbox.com' border='0' width='300px;' /></a>
     </div>";
     if (!$messaggio->Send()) {}  
     
     
     
}



if (!$fp) {
// HTTP ERROR
    fwrite($handle, "\n\nHTTP ERROR\n");
} else {
fputs ($fp, $header . $req);

while (!feof($fp)) {
$res = fgets ($fp, 1024);

if (strcmp ($res, "VERIFIED") == 0)
{

fwrite($handle, "\n\nok ha preso VERIFIED\n");
 

   	                          


}
     


else if (strcmp ($res, "INVALID") == 0)
{
// log for manual investigation
    fwrite($handle, "\n\n".date("d-m-y H:i:s")."INVALID\n");
    

     $mail = new phpmailer(); 
     $mail->IsHTML(true);
     $mail->AddEmbeddedImage('./img/logofin.png', 'my-photo', './img/logofin.png');
     $mail->AddEmbeddedImage('./img/servizo.png', 'servizio', './img/servizo.png');
     $testo_emailpri = "<a href='http://www.marestore.it'><img src='cid:my-photo' alt='Marestore.it' border='0' /></a><br /><br />"; 
     $mail->From = EMAIL_ADM;
     $mail->FromName = SITE_NAME;
     $mail->AddAddress($payer_email);
     $mail->AddBCC('info@sekurbox.com');
 //$mail->AddAddress('clapton_ci@yahoo.it');

     $mail->Subject = 'Sekurbox.com - Pagamento ordine num: '.$item_number.' non ricevuto' ;
     $testo="<span style='font-family:Arial,sans-serif;font-size:12px;'> 
     Gentile cliente, il pagamento online per l'ordine num: ".$item_number ." non è andato a buon fine.<br />
     <b> La invitiamo a riprovare il pagamento cliccando <span style='color:blue'><a href='http://www.sekurbox.com/conferma_ordine.php?id_ordine=".$item_number."'>qui</a></span>. </b> <br /><br />
     Questi i dati del pagamento: <br /> <br /> ". $datiordine. "<br /> <br /> <br />
     <div style='font-size:13px;width:200px;float:left;'>
     Sito Internet: <a style='color: #19a9e5;' href='http://www.sekurbox.com'>Sekurbox.com</a><br />
     Email: <a style='color: #19a9e5;' href='mailto:info@sekurbox.com'>info@sekurbox.com</a><br />
     Telefono: </div>
     <div style='font-size:13px;width:300px;float:left;'>
     <a href='http://www.sekurbox.com'><img src='cid:servizio' alt='sekurbox.com' border='0' width='300px;' /></a>
     </div></span>";
     $mail->Body =$testo;
     $mail->Send();


}
}
fclose ($fp);
}

fwrite($handle, "\n\n".date("d-m-y H:i:s")."FINITO\n");
fclose($handle);
?>