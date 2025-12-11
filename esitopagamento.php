<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}
//if(!isset($_POST['metodosped'])){header("Location: ".BASE_URL."index.php");}


//require_once "GestPayCrypt.inc.php";
require_once "gestpay.php";

if (empty($_GET["a"])) {
    die("Parametro mancante: 'a'\n");
}

if (empty($_GET["b"])) {
    die("Parametro mancante: 'b'\n");
}

$crypt = new GestPayCrypt();

$crypt->setShopLogin($_GET["a"]);
$crypt->setEncryptedString($_GET["b"]);

if (!$crypt->decrypt()) {
    die("Error: ".$crypt->getErrorCode().": ".$crypt->getErrorDescription()."\n");
}

       //Estraggo numero transazione e invio email
        $db->query("SELECT * FROM bag_ordini WHERE id = '".trim($crypt->getShopTransactionID())."' ");
        $list=$db->single();

$esito='n';

switch ($crypt->getTransactionResult()) {
    
    case "XX":
        break;

    case "KO":
        break;

    case "OK":
    $esito='s';
    break;
        
    default:
        
}



include("inc_header.php");
?>

</head>
<body class="bg-body boxed">

<?php 
    include("inc_menu.php");  
?>
		
		<!-- BREAKCRUMB -->
		<section class="breakcrumb bg-grey">
			<div class="container">
				<h3 class="pull-left">Esito pagamento </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Esito pagamento</span></li>
				</ul>

			</div>
		</section>
		<!-- END BREAKCRUMB -->
		
		<!-- CHECK OUT -->
		<section class="check-out">
			<div class="container">
				<div class="check-out-cn">
					
					<!-- STEP CHECK OUT -->
					<ul class="check-out-step text-uppercase ">
						<li data-step="1" ><span>Esito pagamento</span></li>
						
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
					
                                            
                                        
                                            <div class="row" >
                                                   <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Esito pagamento ordine numero <?=$list['id'];?></b></label> 
					            </div>
                                                    <br /><br /><br />
                                                    <div class="col-xs-12" style="color:green;">
                                                      <?php if($esito=='s'){ ?>    
                                                        La ringraziamo per aver ordinato su Gevenit.com. <br />
                                                        Il suo ordine è stato pagato correttamente.  <br /> 
                                                        Spediremo nel più breve tempo possibile. <br />
                                                        
                                                     
                                               <?php } else { ?>
                                                        
                                                        Il pagamento dell'ordine non è andato a buon fine.
                                                        Clicca sul bottone qui in basso per riprovare.<br />
                                                      <br /><br />
                                                   
                                               <?php
                                                   //require_once "GestPayCrypt.inc.php";
                                                   require_once "gestpay.php";
                                                   $crypt = new GestPayCrypt();
                                                   // impostare i seguenti parametri
                                                   $crypt->setShopLogin('');
                                                   $crypt->setShopTransactionID($list['id']); // Identificativo transazione. Es. "34az85ord19"
                                                   $crypt->setAmount(number_format($list['totale'], 2, '.', '')); // Importo. Es.: 1256.50
                                                   $crypt->setCurrency("242"); // Codice valuta. 242 = euro

                                                   if (!$crypt->encrypt()) {
                                                    die("Errore: ".$crypt->getErrorCode().": ".$crypt->getErrorDescription()."\n");
                                                   }

                                                   ?>
                                                    <br /><br /><br />     
                                                    <form id="inviadati" action="https://ecomm.sella.it/gestpay/pagam.asp">
                                                    <input type="hidden" name="a" value="<?=$crypt->getShopLogin();?>" />
                                                    <input type="hidden" name="b" value="<?=$crypt->getEncryptedString();?>" />
                                                    <input type="image" src="<?=BASE_URL;?>images/pagaora.gif" />
                                                    </form>    
                                                    
                                                    
                                                   <?php  } ?>
			                       </div>
							
							<div class="col-xs-12" style="margin-top:20px;">
								<a href="<?=BASE_URL;?>ordini.php" class="btn btn-13 text-uppercase pull-right">I miei ordini</a>
							</div>
						</div>
                                         
					
					</div>
					<!-- END CHECK OUT FORM -->

				</div>
			</div>
		</section>
		<!-- END CHECK OUT -->

	
		
<?php
include("inc_footer.php");
?>

                