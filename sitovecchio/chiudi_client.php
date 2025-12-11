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
        $testo="Il pagamento del tuo ordine non è andato a buon fine.<br /> Puoi sempre riprovare il pagamento cliccando  <a href='http://www.sekurbox.com/conferma_ordine.php?id_ordine=".trim($crypt->GetShopTransactionID())."'>qui</a> oppure sul link presente nella mail di riepilogo ordine.";
        break;

    case "KO":
        $testo="Il pagamento del tuo ordine non è andato a buon fine.<br /> Puoi sempre riprovare il pagamento cliccando  <a href='http://www.sekurbox.com/conferma_ordine.php?id_ordine=".trim($crypt->GetShopTransactionID())."'>qui</a> oppure sul link presente nella mail di riepilogo ordine.";  
        break;

    case "OK":
        $testo="Il pagamento del tuo ordine  è andato a buon fine.<br />Grazie per aver acquistato su Sekurbox.com ";
         break;
        
    default:
         $testo="Il pagamento del tuo ordine non è andato a buon fine.<br /> Puoi sempre riprovare il pagamento cliccando  <a href='http://www.sekurbox.com/conferma_ordine.php?id_ordine=".trim($crypt->GetShopTransactionID())."'>qui</a> oppure sul link presente nella mail di riepilogo ordine.";
                                
}

      

//}
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
                    <div id="briciole_di_pane"><a href="index.php">Home Page</a> / <?php echo $carrello;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row_content">
                    <div class="box_step_cassa">
                        <div class="box_step_cassa_spento"><?php echo $step_1;?></div>
                        <div class="box_step_cassa_spento"><?php echo $step_2;?></div>
                        <div class="box_step_cassa_acceso"><?php echo $step_3;?></div>
                  </div>  
                    
              
                        	<div id="ricevuta">
                    			<h2>Conferma pagamento</h2>
                                <p>
                             <?php echo  $testo; ?>
                                </p>
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

                   
                           	

