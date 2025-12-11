<?php

include("inc_config.php");


if( !isset($_SESSION['user_site'])){
    header("Location: index.php");
}

$title_it="Sekurbox.com | Cambia Password.";
$description_it="Modifica la password dell'account.";


$title_en="Sekurbox.com | Modify account password.";
$description_en="Modify account password.";

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
                            <h1><?=$lang['cambia_pwd'];?></h1>
                            <ul>
                                <li><a href="#">Home</a> /</li>
                                <li><?=$lang['cambia_pwd'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Login Registration Page Area Start Here -->
        <div class="login-registration-page-area">
            <div class="container">
                <div class="row">
                  
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                     
                                   <?php                 
                                    $db->query("SELECT * FROM bag_utenti WHERE id='".$_SESSION['user_site']."' ");
                                    $list=$db->single();
                                    ?>   
                        
                        <div class="login-registration-field">
                            <h2 class="cart-area-title"><?=$lang['cambia_pwd'];?></h2>
                            
                <form id="checkout-form" action="javascript:void(null)" method="post" >
                                 
                          <input type="hidden" name="function" value="modifica_pwd" >
                      

                                
                            <label>Password attuale<sup>*</sup></label>
                            <input type="password"  name="password_attuale" id="password_attuale" class="input-text" required>

                            <label>Nuova Password<sup>*</sup></label>
                            <input type="password"  name="password" id="password2" class="input-text" required >

                            <label>Conferma nuova password<sup>*</sup></label>
                            <input type="password" name="confpass" class="input-text" data-equal-id="password2" required >
             
                             <br /><br />
                             <button class="btn-send-message disabled" type="submit" value="Login"><?=$lang['cambia_pwd'];?></button>
                            </form>
                             <div id="errmess"></div>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Registration Page Area End Here -->
        <!-- Footer Area Start Here -->
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
    
    
<script>
    
$(document).ready(function() {
    
      $('[data-equal-id]').bind('input', function() {
          var to_confirm = $(this);
         var to_equal = $('#' + to_confirm.data('equalId'));

            if(to_confirm.val() != to_equal.val())
                this.setCustomValidity('Le due password devono essere uguali');
            else
            { this.setCustomValidity(''); }
          });


    

    $("#checkout-form").submit(function(){  

         
         $.post("<?=BASE_URL;?>functionload.php",jQuery("#checkout-form").serialize(),              
              function(data) {    
                            $('#errmess').html('');
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                                 $('#errmess').html('<span style="color:red;margin-left:0px;">'+data.errore+'</span>');
                            }  
                             else {                                
                // alert(data.campo);
                $('#checkout-form').fadeOut();
                $('#errmess').html('<span style="color:green;margin-left:0px;">Modifica password effettuata correttamente.</span>');
                setTimeout(function(){window.location.href = "<?php echo BASE_URL;?>index.php";},7000);                                     
                               }                                              
                             },              
              "json");       
                  });
                  
           
 
});
$('.select2').select2({
            theme: 'classic',
            dropdownAutoWidth: true,
            width: '100%'
 });
</script>
    
</body>

</html>
