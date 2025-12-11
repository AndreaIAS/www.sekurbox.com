<?php

include("inc_config.php");

$title_it="Sekurbox.com | Recupera password.";
$description_it=" Recupera password. ";


$title_en="Sekurbox.com | Password recovery.";
$description_en=" Password recovery. ";

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
                            <h1><?=$lang['recupera_pwd'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['recupera_pwd'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Login Registration Page Area Start Here -->
        <div class="login-registration-page-area" style="padding-top:20px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="login-registration-field">
                           
                            
                          <?php 
                                $avviso=""; 
                                $invio='ko';
                                if(isset($_POST['email'])){
                                    
                                 $db->query("SELECT id FROM bag_utenti  WHERE email = '".$_POST['email']."' AND attivo = 's'  "); 
                                 $result1= $db->resultset();
                                 $num_righe = $db->rowCount();    
                                     if($num_righe==0){  
                                         $avviso="<br />".$lang['err_rec_pwd'];  
                                     ?>
                                        <br />   
 
                                   <?php } else {
                                       
                                       $newpwd=Codicerandom(8);
                                       
                                       $db->query("UPDATE bag_utenti SET password='".md5($newpwd)."' WHERE email = '".$_POST['email']."' "); 
                                       $list= $db->execute();
  
                                       
                                    $testo_email = "<span style='color:#000000;font-family:Arial,sans-serif;font-size:15px;'>";
                                    $testo_email = "Abbiamo generato una nuova password, di seguito troverai i dati per accedere al tuo account:<br /><br />";
                                    $testo_email.= "E-mail: ".$_POST['email']."<br />";
                                    $testo_email.= "Password: ".$newpwd."<br />";
                                     $testo_email.= "<br /><br /><br />
                                     <div style='font-size:13px;width:200px;float:left;'>
                                     Sito Internet: <a style='color: #19a9e5;' href='http://www.sekurbox.com'>Sekurbox.com</a><br />
                                     Email: <a style='color: #19a9e5;' href='mailto:info@sekurbox.com'>info@sekurbox.com</a><br />
                                     </div></span>";
                                     $mail = new phpmailer(); 
                                     $mail->IsHTML(true);
                                     $mail->From = EMAIL_ADM;
                                     $mail->FromName = EMAIL_ADM_NAME;
                                     $mail->AddAddress(mysql_escape_string($_POST['email']));
                                     $mail->Subject = "Richiesta reinvio password";
                                     $mail->Body = $testo_email;
                                     if ($mail->Send()) {  $avviso="<br />".$lang['okpwd']; $invio='ok';  }
                                     else{$avviso= "<br /><span style='color:red'>Problema di invio mail. Contattaci.</span>";} 
                                       
                                        
                                   }
                                
                                }
                              ?>
                                	

                               <?=$lang['testo_smarrita'];?>
                                <?=$avviso;?> 
                                <?php if($invio=='ko'){ ?>        
                                <form id="form_login" action="<?=BASE_URL;?>recuperapwd.php" method="post" >
                                <input type="hidden" name="function" value="login" >
                                <label>EMAIL *</label>
                                <input type="email" name="email" required placeholder="E-mail" />
                                <button class="btn-send-message disabled" type="submit" value="Login">Recupera</button>
<!--                            <span><input type="checkbox" name="remember"/>Remember Me</span>-->
                                </form>
                                <?php } ?>        
                            
                            
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
                this.setCustomValidity('');
          });

    $("#tipologia").change(function(){ 

         if($('#tipologia option:selected').val()=='privato') {           
                 $('#divragsoc').fadeOut();
                 $('#ragione').prop('required',false);
                 $('#divpiva').fadeOut();
                 $('#p_iva').prop('required',false);
                 $('#divcodfisc').fadeIn(); $('#cod_fiscale').prop('required',true);                  
              }
                                                                    
         else  {  $('#ragsoc').fadeIn();
                  $('#divragsoc').fadeIn();$('#ragione').prop('required',true);
                  $('#divcodfisc').fadeOut();$('#cod_fiscale').prop('required',false);
                  $('#divpiva').fadeIn();$('#p_iva').prop('required',true); 
               }
    });
    
    $("#id_nazione").change(function(){ 

         if($('#id_nazione option:selected').val()==106) {        
                 $('#div_reg').fadeIn();
                 $('#id_regione').prop('required',true);
                 $('#div_prov').fadeIn();
                 $('#id_provincia').prop('required',true);
                 $('#div_com').fadeIn();
                 $('#id_comune').prop('required',true);  
              }
                                                                    
         else  { $('#div_reg').fadeOut();
                 $('#id_regione').prop('required',false);
                 $('#div_prov').fadeOut();
                 $('#id_provincia').prop('required',false);
                 $('#div_com').fadeOut();
                 $('#id_comune').prop('required',false);   
               }
    });
    

    $("#checkout-form").submit(function(){  

         $.post("<?=BASE_URL;?>functionload.php",jQuery("#checkout-form").serialize(),              
              function(data) {    
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                                if(data.campo=="email"){$('#errmess').html('<span style="color:red;">Attenzione email già presente. Inserire un indirizzo email diverso.</span>');} 
                                else { $('#errmess').html('<span style="color:red;">Errore in invio mail di registrazione</span>');  }
                            }  
                             else {                                
                // alert(data.campo);
                $('#checkout-form').fadeOut();
                $('#errmess').html('<span style="color:green;margin-left:0px;">Registrazione effettuata correttamente.<br />Attiva il tuo account, dalla mail che ti abbiamo inviato.<br />\n\
            Controlla anche la cartella della posta indesiderata.</span>');
              setTimeout(function(){window.location.href = "<?php echo BASE_URL;?>index.php";},7000);                                     
                               }                                              
                             },              
              "json");       
                  });
                  
      $("#form_login").submit(function(){  

         $.post("<?=BASE_URL;?>functionload.php",jQuery("#form_login").serialize(),              
                function(data) {    
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                                $('#errmesslogin').html('<span style="color:red;">Attenzione, dati errati o account ancora non attivato.</span>');
                            }  
                             else {                                
                setTimeout(function(){ window.location.href ="<?php echo $_SERVER['HTTP_REFERER'] ;?>"; },500);                                     
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
