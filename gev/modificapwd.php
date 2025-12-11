<?php
include("inc_config.php");
if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}
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
				<h3 class="pull-left">Modifica password</h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="<?=BASE_URL;?>index.php">Home</a></li>
					<li><span>Modifica password</span></li>
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
                                
                                if(isset($_POST['password'])){
                                    
                                 $db->query("SELECT * FROM bag_utenti  WHERE id = '".$_SESSION['user']."' AND password='".$_POST['password']."' AND attivo = 's'  "); 
                                 $result1= $db->resultset();
                                 $num_righe = $db->rowCount();    
                                     if($num_righe==0){  
                                         echo "<span style='color:red'>Password attuale errata <br />Riprova.</span>"; 
                                     
                                     ?>
                                        <br /><br />
						<div class="form login">
                                                        <form id="form_registrazione" action="<?=BASE_URL;?>modificapwd.php" method="post" >
							<label>Password attuale  <sup>*</sup></label>
							<input type="password" class="input-text" name="password" id="password" required>
                                                        <label>Nuova password  <sup>*</sup></label>
							<input type="password" class="input-text" name="nuovapass" id="nuovapass" required>
							<button class="btn btn-13 btn-submit text-uppercase">Modifica</button>
							<div class="btn-group"></div>
                                                        </form>
						</div> 
                                        
                                        
                                        
                                   <?php } else {
                                       
                                       $db->query(" UPDATE bag_utenti SET password = '".$_POST['nuovapass']."' WHERE id = '".$_SESSION['user']."' "); 
                                       $list= $db->execute();
                                      ?>
                                        <span style="color:green;">Password modificata correttamente. </span> 
                                       
                                        
                                  <?php }
                                
                                }
                                
                                else{ ?>     	
                                                <br /><br />
						<div class="form login ">
                                                        <form id="form_registrazione" action="<?=BASE_URL;?>modificapwd.php" method="post" >
							<label>Password attuale  <sup>*</sup></label>
							<input type="password" class="input-text" name="password" id="password" required>
                                                        <label>Nuova password  <sup>*</sup></label>
							<input type="password" class="input-text" name="nuovapass" id="nuovapass" required>
							<button class="btn btn-13 btn-submit text-uppercase">Modifica</button>
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
                

                