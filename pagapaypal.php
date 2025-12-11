<?php
include("inc_config.php");

if(!isset($_REQUEST['ord'])){header("Location: ".BASE_URL."index.php");}
//if(!isset($_POST['metodosped'])){header("Location: ".BASE_URL."index.php");}



             $db->query("SELECT * FROM
                         bag_ordini 
                         WHERE id='".$_REQUEST['ord']."' 
                        ");
             $list= $db->single();
             
             $numrec=$db->rowCount();
             

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
				<h3 class="pull-left">Paga ordine </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Paga ordine</span></li>
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
						<li data-step="1" ><span>Paga ordine</span></li>
						
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
					
                                            
                                        
                                            <div class="row" >
                                                   <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Pagamento ordine numero <?=$list['id'];?></b></label> 
					            </div>
                                                    <br /><br /><br />
                                                    <div class="col-xs-12" style="color:green;">
                                                         
                                                     
                                                    <?php if($numrec==0){ ?>
                                                        
                                                    <br /><br />
                                                    <span style="color:#000000">
                                                    Non esiste alcun ordine con queste credenziali.
                                                    </span>
                                                    
                                                   <?php  }
                                                    else if($numrec==1 AND $list['pagato']=='s'){?>
                                                   
                                                    <br /><br />
                                                    <span style="color:#000000">
                                                    Attenzione, l'ordine in oggetto risulta essere già pagato.
                                                    </span>
                                                    
                                                   <?php  }
                                                   else{
                                                       
                                                       
                                                            $db->query("SELECT email FROM
                                                                         bag_utenti 
                                                                         WHERE id='".$list['id_utente']."' 
                                                                        ");
                                                             $listu= $db->single();
                                                       
                                                       
                                                   ?>   
                                                        
                                                        <form  action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" >
                                                        <input type="hidden" name="email" value="<?=$listu['email'];?>" />
                                                        <input type="hidden" name="business" value="EQ9NXAXQ37LGS" />
                                                        <input type="hidden" name="receiver_email" value="gevenit@gevenit.com" />
                                                        <input type="hidden" name="item_name" value="Pagamento ordine n. <?=$list['id'];?>" />
                                                        <input type="hidden" name="item_number" value="<?=$list['id'];?>" />
                                                        <input type="hidden" name="amount" value="<?=$list['totale'];?>" />
                                                        <input type="hidden" name="quantity" value="1" />
                                                        <input type="hidden" name="currency_code" value="EUR" />
                                                        <input type="hidden" name="return" value="http://www.gevenit.com/esitopagamentopaypal.php?idordine=<?=$list['id'];?>" />
                                                        <input type="hidden" name="cancel_return" value="<?=BASE_URL;?>index.php" />
                                                        <input type="hidden" name="notify_url" value="http://www.gevenit.com/paypal.php" />
                                                        <input type="hidden" name="no_shipping" value="1" />
                                                        <input type="hidden" name="no_note" value="1" />
                                                        <input type="hidden" name="cmd" value="_xclick">
                                                        <input type="image" src="<?=BASE_URL;?>images/paypal.jpg" border="0" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online.">

                                                        </form>  
                                                    
                                                    <?php } ?>             
								
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

                