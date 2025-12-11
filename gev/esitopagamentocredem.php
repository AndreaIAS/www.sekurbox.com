<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}
//if(!isset($_POST['metodosped'])){header("Location: ".BASE_URL."index.php");}


  $mac="";       
  $mac=md5('NUMORD='.$_REQUEST['NUMORD'].'&IDNEGOZIO='.$_REQUEST['IDNEGOZIO'].'&AUT='.$_REQUEST['AUT'].'&IMPORTO='.$_REQUEST['IMPORTO'].'&VALUTA='.$_REQUEST['VALUTA'].'&IDTRANS='.$_REQUEST['IDTRANS'].'&TCONTAB='.$_REQUEST['TCONTAB'].'&TAUTOR='.$_REQUEST['TAUTOR'].'&ESITO='.$_REQUEST['ESITO'].'&BPW_TIPO_TRANSAZIONE='.$_REQUEST['BPW_TIPO_TRANSAZIONE'].'&wGa--hJ-reYrxtV9X-47Kj-C8VK8jnyzJuGcUuJfJFSn9-YaP-');

  
$esito='n';

echo  $mac."<br />".$_REQUEST['MAC'];

//echo "<br /><br />".strtolower($_REQUEST['MAC'])."---".strtolower($mac)."<br /><br />";

  //Estraggo numero transazione e invio email
        $db->query("SELECT * FROM bag_ordini WHERE id = '".trim($_REQUEST['NUMORD'])."' ");
        $list=$db->single();

  if(strtolower($_REQUEST['MAC'])==strtolower($mac)){

      if($_REQUEST['ESITO']=='00') {  $esito='s';}

   } 


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
				<h3 class="pull-left">Esito pagamento </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Esito pagamento</span></li>
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
						<li data-step="1" ><span>Esito pagamento</span></li>
						
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
					
                                            
                                        
                                            <div class="row" >
                                                   <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Esito pagamento ordine numero <?=trim($_REQUEST['NUMORD']);?></b></label> 
					            </div>
                                                    <br /><br /><br />
                                                    <div class="col-xs-12" style="color:green;">
                                                      <?php if($esito=='s'){ ?>    
                                                        La ringraziamo per aver ordinato su Gevenit.com. <br />
                                                        Il suo ordine è stato pagato correttamente.  <br /> 
                                                        Spediremo nel più breve tempo possibile. <br />
                                                        
                                                     
                                               <?php } else {
                                                   
                                                    $mac="";       
                                                    $mac=md5('URLMS=http://www.gevenit.com/chiudi_servercredem.php&URLDONE=http://www.gevenit.com/esitopagamentocredem.php&NUMORD='.$_REQUEST['NUMORD'].'&IDNEGOZIO=129280303200680&IMPORTO='.$_REQUEST['IMPORTO'].'&VALUTA=978&TCONTAB=I&TAUTOR=I&OPTIONS=G&aWXY9Z-9FuC-87pP6N-FwL-vwK6twbPsGKHVfZ9cnxXvfec7-Y');
                                                    
                                                   
                                                    ?>
                                                        
                                                        Il pagamento dell'ordine non è andato a buon fine.
                                                        Clicca sul bottone qui in basso per riprovare.<br />
                                                      <br /><br />
                                                      <form action="https://atpos.ssb.it/atpos/pagamenti/main" method="POST">
                                                        <input type="hidden" name="PAGE" value="MASTER">
                                                        <input type="hidden" name="IMPORTO" value="<?=$_REQUEST['IMPORTO'];?>">
                                                        <input type="hidden" name="VALUTA" value="978">
                                                        <input type="hidden" name="LINGUA" value="ITA">
                                                        <input type="hidden" name="IDNEGOZIO" value="129280303200680">
                                                        <input type="hidden" name="NUMORD" value="<?=$_REQUEST['NUMORD'];?>">
                                                        <input type="hidden" name="URLDONE" value="http://www.gevenit.com/esitopagamentocredem.php">
                                                        <input type="hidden" name="URLBACK" value="http://www.gevenit.com/esitopagamentocredem.php">
                                                        <input type="hidden" name="URLMS" value="http://www.gevenit.com/chiudi_servercredem.php">
                                                        <input type="hidden" name="TCONTAB" value="I">
                                                        <input type="hidden" name="TAUTOR" value="I">
                                                        <input type="hidden" name="OPTIONS" value="G">
<!--                                                    <input type="hidden" name="EMAIL" value="prova@demo.net">
                                                        <input type="hidden" name="EMAILESERC" value="prova2@demo.net">-->
                                                        <input type="hidden" name="MAC" value="<?=$mac;?>">
                                                        <input type=submit value="Avvia..." >
                                                        </form>    
                                                    
                                                    
                                                   <?php  } ?>
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

                