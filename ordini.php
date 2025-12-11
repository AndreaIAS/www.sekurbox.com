<?php

include("inc_config.php");


if( !isset($_SESSION['user_site'])){
    header("Location: index.php"); die(); exit();
}

$title_it="Sekurbox.com | I tuo ordini.";
$description_it="I tuoi ordini.";


$title_en="Sekurbox.com | Your orders.";
$description_en="Your orders.";

include("inc_header.php");
?>

<meta name="robots" content="noindex">
</head>
<body>
 <div class="wrapper-area">
        
    <?php  
    include("inc_menu.php");  
    
    ?>
      <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?=$lang['your_orders'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['your_orders'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
         <!-- Order History Page Area Start Here -->
        <div class="order-history-page-area">
            <div class="container">               
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="order-history-page-top table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td class="order-history-form-heading"><?=$lang['numero_ordine'];?></td>
                                        <td class="order-history-form-heading"><?=$lang['data_ordine'];?></td>
                                        <td class="order-history-form-heading"><?=$lang['totale'];?></td>
                                        <td class="order-history-form-heading"><?=$lang['pagato'];?></td>
                                        <td class="order-history-form-heading"><?=$lang['spedito'];?></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
    <?php   
    
    $db->query("SELECT * 
                 FROM 
                 bag_ordini
                 WHERE id_utente='".$_SESSION['user_site']."' 
                 ORDER BY data DESC
                ");
     $ordini = $db->resultset();

     foreach ($ordini AS $ordine){
         
         if($ordine['pagato']=='n'){$classe_pag='pending'; $testo_pag='No';} else {$classe_pag='complete'; $testo_pag=$lang['si'];}
         if($ordine['spedito']=='n'){$classe_sped='pending'; $testo_sped='No';} else {$classe_sped='complete'; $testo_sped=$lang['si'];}
     ?>
                                    <tr>                                        
                                        <td><a href="<?=BASE_URL;?>ordine.php?val=<?=$ordine['id'];?>">SK<?=$ordine['id'];?><i class="fa fa-paperclip" aria-hidden="true"></i></a></td>
                                        <td><?=date("d/m/Y", strtotime($ordine['data']));?></td>
                                        <td><?=number_format($ordine['totale'], 2, ',', '.');?></td>
                                        <td class="<?=$classe_pag;?>"><?=$testo_pag;?></td>
                                        <td class="<?=$classe_sped;?>"><?=$testo_sped;?></td>
                                    </tr>
     <?php } ?>                                 

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order History Page Area End Here -->
        
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
    <!-- Custom Js -->
    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
</body>

</html>
   