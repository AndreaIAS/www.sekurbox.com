<?php

include("inc_config.php");
//
if(!isset($_SESSION['user_site'])){header("Location: ".BASE_URL."registrati.php");exit();die();}
if($cart->itemcount==0){ header("Location: ".BASE_URL.$lng."/");exit();die();} 

$title_it="Sekurbox - Conferma ordine";
$title_en="Sekurbox - Order Confirmation";
$description_it="";
$description_en="";


if(isset($_POST['sped_diverso'])){
    
    
    if($_POST['id_nazione']=='106'){
        
             $db->query("SELECT * 
                         FROM 
                         comuni
                         WHERE id='".$_POST['id_comune']."' 
                         ");

             $list_com = $db->single();
             
             $db->query("SELECT * 
                         FROM 
                         province
                         WHERE id='".$_POST['id_provincia']."' 
                        ");

             $list_prov = $db->single();  
             
    $nazionesped='Italia';         
    $cittasped=$list_com['nome'];
    $provsped=$list_prov['nome'];
    }else{
        
     $db->query("SELECT * 
                 FROM 
                 nazioni
                 WHERE id='".$_POST['id_nazione']."' 
                 ");

     $list_naz = $db->single();   
      
     $nazionesped=$list_naz['nome_'.$lng];  
     $cittasped="";
     $provsped="";   
        
    }       
    
    $nomesped=$_POST['nome'];
    $cognsped=$_POST['cognome'];
    $indsped=$_POST['indirizzo'];
    $capsped=$_POST['cap'];
    $mailsped=$_POST['email'];
    $telsped=$_POST['telefono'];
    $cellsped=$_POST['cellulare'];

}else{
    
     $db->query("SELECT * 
                 FROM 
                 bag_utenti
                 WHERE id='".$_SESSION['user_site']."' 
                 ");
     $list_ut = $db->single();    
     
     $db->query("SELECT * 
                 FROM 
                 comuni
                 WHERE id='".$list_ut['id_comune']."' 
                 ");

     $list_com = $db->single();

     $db->query("SELECT * 
                 FROM 
                 province
                 WHERE id='".$list_com['id_provincia']."' 
                ");

     $list_prov = $db->single();  
    
     $db->query("SELECT * 
                 FROM 
                 nazioni
                 WHERE id='".$list_ut['id_nazione']."' 
                 ");

     $list_naz = $db->single();
     
    $cittasped=$list_com['nome'];
    $provsped=$list_prov['nome'];
    $nazionesped=$list_naz['nome_'.$lng]; 
    $nomesped=$list_ut['nome'];
    $cognsped=$list_ut['cognome'];
    $indsped=$list_ut['indirizzo'];
    $capsped=$list_ut['cap'];
    $mailsped=$list_ut['email'];
    $telsped=$list_ut['telefono'];
    $cellsped=$list_ut['cellulare'];
}

if($_POST['metodo_sped']=='Corriere Bartolini' OR $_POST['metodo_sped']=='Corriere Gls'){$costo_sped=8;}else {$costo_sped=0;}
if($_POST['pay_metod']=='Carta di Credito' OR $_POST['pay_metod']=='Bonifico Bancario'){$costo_pay=0;}else {$costo_pay=0;}

$totale_ordine=((($cart->total/100)*22)+$cart->total)+$costo_sped+$costo_pay;

$db->query("INSERT INTO bag_ordini(id_utente,tipo_pagam,tipo_spedi,note,data,totale,spese_spe,spese_pag,email,
                                   cognome,nome,indirizzo,citta,cap,telefono,cellulare,provincia,spedito,pagato,nazione)
            VALUES('".$_SESSION['user_site']."','".$_POST['pay_metod']."','".$_POST['metodo_sped']."',:note,now(),'".$totale_ordine."',
                   '".$costo_sped."','".$costo_pay."','".$mailsped."','".$cognsped."','".$nomesped."','".$indsped."','".$cittasped."',
                   '".$capsped."','".$telsped."','".$cellsped."','".$provsped."','n','n','".$nazionesped."') 
          ");                   

$result = $db->execute(array('note' => $_POST['note_ordine'] )); 

$id_ordine=$db->lastInsertId();

foreach($cart->get_contents() as $item) { 
                             
    $db->query("INSERT INTO bag_det_ord(id_articolo,qta,prezzo,id_ordine)
                VALUES('".$item['id']."','".$item['qty']."','".$item['price']."','".$id_ordine."') 
               ");                   
    $result = $db->execute();  
} 

$cart->empty_cart();

//INVIO EMAIL CONFERMA ORDINE
$template_email = file_get_contents(BASE_URL."template-email.php?id_ordine=".$id_ordine);
//istanziamo la classe
$messaggio = new PHPmailer();
$messaggio->IsHTML(true);
$messaggio->SetLanguage("it", './php_mailer_language/');
//$messaggio->IsSMTP(); //Specify usage of SMTP Server
//$messaggio->Host = "smtps.aruba.it"; //SMTP+ Server address 
//$messaggio->Port="465";  //SET the SMTP Server port              
//$messaggio->Username = "info@sekurbox.com"; //SMTP+ authentication: username
//$messaggio->Password = ""; //SMTP+ authentication: password      
//$messaggio->SMTPAuth = true;  //Authentication required
//$messaggio->SMTPSecure = "ssl";
//$mail->SMTPDebug  = 1;
//$mail->SMTPSecure = 'tls';
$messaggio->CharSet = 'UTF-8';

//definiamo le intestazioni e il corpo del messaggio
$messaggio->From='info@sekurbox.com';
$messaggio->FromName = "Sekurbox";
$messaggio->AddAddress($_SESSION['email']);

//$mail->AddBCC('ippazio.martella@marss.eu');

$messaggio->Subject='Sekurbox.com - Conferma ordine numero SK'.$id_ordine;
$messaggio->Body=$template_email;
//$messaggio->AddAttachment('http://www.sekurbox.com/css/stile.css'); // attach style sheet

//definiamo i comportamenti in caso di invio corretto 
//o di errore
if(!$messaggio->Send()){ 
  echo $messaggio->ErrorInfo; 
}else{ 
}

include("inc_header.php");
?>

<meta name="robots" content="noindex">

</head>

<body>
 <div class="wrapper-area">
        
    <?php  
    include("inc_menu.php");  
    ?>
        <!-- Header Area End Here -->
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?=$lang['conferma_ordine'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['conferma_ordine'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inner Page Banner Area End Here -->
        <!-- Checkout Page Area Start Here -->
        <div class="checkout-page-area" style="padding-top:30px;">
            <div class="container">
             <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="order-sheet">
                        <?php echo str_replace(array('[num_ord]','[url]'),array($id_ordine,BASE_URL),$lang['testo_ordine_confermato']); ?>
                        
                        DETTAGLI PER IL PAGAMENTO:<br />
                        <?php
                        
                        if($_POST['pay_metod']=='Carta di Credito')
                        {
                               //require_once "GestPayCrypt.inc.php";
                               require_once "gestpay.php";
                               $crypt = new GestPayCrypt();
                               // impostare i seguenti parametri
                               $crypt->setShopLogin('9091587');
                               $crypt->setShopTransactionID('SK'.$id_ordine); // Identificativo transazione. Es. "34az85ord19"
                               $crypt->setAmount(number_format($totale_ordine, 2, '.', '')); // Importo. Es.: 1256.50
//                             $crypt->SetAmount(number_format(0.5, 2, '.', '')); 
                               $crypt->setCurrency("242"); // Codice valuta. 242 = euro

                               if (!$crypt->encrypt()) 
							   {
                                 die("Errore: ".$crypt->getErrorCode().": ".$crypt->getErrorDescription()."\n");
                               }

                               ?>

                               <form id="inviadati" action="https://ecomm.sella.it/gestpay/pagam.asp">
                               <input type="hidden" name="a" value="<?=$crypt->getShopLogin();?>" />
                               <input type="hidden" name="b" value="<?=$crypt->getEncryptedString();?>" />
                               <input type="image" src="<?=BASE_URL;?>images/pagaadessoconcarta.jpg" />
                               </form>
                                        
                            
                            
                        <?php }else if($_POST['pay_metod']=='Bonifico Bancario'){ 
                            
                               echo $lang['testo_pag_bon'];
                            
                        }

                        ?>
                        
                            
                            
                        </div>
                    </div>
                </div>
         
<!--                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pLace-order">
                            <button class="btn-send-message disabled" type="submit" > <?=$lang['acquista'];?></button>
                        </div>
                    </div>
                </div>-->
</form>

            </div>
        </div>
        <!-- Checkout Page Area End Here -->
        <!-- Footer Area Start Here -->
        <?php  
    include("inc_footer.php");  
     ?>  
        <!-- Footer Area End Here -->
    </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- jquery-->
    <script src="<?=BASE_URL;?>js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap js -->
    <script src="<?=BASE_URL;?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?=BASE_URL;?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?=BASE_URL;?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?=BASE_URL;?>js/wow.min.js" type="text/javascript"></script>
    <!-- Plugins js -->
    <script src="<?=BASE_URL;?>js/plugins.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="<?=BASE_URL;?>js/jquery.countdown.min.js" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?=BASE_URL;?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
    <!-- Select2 Js -->
    <script src="<?=BASE_URL;?>js/select2.min.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
    
        
</body>

</html>
