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

                                                    $importo=$list['totale']*100;

                                                    $mac="";       
                                                    $mac=md5('URLMS=http://www.gevenit.com/chiudi_servercredem.php&URLDONE=http://www.gevenit.com/esitopagamentocredem.php&NUMORD='.$list['id'].'&IDNEGOZIO=129280303200680&IMPORTO='.$importo.'&VALUTA=978&TCONTAB=I&TAUTOR=I&OPTIONS=G&aWXY9Z-9FuC-87pP6N-FwL-vwK6twbPsGKHVfZ9cnxXvfec7-Y');
                                                    
                                                         $db->query("SELECT email FROM
                                                                         bag_utenti 
                                                                         WHERE id='".$list['id_utente']."' 
                                                                        ");
                                                             $listu= $db->single();
                                                   ?>
                                                    
                                                        <div style="clear:both"></div>
                                                        <br /><br /> 
                                                        <form action="https://atpos.ssb.it/atpos/pagamenti/main" method="POST">
                                                        <input type="hidden" name="PAGE" value="MASTER">
                                                        <input type="hidden" name="IMPORTO" value="<?=$importo;?>">
                                                        <input type="hidden" name="VALUTA" value="978">
                                                        <input type="hidden" name="LINGUA" value="ITA">
                                                        <input type="hidden" name="IDNEGOZIO" value="129280303200680">
                                                        <input type="hidden" name="NUMORD" value="<?=$list['id'];?>">
                                                        <input type="hidden" name="URLDONE" value="http://www.gevenit.com/esitopagamentocredem.php">
                                                        <input type="hidden" name="URLBACK" value="http://www.gevenit.com/esitopagamentocredem.php">
                                                        <input type="hidden" name="URLMS" value="http://www.gevenit.com/chiudi_servercredem.php">
                                                        <input type="hidden" name="TCONTAB" value="I">
                                                        <input type="hidden" name="TAUTOR" value="I">
                                                        <input type="hidden" name="OPTIONS" value="G">
<!--                                                    <input type="hidden" name="EMAIL" value="prova@demo.net">
                                                        <input type="hidden" name="EMAILESERC" value="prova2@demo.net">-->
                                                        <input type="hidden" name="MAC" value="<?=$mac;?>">
                                                        <input type="image" src="<?=BASE_URL;?>images/carte.jpg" >
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

                