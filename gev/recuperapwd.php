<?php
include("inc_config.php");
include("inc_header.php");
?>

</head>
<body >
    
    <?php 
    include("inc_menu.php"); 
    ?>

    <!-- BREAKCRUMB -->
		<section class="breakcrumb bg-grey">
			<div class="container">
				<h3 class="pull-left">Recupera password</h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="<?=BASE_URL;?>index.php">Home</a></li>
					<li><span>Recupera password</span></li>
				</ul>

			</div>
		</section>
		<!-- END BREAKCRUMB -->
                
                	<!-- LOGIN REGISTER -->
		<section class="login-register">
			<div class="container">
				<div class="row">	
                                    <div class="col-md-6">
                                <?php 
                                
                                if(isset($_POST['email'])){
                                    
                                 $db->query("SELECT id FROM bag_utenti  WHERE email = '".$_POST['email']."' AND attivo = 's'  "); 
                                 $result1= $db->resultset();
                                 $num_righe = $db->rowCount();    
                                     if($num_righe==0){  
                                         echo "<span style='color:red'>Non esiste nessun account con questo indirizzo email, oppure l'account non è ancora attivo. <br />Riprova.</span>"; 
                                     
                                     ?>
                                        <br /><div class="form login ">
                                                        <form id="form_registrazione" action="<?=BASE_URL;?>recuperapwd.php" method="post" >
							<label>Indirizzo Email  <sup>*</sup></label>
							<input type="email" class="input-text" name="email" id="email" required>
							<button class="btn btn-13 btn-submit text-uppercase">Recupera</button>
							<div class="btn-group"></div>
                                                        </form>
						</div> 
                                        
                                        
                                        
                                   <?php } else {
                                       
                                       $db->query("SELECT * FROM bag_utenti  WHERE email = '".$_POST['email']."' AND attivo = 's'  "); 
                                       $list= $db->single();
                                       
                                    $testo_email = "<span style='color:#000000;font-family:Arial,sans-serif;font-size:15px;'>";
                                    $testo_email = "Hai richiesto il reinvio della tua password, di seguito troverai i dati per accedere al tuo account:<br /><br />";
                                    $testo_email.= "E-mail: ".$_POST['email']."<br />";
                                    $testo_email.= "Password: ".$list['password']."<br />";
                                     $testo_email.= "<br /><br /><br />
                                     <div style='font-size:13px;width:200px;float:left;'>
                                     Sito Internet: <a style='color: #19a9e5;' href='http://www.gevenit.com'>Gevenit.com</a><br />
                                     Email: <a style='color: #19a9e5;' href='mailto:gevenit@gevenit.com'>gevenit@gevenit.com</a><br />
                                     </div></span>";
                                     $mail = new phpmailer(); 
                                     $mail->IsHTML(true);
                                     $mail->From = EMAIL_ADM;
                                     $mail->FromName = EMAIL_ADM_NAME;
                                     $mail->AddAddress(mysql_escape_string($_POST['email']));
                                     $mail->Subject = "Richiesta reinvio password";
                                     $mail->Body = $testo_email;
                                     if ($mail->Send()) { echo "<span style='color:green'>Ti abbiamo inviato una email contenente la tua password.</span>";  }
                                     else{echo "<span style='color:red'>Problema di invio mail. Contattaci.</span>";} 
                                       
                                        
                                   }
                                
                                }
                                
                                else{ ?>     	
				

						<div class="heading _two text-left">
							<h2>Hai smarrito la password?</h2><br />
                                                        <h5> Inserisci l'e-mail con quale sei registrato e ti verrà spedita la password entro pochi istanti.</h5> 
						</div>

						<div class="form login ">
                                                        <form id="form_registrazione" action="<?=BASE_URL;?>recuperapwd.php" method="post" >
							<label>Indirizzo Email  <sup>*</sup></label>
							<input type="email" class="input-text" name="email" id="email" required>
							<button class="btn btn-13 btn-submit text-uppercase">Recupera</button>
							<div class="btn-group"></div>
                                                        </form>
						</div>

					
                                <?php } ?>    
                                     
                                 </div>   
                                    
                                    <br /> <br /> <br /> <br />
				</div>
			</div>
		</section>
		<!-- END LOGIN REGISTER -->

                             
<?php
include("inc_footer.php");
?>
                

                