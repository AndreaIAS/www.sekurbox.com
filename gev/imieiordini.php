<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."index.php");}
  
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
				<h3 class="pull-left">I miei ordini </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>I miei ordini</span></li>
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
                                                    <?php
                                                    $cont=0;
                                                    $db->query("SELECT * FROM bag_ordini WHERE id_utente='".$_SESSION['user']."'  ORDER by id");
                                                    $records=$db->resultset();
                                                    foreach ($records AS $list){ $cont++;
                                                    ?>
                                            <li data-step="<?=$cont;?>" <?php if($cont==1) echo 'class="current"'; ?> 
                                             style="cursor:pointer"   onclick="$('.check-out-form').hide();$('#ord<?=$list['id'];?>').fadeIn('slow');$('.current').removeClass('current');$(this).addClass('current');" ><span>Ordine numero <?=$list['id'];?></span></li>
                                                    <?php } ?>
						
					</ul>
					<!-- END STEP CHECK OUT -->
					
                                        
                                         <?php
                                                     $conta=0;
                                                    $db->query("SELECT * FROM bag_ordini WHERE id_utente='".$_SESSION['user']."'  ORDER by id");
                                                    $records=$db->resultset();
                                                    foreach ($records AS $list){$conta++;
                                         ?>
					<!-- CHECK OUT FORM -->
                                        <div id="ord<?=$list['id'];?>" class="form check-out-form" style="<?php if($conta!=1) echo 'display:none;'; ?>padding-top:15px;">
						<div class="row">
                                                
                                                        <div class="col-xs-6">
								<label><b>Data Ordine:</b></label> <br /><?=dataesplicita($list['data']);?>
							</div>
						
							<div class="col-xs-3">
								<label><b>Stato pagamento:</b></label><br />
                                                                 <?php if($list['pagato']=='s') echo " PAGATO";  else echo "NON PAGATO"; ?>
							</div>
							<div class="col-xs-3">
								<label><b>Stato spedizione:</b></label><br />
                                                                 <?php if($list['spedito']=='s') echo "SPEDITO";  else echo "DA SPEDIRE"; ?>
							</div>
                                                    
                                               <div class="col-xs-12"> <br /></div>
                                                   
							<div class="col-xs-6">
								<label><b>Metodo di spedizione: </b></label><br />
								<?=$array_testo_sped[$list['tipo_spedi']];?>
							</div>
							<div class="col-xs-6">
								<label><b>Metodo di pagamento: </b></label><br />
								<?=$array_testo_pag[$list['tipo_pagam']];?>
							</div>
						    	

                                                     <div class="col-xs-12"> <br /> <br /></div>
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:20px;color:#13914a;">Elenco articoli:</b></label> 
					            </div>
                                                    
                                                    
                                                      <?php
                                                    $totaleprod=0;  
                                                    $db->query("SELECT bag_articoli.*,bag_det_ord.* 
                                                                FROM bag_det_ord,bag_articoli
                                                                WHERE bag_det_ord.id_articolo=bag_articoli.id 
                                                                AND bag_det_ord.id_ordine='".$list['id']."' ");
                                                    $recordsa=$db->resultset();
                                                    foreach ($recordsa AS $value){ $totaleprod=$totaleprod+($value['qta']*$value['prezzo']);
                                                     ?>
                                                    
                                                    
                                                     <div class="col-xs-6" >
								<label><b>NOME ARTICOLO: </b></label><br />
								<?=$value['nome'];?>
							</div>
                                                   
							
							<div class="col-xs-3">
								<label><b>Quantità: </b></label><br />
								<?=$value['qta'];?>
							</div>
                                                   
							
							<div class="col-xs-3">
								<label><b>Prezzo totale: </b></label><br />
								<?=number_format($value['qta']*$value['prezzo'],2,',','.');?>
							</div>
                                                    <?php } ?>
                                                    
                                                     <div class="col-xs-12" style="border-bottom: 1px solid #dedede"><br /></div>
                                                     
                                                     <div class="col-xs-12" ><br /></div>
                                                      
                                                      <div class="col-xs-6"></div>
						      <div class="col-xs-3">
								<label><b>Totale prodotti: </b></label><br />
						      </div>
						      <div class="col-xs-3">
								<?=number_format($totaleprod,2,',','.');?>
						      </div>
                                                      <div class="col-xs-6"></div>
					              <div class="col-xs-3">
								<label><b>Totale iva: </b></label><br />	
					              </div>
						      <div class="col-xs-3">
								<?=number_format($list['totale']-$totaleprod-$array_costo_pag[$list['tipo_pagam']]-$array_costo_sped[$list['tipo_spedi']],2,',','.');?>
						      </div>
                                                      <div class="col-xs-6"></div>
					              <div class="col-xs-3">
								<label><b>Totale spedizione: </b></label><br />	
					              </div>
						      <div class="col-xs-3">
								<?=number_format($array_costo_sped[$list['tipo_spedi']],2,',','.');?>
						      </div>
                                                      <div class="col-xs-6"></div>
					              <div class="col-xs-3">
								<label><b>Totale  pagamento: </b></label><br />	
					              </div>
						      <div class="col-xs-3">
								<?=number_format($array_costo_pag[$list['tipo_pagam']],2,',','.');?>
						      </div>
                                                      <div class="col-xs-12"><br /></div>
                                                      <div class="col-xs-6"></div>
                                                      <div class="col-xs-3" style="font-size:18px;">
								<label><b>Totale  ordine: </b></label><br />	
					              </div>
						      <div class="col-xs-3"style="font-size:18px;">
								<?=number_format($list['totale'],2,',','.');?>
						      </div>
                                                      
                                                      
                                                      
                                                    <br /><br /><br />
                                                
						</div>
                              
					</div>
					<!-- END CHECK OUT FORM -->
                                        <?php } ?>
                                      
				</div>
                                
                           
			</div>
		</section>
		<!-- END CHECK OUT -->

		
				<?php
include("inc_footer.php");
?>