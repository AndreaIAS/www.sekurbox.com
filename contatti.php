<?php 
/*include 'include/connessione.php';
include "include/lingua.php"; 
include 'include/leggi_immagine.inc.php';*/

include("inc_config.php");
include("inc_header.php");

			
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

if (isset($_POST['inviamail'])) 
{	
	$email = $_POST['email'];
	$nome=$_POST['nome'];
	$cognome=$_POST['cognome'];
        $oggetto=$_POST['oggetto'];
        $testo=$_POST['messaggio'];
	
	require "class/class.phpmailer.php";
	//istanziamo la classe
	$messaggio = new PHPmailer();
	$messaggio->IsHTML(true);
	//$messaggio->Host='Host SMTP';
	//definiamo le intestazioni e il corpo del messaggio
	$messaggio->From=$_POST['email'];
	$messaggio->FromName = "Sekurbox-Contatti";
	$messaggio->AddAddress('info@sekurbox.com');
        
	$messaggio->Subject=$oggetto;
	$messaggio->Body="<br />Dati mittente:<br /><br />
                          <b>Email:</b> ".$email."<br />
                              <b>Nome:</b> ".$nome."<br />
                                  <b>Cognome:</b> ".$cognome."<br /><br />
                                      <b>Messaggio:</b><br />".$testo;
	//$messaggio->AddAttachment('http://www.sekurbox.com/css/stile.css'); // attach style sheet
	
	//definiamo i comportamenti in caso di invio corretto 
	//o di errore
	if(!$messaggio->Send()){ 
	  echo $messaggio->ErrorInfo; 
	}else{ 
	  $messaggio_inviato=$contattiok;

	}
}    
?>


<head>
<body>
<div id="contenuto">     
		<div class="wrapper-area">
			<?php $pagina="contatti"; include 'inc_menu.php';?>   
			<?php $pagina="contatti"; include 'inc_slider.php';?>   
			
        	<div class="form" style='margin:auto;width:40%;border:1px solid #F5F5F5;padding:10px;'>
                               <?php
                                        if (isset($messaggio_inviato)) {
                                                echo "<p>" . $messaggio_inviato . "</p>";
                                        } else
                                        {
                                ?>
                                <form id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="form_intestazione"><?php echo $titolo_form_registrazione;?></div>
                               
                                    <div class="form_row"><label>Email</label></div>                       
                                    <div class="form_row"><input type="email" name="email" required 
                                    style="border: 1px solid #ccc;color: #666666;height: 30px;width: 330px;"/></div>
                                    <div class="form_row_mezzo">
                                        <div class="form_row"><label><?php echo $nome;?></label></div>                       
                                        <div class="form_row"><input type="text" name="nome"  required/></div>                        
                                    </div>
                                    <div class="form_row_mezzo">
                                        <div class="form_row"><label><?php echo $cognome;?></label></div>                       
                                        <div class="form_row"><input type="text" name="cognome" /></div>                        
                                    </div>
                                     <div class="form_row"><label><?php echo $oggetto;?></label></div>  
                                     <div class="form_row"><input type="text" name="oggetto" required /></div>
                                     <div class="form_row"><label><?php echo $messaggio;?></label></div>  
                                     <div class="form_row">
                                         <textarea  name="messaggio" required style="height:100px;" ></textarea>
                                     </div>
                                    <div class="form_row"></div>   
                                   
                                    
                                    <div class="form_row_button">
                                        <input class="entra" type="submit" value="<?php echo $contattaci;?>" name="inviamail" />              
                                    </div> 
                                </form>   
                       <?php } ?>
                </div>
				
				<?php  include("inc_footer.php");  ?>     
        </div>
		            
    </div>
</div>


    <!-- Bootstrap js -->
    <script src="<?=BASE_URL;?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?=BASE_URL;?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Nivo slider js -->
    <script src="<?=BASE_URL;?>lib/custom-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
    <script src="<?=BASE_URL;?>lib/custom-slider/home.js" type="text/javascript"></script>
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
    <!-- Isotope js -->
    <script src="<?=BASE_URL;?>js/isotope.pkgd.min.js" type="text/javascript"></script>
    <!-- Custom Js -->

    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
    

    <?php include("script_condivisi.php"); ?>
    

</body>
</html>        