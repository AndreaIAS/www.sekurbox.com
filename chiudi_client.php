<?php

include("inc_config.php");

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


//echo '<pre>',print_r($crypt,1),'</pre>';
//die();

if (!$crypt->decrypt()) {
    die("Error: ".$crypt->getErrorCode().": ".$crypt->getErrorDescription()."\n");
}

// REDIRECT AI VARI SITI IN BASE ALLA TRANSAZIONE
$transactionId = $crypt->getShopTransactionID();

if (substr($transactionId, 0, 3) === "IPC") {
    //header("Location: https://www.marsscloud.com:14501/");
    header("Location: https://www.marsscloud.com/chiudi_server.php");
}

else if (substr($transactionId, 0, 3) === "MHS")
    header("Location: https://www.mahosy.com/");

$title_it="Sekurbox - Conferma pagamento";
$title_en="Sekurbox - Payment Confirmation";
$description_it="";
$description_en="";

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
                            <h1><?=$lang['conferma_pagamento'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['conferma_pagamento'];?></li>
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
                         <?php 
                         
                         if($crypt->getTransactionResult()=='OK'){ echo str_replace('[num_ord]',$crypt->getShopTransactionID(),$lang['pagamento_ok']);}
                         else{
                         
                          $id_ordine=$crypt->getShopTransactionID();
                          $costo=$crypt->getAmount();
                          
                         $crypt2 = new GestPayCrypt();
                         $crypt2->setShopLogin('9091587');
                         $crypt2->setShopTransactionID($id_ordine); // Identificativo transazione. Es. "34az85ord19"
                         $crypt2->setAmount($costo); // Importo. Es.: 1256.50
                         $crypt2->setCurrency("242"); // Codice valuta. 242 = euro
                         if (!$crypt2->encrypt()) {
                                die("Errore: ".$crypt2->getErrorCode().": ".$crypt2->getErrorDescription()."\n");
                         }
                         echo str_replace('[num_ord]',$id_ordine,$lang['pagamento_ko']); 
                         ?>
                            
                           <form id="inviadati" action="https://ecomm.sella.it/gestpay/pagam.asp">
                           <input type="hidden" name="a" value="<?=$crypt2->getShopLogin();?>" />
                           <input type="hidden" name="b" value="<?=$crypt2->getEncryptedString();?>" />
                           <input type="image" src="<?=BASE_URL;?>images/pagaadessoconcarta.jpg" />
                           </form>    
                             
                         <?php } ?>

                                              
                            
                        </div>
                    </div>
                </div>

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