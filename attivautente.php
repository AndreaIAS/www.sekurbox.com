<?php

include("inc_config.php");


if(!isset($_REQUEST['active']) OR !isset($_REQUEST['user'])){
    header("Location: index.php");
}

$title_it="Sekurbox.com | Attivazione Account.";
$description_it="Attivazione Account.";


$title_en="Sekurbox.com | Account Activation.";
$description_en="Account Activation.";

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
                            <h1><?=$lang['account_act'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['account_act'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Login Registration Page Area Start Here -->
        <div class="login-registration-page-area" style="padding:50px 0px">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" style="font-size:16px;">
            <?php                
            
            $db->query("SELECT id FROM bag_utenti   WHERE email = '".$_REQUEST['user']."' AND chiave = '".$_REQUEST['active']."' "); 
            $result1= $db->resultset();
            $num_righe = $db->rowCount(); 
            if($num_righe ==0) {echo $lang['error_act1'];} 
            else{
            
                        $db->query("SELECT id FROM bag_utenti   WHERE email = '".$_REQUEST['user']."' AND chiave = '".$_REQUEST['active']."' AND attivo = 's'"); 
                        $result1= $db->resultset();
                        $num_righe = $db->rowCount(); 
                            if($num_righe >0){echo $lang['error_act2'];}
                        else {

                                    $db->query("UPDATE bag_utenti SET attivo = 's' WHERE email = '".$_REQUEST['user']."' AND chiave = '".$_REQUEST['active']."' "); 
                                    if($db->execute()){ 

                                    echo $lang['error_act_ok']; 

                                    } 

                        }
            
            }

            ?>
                                               </div>
                                    <br /> <br /> 
				</div>
			</div>
		</div>
		<!-- END LOGIN REGISTER -->

                             
<?php
include("inc_footer.php");
?>
    </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

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
    
      <?php include("script_condivisi.php"); ?>

    
</body>

</html>
               

                