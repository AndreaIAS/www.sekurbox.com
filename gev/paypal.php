<?php
include('inc_config.php');
$filename = BASE_PATH."log.txt";

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
 

$ordine_id=$item_number;       
        
$query_det = "SELECT * FROM bag_det_ord  
                  WHERE 
                  id_ordine = '".$ordine_id."' ";
    $result_det = mysql_query($query_det);
  $numero_fornitori=array();      
   while($list_det = mysql_fetch_array($result_det)){
    
     $numero_fornitori[]= $list_det['id_fornitore']; 
                                                       }

$array_fornitori=array_unique($numero_fornitori);
$numero_fornitori=count($array_fornitori);    

$queryfat="SELECT max(num_fattura) AS numfatt FROM bag_ordine WHERE YEAR(data)=YEAR(curdate())";
$resultfat=mysql_query($queryfat);
$listfat=mysql_fetch_array($resultfat);
$numfatt=$listfat['numfatt']+$numero_fornitori; 
$fatturaultima=$listfat['numfatt'];

    $query_order = "UPDATE bag_ordine SET 
                    stato_pagamento = '2',
                    num_fattura='".$numfatt."' 
                    WHERE id = '".$item_number."' ";
    $result_order = mysql_query($query_order);


	 $mail = new phpmailer(); 
     $mail->IsHTML(true);
     $mail->CharSet = 'UTF-8';
     $mail->AddEmbeddedImage('./img/logofin.png', 'my-photo', './img/logofin.png');
     $mail->AddEmbeddedImage('./img/servizo.png', 'servizio', './img/servizo.png');
     $testo_emailpri = "<a href='http://www.marestore.it'><img src='cid:my-photo' alt='Marestore.it' border='0' /></a><br /><br />"; 
     $mail->From = EMAIL_ADM;
     $mail->FromName = SITE_NAME;
    $mail->AddAddress($payer_email);
   // $mail->AddAddress('clapton_ci@yahoo.it');
    $mail->AddBCC('ordini@marestore.it');
     
     $mail->Subject = 'Marestore.it - Ricevuta pagamento ordine num: '.$item_number ;
     $testo="<span style='font-family:Arial,sans-serif;font-size:12px;'> 
     Abbiamo ricevuto il pagamento online per l'ordine num: ".$item_number." .<br />
     La ringraziamo per aver acquistato sul nostro sito. <br />
     Spediremo nel pi&ugrave; breve tempo possibile.<br /> <br />
     Questi i dati del pagamento:".$datiordine."<br /> <br /> <br />
     <div style='font-size:13px;width:200px;float:left;'>
     Sito Internet: <a style='color: #19a9e5;' href='http://www.marestore.it'>Marestore.it</a><br />
     Email: <a style='color: #19a9e5;' href='mailto:info@marestore.it'>info@marestore.it</a><br />
     Telefono: 3661715002</div>
     <div style='font-size:13px;width:300px;float:left;'>
     <a href='http://www.marestore.it'><img src='cid:servizio' alt='Marestore.it' border='0' width='300px;' /></a>
     </div></span>";
     $mail->Body = $testo_emailpri.$testo;
     $mail->Send();
     
    
     //FACCIO LE FATTURE
    $ordine_id=$item_number;
   
    $query_or = "SELECT bag_ordine.* FROM 
                  bag_ordine WHERE 
                  bag_ordine.id = '".$ordine_id."' ";
    $result_or = mysql_query($query_or);
    $list_or = mysql_fetch_array($result_or);



 require_once 'Classes/PHPExcel.php';  //INCLUDO LA CALSSE PER POTER MODIFICARE LA FATTURA



    $query_det = "SELECT * FROM bag_det_ord  
                  WHERE 
                  id_ordine = '".$ordine_id."' ";
    $result_det = mysql_query($query_det);
    $numero_fornitori=array();    
   while($list_det = mysql_fetch_array($result_det)){
    
     $numero_fornitori[]= $list_det['id_fornitore'];  
                                                       }
 
$array_fornitori=array_unique($numero_fornitori);
$numero_fornitori=count($array_fornitori);  

$contf=0;
foreach($array_fornitori AS $forn){$contf++;
    
       $queryforn="SELECT * FROM bag_fornitori WHERE id='".$forn."' ";
       $resultforn=mysql_query($queryforn);
       $listforn=mysql_fetch_array($resultforn);


$objReader = PHPExcel_IOFactory::createReader('Excel5');
//we load the file that we want to read
$objPHPExcel = $objReader->load("marestore.xls");


//CARICO LE IMMAGINI
$objDrawing = new PHPExcel_Worksheet_Drawing(); 
$objDrawing->setPath('logofatt.jpg');
$objDrawing->setCoordinates('C2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


$objDrawing = new PHPExcel_Worksheet_Drawing(); 
$objDrawing->setPath('fatpag.png');
$objDrawing->setCoordinates('A43');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    

$id_utente = $list_or['id_utente'];
    
    #Estraggo i dati dell'utente
    $query_ute = "SELECT bag_utenti.* FROM 
                  bag_utenti WHERE 
                  bag_utenti.id = '".$id_utente."' ";
    $result_ute = mysql_query($query_ute);
    $list_ute = mysql_fetch_array($result_ute);
    

$objRichText = new PHPExcel_RichText();
$objPayable = $objRichText->createTextRun('Nome/Ragione sociale:');

if($list_ute['ragione']!='') { $nomef=$list_ute['ragione'];} else { $nomef=$list_ute['cognome']." ".$list_ute['nome'];   }
$objRichText->createText(utf8_encode(" ".$nomef));

$objPayable->getFont()->setBold(true);
$objPayable = $objRichText->createTextRun('
Indirizzo:');
$objRichText->createText(utf8_encode(' '.$list_ute['indirizzo']));
$objPayable->getFont()->setBold(true);
$objPayable = $objRichText->createTextRun(utf8_encode('
Città:')
);
$objRichText->createText(utf8_encode(' '.$list_ute['citta'].' '.$list_ute['nazione']));
$objPayable->getFont()->setBold(true);
$objPayable = $objRichText->createTextRun('
Provincia:');
$objRichText->createText(utf8_encode(' '.$list_ute['provincia']));
$objPayable->getFont()->setBold(true);
$objPayable = $objRichText->createTextRun('
C.A.P.:');
$objRichText->createText(utf8_encode(' '.$list_ute['cap']));
$objPayable->getFont()->setBold(true);
$objPayable = $objRichText->createTextRun('
Telefono:');
$objRichText->createText(utf8_encode(' '.$list_ute['telefono']));
$objPayable->getFont()->setBold(true);
$objPayable = $objRichText->createTextRun('
P.IVA o CF:');
if($list_ute['p_iva']!=''){$objRichText->createText(utf8_encode(' '.$list_ute['p_iva']));}
else{ $objRichText->createText(utf8_encode(' '.$list_ute['cod_fiscale']));}
$objPayable->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getCell('D9')->setValue($objRichText);

$indsped=$nomef." ".$list_ute['indirizzo']." ".$list_ute['citta']." (".$list_ute['provincia'].") ".$list_ute['nazione']." CAP: ".$list_ute['cap']."  Tel: ".$list_ute['telefono']; 


$numerofattura=$fatturaultima+$contf;

if($numerofattura<10){ $numerofattura='0'.$numerofattura;} 
$objPHPExcel->getActiveSheet()
->setCellValue('B10',$numerofattura.'/M/'.date('Y'))
->setCellValue('B11',date('d/m/Y'));


if($list_or['prenotazione']!=0){
 $objPHPExcel->getActiveSheet()->setCellValue('B15',$array_nome_pag[$list_or['tipo_pagam']]." - Consegna su appuntamento");
                                    }
else {
 $objPHPExcel->getActiveSheet()->setCellValue('B15',$array_nome_pag[$list_or['tipo_pagam']]);
}



$objPHPExcel->getActiveSheet()->getStyle('D9')->getAlignment()->setWrapText(true);




#Vedo se dati sped sono diversi da dati fatt
   
if($list_or['nome']!='' && $list_or['cognome']!='') {
 
   

$objRichText = new PHPExcel_RichText();
$objPayable = $objRichText->createTextRun('Spedire a:');
$objPayable->getFont()->setBold(true);
$objPayable->getFont()->setSize(16);
$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_BLUE ) );
$objPHPExcel->getActiveSheet()->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getCell('A17')->setValue($objRichText);


$objPHPExcel->getActiveSheet()->getStyle('B17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('B17')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('C17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('D17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('E17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('F17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('G17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

$objPHPExcel->getActiveSheet()->getStyle('B17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('C17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('D17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('E17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('F17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('G17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$objPHPExcel->getActiveSheet()->getStyle('G17')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

$objPHPExcel->getActiveSheet()->mergeCells('B17:C17');
$objPHPExcel->getActiveSheet()->mergeCells('B17:D17');
$objPHPExcel->getActiveSheet()->mergeCells('B17:E17');
$objPHPExcel->getActiveSheet()->mergeCells('B17:F17');
$objPHPExcel->getActiveSheet()->mergeCells('B17:G17');

if($list_or['ragione']!=''){$nomefatt=$list_or['ragione'];} else{$nomefatt=$list_or['nome'].' '.$list_or['cognome']; }

$indsped=$nomefatt.' '.$list_or['indirizzo'].' '.$list_or['citta'].' ('.$list_or['provincia'].') '.$list_or['nazione'].' CAP: '.$list_or['cap'];

$objPHPExcel->getActiveSheet()->setCellValue('B17', utf8_decode($indsped));
$objPHPExcel->getActiveSheet()->getStyle("B17")->getFont()->setSize(13);


        }      


$cont=19; 

$totalesenzaiva=0;
$ivatotale=0;   
$totale=0;

$querydett = "SELECT bag_det_ord.*,bag_fornitori.id AS idforn
              FROM  bag_det_ord, bag_fornitori,bag_ordine
              WHERE bag_det_ord.id_ordine = '".$ordine_id."'
              AND bag_det_ord.id_fornitore = bag_fornitori.id 
              AND bag_ordine.id=bag_det_ord.id_ordine 
";   
$resultdett = mysql_query($querydett);
while ($listdett = mysql_fetch_array($resultdett )) {

//foreach($cart_items as $cart_item) {
    
if($listdett['id_fornitore']==$forn){
$cont++;    

$objPHPExcel->getActiveSheet()
->setCellValue('A'.$cont,$listdett['codice_forn'])
->setCellValue('B'.$cont,$listdett['descrizione'])
->setCellValue('C'.$cont,$listdett['qta'])
->setCellValue('D'.$cont,number_format($listdett['prezzo']/1.22,2,',','.'))
->setCellValue('F'.$cont,number_format(($listdett['prezzo']/1.22)*$listdett['qta'],2,',','.'))
->setCellValue('G'.$cont,'22%');

$totalesenzaiva=$totalesenzaiva+ (($listdett['prezzo']/1.22)*$listdett['qta']);
$totale=$totale+($listdett['prezzo']*$listdett['qta']);
$ivatotale=$totale-$totalesenzaiva;   

                                  }

                                     }

$cont++;   

$objPHPExcel->getActiveSheet()
->setCellValue('A'.$cont,'')
->setCellValue('B'.$cont,'Spese di spedizione')
->setCellValue('C'.$cont,1)
->setCellValue('D'.$cont,number_format(($list_or['spese_spe']/$numero_fornitori)/1.22,2,',','.'))
->setCellValue('F'.$cont,number_format(($list_or['spese_spe']/$numero_fornitori)/1.22,2,',','.'))
->setCellValue('G'.$cont,'22%');                       

for($a=20;$a<=47;$a++){
$objPHPExcel->getActiveSheet()->setCellValue('F'.$a,'=(C'.$a.'*D'.$a.')');  
   }
$totalesenzaiva=$totalesenzaiva+ (($list_or['spese_spe']/$numero_fornitori)/1.22);
$totale=$totale+($list_or['spese_spe']/$numero_fornitori);
$ivatotale=$totale-$totalesenzaiva; 
                                
$objPHPExcel->getActiveSheet()
->setCellValue('F49',number_format($totalesenzaiva,2,',','.'))
->setCellValue('F51',number_format($ivatotale,2,',','.'))
->setCellValue('F53',number_format($totale,2,',','.'))
;                     

$objPHPExcel->getActiveSheet()->setCellValue('F49','=SUM(F20:F47)');
$objPHPExcel->getActiveSheet()->setCellValue('F51','=(F49 *22)/100');
$objPHPExcel->getActiveSheet()->setCellValue('F53','=(F49+F51)');
              
$objPHPExcel->getActiveSheet()->getStyle("F53")->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->setCellValue('B56',$list_or['note']);
$objPHPExcel->getActiveSheet()->getStyle('B56')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getStyle("F49")->getNumberFormat()->setFormatCode('0.00');
$objPHPExcel->getActiveSheet()->getStyle("F51")->getNumberFormat()->setFormatCode('0.00');  
$objPHPExcel->getActiveSheet()->getStyle("F53")->getNumberFormat()->setFormatCode('0.00'); 

//we create a new file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//we save
$objWriter->save('fattura-'.$listforn['nome'].'.xls');



                                        
     $mail = new phpmailer(); 
     $mail->IsHTML(true);
     $mail->AddEmbeddedImage('./img/logofin.png', 'my-photo', './img/logofin.png');
     $mail->AddEmbeddedImage('./img/servizo.png', 'servizio', './img/servizo.png');
     $mail->AddAttachment('fattura-'.$listforn['nome'].'.xls');  
     $testo_emailpri = "<a href='http://www.marestore.it'><img src='cid:my-photo' alt='Marestore.it' border='0' /></a><br /><br />"; 
     $mail->From = EMAIL_ADM;
     $mail->FromName = SITE_NAME;
     $mail->AddAddress($listforn['email']);
     //$mail->AddAddress('clapton_ci@yahoo.it');
     $mail->AddBCC('ordini@marestore.it');
     $mail->Subject = 'Marestore.it - Dettaglio ordine n. '.$ordine_id;
     $testo_ord= "<span style='color:#000000;font-family:Arial,sans-serif;font-size:13px;'>"; 
     $testo_ord= "Gentile fornitore,<br /> le scriviamo qui in basso i dettagli del nuovo ordine n. ".$ordine_id." 
     effettuato sul nostro sito, e in allegato relativa fattura accompagnatoria da inserire nel pacco. <br /> <br />
     <b><span style='font-size:15px;'>Mail cliente per il tracking di bartolini:</span> </b> <br />
     ".$list_ute['email']."<br /><br />
     <b><span style='font-size:15px;'> Indirizzo di spedizione:</span> </b> <br />
     ".$indsped."<br /><br />
     <b><span style='font-size:15px;'>Metodo di pagamento:</span> </b> <br />
      Pagamento online con carta di credito/Paypal"; 
       $testo_ord.="  -> La fattura è stata pagata.<br /> <br />";

if($list_or['prenotazione']!=0){
 $testo_ord.="  <b><span style='font-size:15px;'>Attenzione, è stata richiesta la consegna su appuntamento: vedere le note ordine sulla fattura allegata.</span> </b><br /> <br />";    
                                    }
if($list_or['note']!=''){
  $testo_ord.="<b><span style='font-size:15px;'>Note ordine:</span> </b> <br />
     ".$list_or['note']."<br /><br />";
                         }
  
     $testo_ord.= "<br /><br /><br /><div style='font-size:13px;width:200px;float:left;'>
     Sito Internet: <a style='color: #19a9e5;' href='http://www.marestore.it'>Marestore.it</a><br />
     Email: <a style='color: #19a9e5;' href='mailto:info@marestore.it'>info@marestore.it</a><br />
     Telefono: 3661715002</div>
     <div style='font-size:13px;width:300px;float:left;'>
     <a href='http://www.marestore.it'><img src='cid:servizio' alt='Marestore.it' border='0' width='300px;' /></a>
     </div></span>";
     $mail->Body = $testo_emailpri.$testo_ord;
     if (!$mail->Send()) {}     	                          


                                           }
     
}

else if (strcmp ($res, "INVALID") == 0)
{
// log for manual investigation
    fwrite($handle, "\n\n".date("d-m-y H:i:s")."INVALID\n");
    $query_order = "UPDATE bag_ordine SET 
                    stato_pagamento = '3' 
                    WHERE id = '".$item_number."' ";
    $result_order = mysql_query($query_order);

     $mail = new phpmailer(); 
     $mail->IsHTML(true);
     $mail->AddEmbeddedImage('./img/logofin.png', 'my-photo', './img/logofin.png');
     $mail->AddEmbeddedImage('./img/servizo.png', 'servizio', './img/servizo.png');
     $testo_emailpri = "<a href='http://www.marestore.it'><img src='cid:my-photo' alt='Marestore.it' border='0' /></a><br /><br />"; 
     $mail->From = EMAIL_ADM;
     $mail->FromName = SITE_NAME;
     $mail->AddAddress($payer_email);
    $mail->AddBCC('ordini@marestore.it');
 //$mail->AddAddress('clapton_ci@yahoo.it');

     $mail->Subject = 'Marestore.it - Pagamento ordine num: '.$item_number.' non ricevuto' ;
     $testo="<span style='font-family:Arial,sans-serif;font-size:12px;'> 
     Il pagamento online per l'ordine num: ".$item_number ." non è andato a buon fine.<br />
     <b> La invitiamo a riprovare il pagamento cliccando <span style='color:blue'><a href='".BASE_URL."checkoutok.php&retry=".$item_number."'>qui</a></span>. </b> <br /><br />
     Questi i dati del pagamento: <br /> <br /> ". $datiordine. "<br /> <br /> <br />
     <div style='font-size:13px;width:200px;float:left;'>
     Sito Internet: <a style='color: #19a9e5;' href='http://www.marestore.it'>Marestore.it</a><br />
     Email: <a style='color: #19a9e5;' href='mailto:info@marestore.it'>info@marestore.it</a><br />
     Telefono: 3661715002</div>
     <div style='font-size:13px;width:300px;float:left;'>
     <a href='http://www.marestore.it'><img src='cid:servizio' alt='Marestore.it' border='0' width='300px;' /></a>
     </div></span>";
     $mail->Body = $testo_emailpri.$testo;
     $mail->Send();


}
}
fclose ($fp);
}

fwrite($handle, "\n\n".date("d-m-y H:i:s")."FINITO\n");
fclose($handle);
?>