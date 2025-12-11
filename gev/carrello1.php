<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}
  
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
				<h3 class="pull-left">Dati di fatturazione </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Dati di fatturazione</span></li>
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
						<li data-step="1" class="current"><span>Dati di fatturazione</span></li>
						<li data-step="2"><span>Indirizzo di spedizione</span></li>
						<li data-step="3"><span>Metodo di spedizione</span></li>
						<li data-step="4"><span>Metodo di pagamento</span></li>
						<li data-step="5"><span>Riassunto ordine</span></li>
						<li data-step="6"><span>Conferma Ordine</span></li>
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
						<div class="row">
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:20px;">Dati di fatturazione</b></label> 
					            </div>
                                                    <br /><br /><br />
                                                    <?php
                                                    
                                                    $db->query("SELECT * FROM bag_utenti WHERE id='".$_SESSION['user']."' ");
                                                    $list=$db->single();
                                                    ?>
                                                        <div class="col-xs-4">
								<label><b>Tipologia utente:</b></label> <?=$list['tipologia'];?>
							</div>
							<div class="col-xs-4">
								<label><b>Nome
                                                                <?php if($list['tipologia']=='ente_pubblico'){ ?> Referente <?php } ?>
                                                                    :</b></label>
                                                                 <?=$list['nome'];?>
							</div>
							<div class="col-xs-4">
								<label><b>Cognome
                                                                 <?php if($list['tipologia']=='ente_pubblico'){ ?> Referente <?php } ?>
                                                                        :</b></label>
								 <?=$list['cognome'];?>
							</div>
							<div class="col-xs-4">
								<label><b>Email: </b></label>
								 <?=$list['email'];?>
							</div>
                                                    <?php if($list['tipologia']!='privato'){ ?>
							<div class="col-xs-4">
								<label><b>
                                                      <?php  if($list['tipologia']=='azienda'){ ?> Ragione sociale: <?php } 
                                                      else { echo "Nome ente:"; } ?> </b></label>
								<?=$list['ragione'];?>
							</div>
                                                    <?php } ?>
                                                    
                                                    <?php if($list['tipologia']!='privato'){ ?>
							<div class="col-xs-4">
								<label><b>Partita Iva: </b></label>
								<?=$list['p_iva'];?>
							</div>
                                                    <?php } ?>
							<?php if($list['tipologia']!='azienda'){ ?>
							<div class="col-xs-4">
								<label><b>Codice Fiscale: </b></label>
								<?=$list['cod_fiscale'];?>
							</div>
                                                    <?php } ?>
							
							<div class="col-xs-4">
								<label><b>Indirizzo: </b></label>
								<?=$list['indirizzo'];?>
							</div>
                                                   
							<div class="col-xs-4">
								<label><b>Città: </b></label>
								<?=$list['citta'];?>
							</div>
							<div class="col-xs-4">
								<label><b>Provincia: </b></label>
								<?=$list['provincia'];?>
							</div>
							<div class="col-xs-4">
								<label><b>CAP: </b></label>
								<?=$list['cap'];?>
							</div>
                                                    	<div class="col-xs-4">
								<label><b>Telefono: </b></label>
								<?=$list['telefono'];?>
							</div>
                                                    	<div class="col-xs-4">
								<label><b>Cellulare: </b></label>
								<?=$list['cellulare'];?>
							</div>
                                              
                                                    
                           
						</div>
                                            
                                         <div class="shop-button clearfix">
					 <a class="btn btn-13 text-uppercase pull-left" href="<?=BASE_URL;?>modificadati.php">Modifica dati</a>
					 <a class="btn btn-13 text-uppercase pull-right" href="<?=BASE_URL;?>carrello2.php">Continua</a>
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