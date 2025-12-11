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
				<h3 class="pull-left">Dati di spedizione </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Dati di spedizione</span></li>
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
						<li data-step="1" ><span>Dati di fatturazione</span></li>
						<li data-step="2" class="current"><span>Dati di spedizione</span></li>
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
                                                        <label><b style="font-size:20px;">Dati di spedizione</b></label> 
					            </div>
                                                    <br /><br /><br />
                                                    <?php
                                                    
                                                    $db->query("SELECT * FROM bag_utenti WHERE id='".$_SESSION['user']."' ");
                                                    $list=$db->single();
                                                    ?>
                                                       
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
                                                    	<div class="col-xs-12">
								         <a  href="javascript:void(null)" onclick="$('#nuovoind').slideToggle()">Spedisci ad <br />un'altro indirizzo</a>
							</div>
                                                  
						</div>
                                  
                                            
                                         <div class="shop-button clearfix">
					  <a class="btn btn-13 text-uppercase pull-left" href="<?=BASE_URL;?>carrello1.php">Indietro</a>
                                          <a class="btn btn-13 text-uppercase pull-right" href="<?=BASE_URL;?>carrello3.php">Continua</a>
                                         </div>
                                            <br /><br />
                                            
                                         <form id="form_spedizione" action="<?=BASE_URL;?>carrello3.php" method="post" >
                                            <div class="row" id='nuovoind' style="display:none">
							<div class="col-xs-6">
								<label>Nome <sup>*</sup></label>
								<input type="text" class="input-text" name="nome2" required>
							</div>
							<div class="col-xs-6">
								<label>Cognome <sup>*</sup></label>
								<input type="text" class="input-text" name="cognome2" required>
							</div>
							<div class="col-xs-12">
								<label>Email  <sup>*</sup></label>
								<input type="email" class="input-text" name="email2" required>
							</div>
							<div class="col-xs-12">
								<label>Indirizzo <sup>*</sup></label>
								<input type="text" class="input-text" name="indirizzo2" required>
							</div>
							<div class="col-xs-12">
								<label>Città</label>
								<input type="text" class="input-text" name="citta2" required>
							</div>	
							<div class="col-xs-6">
								<label>Provincia <sup>*</sup></label>
								<input type="text" class="input-text" name="provincia2" required>
							</div>
							<div class="col-xs-6">
								<label>Cap <sup>*</sup></label>
								<input type="text" class="input-text" name="cap2" required>
							</div>
							<div class="col-xs-6">
								<label>Telefono </label>
								<input type="text" class="input-text" name="telefono2">
							</div>
							<div class="col-xs-6">
								<label>Cellulare</label>
								<input type="text" class="input-text" name="cellulare2" >
							</div>
							<div class="col-xs-12">
								<button class="btn btn-13 text-uppercase pull-right">Continua</button>
							</div>
						</div>
                                         </form>
					
					</div>
					<!-- END CHECK OUT FORM -->

				</div>
			</div>
		</section>
		<!-- END CHECK OUT -->

	
		
				<?php
include("inc_footer.php");
?>

                