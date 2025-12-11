<html>
<?php


include("inc_config.php");

//Leggo l'ID della transazione che mi ritorna gestpay nella variabile (b) che contiene il mio NUM_ORD

require_once "GestPayCrypt.inc.php";   

if (empty($_GET["a"])) {
    die("Parametro mancante: 'a'\n");
}

if (empty($_GET["b"])) {
    die("Parametro mancante: 'b'\n");
}

$crypt = new GestPayCrypt();

$crypt->SetShopLogin($_GET["a"]);
$crypt->SetEncryptedString($_GET["b"]);

if (!$crypt->Decrypt()) {
    die("Error: ".$crypt->GetErrorCode().": ".$crypt->GetErrorDescription()."\n");
}


switch ($crypt->GetTransactionResult()) {
    case "XX":
      
        break;

    case "KO":
    
        break;

    case "OK":

          $db->query("UPDATE bag_ordini SET pagato='s' WHERE id='".trim($crypt->GetShopTransactionID())."' "); 
          $db->execute(); 
          
          $testo_email= "<span style='color:#1e6ec3;font-family:Arial,sans-serif;font-size:15px;'>";
          $testo_email.= "<span style='color:#000000;'>Gentile cliente,<br />la ringraziamo per aver acquistato sul nostro sito, e la informiamo che abbiamo ricevuto il pagamento
              per il suo ordine numero ".trim($crypt->GetShopTransactionID())."</span><br /><br />";
         

          $testo_email.= "<br />
          <div style='font-size:13px;width:200px;float:left;'>
          Sito Internet: <a style='color: #19a9e5;' href='http://www.gevenit.com'>Gevenit.com</a><br />
          Email: <a style='color: #19a9e5;' href='mailto:gevenit@gevenit.com'>gevenit@gevenit.com</a><br />
          </div>
          </span>";


         $mail = new phpmailer(); 
         $mail->IsHTML(true);
         $mail->CharSet = 'UTF-8';
         $mail->From = EMAIL_ADM;
         $mail->FromName =EMAIL_ADM_NAME;
         $mail->AddAddress(mysql_escape_string($_SESSION['email']));
         $mail->AddBCC(EMAIL_ADM);
         $mail->Subject = "Gevenit.com - Pagamento ricevuto per ordine num: ".trim($crypt->GetShopTransactionID()).". ";
         $mail->Body = $testo_email;
         if (!$mail->Send()) {}
          
          
        break;
        
    default:
        
}



?>
</html>