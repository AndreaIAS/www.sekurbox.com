<?php
include("inc_config.php");

if(!isset($_SESSION['user'])){header("Location: ".BASE_URL."registrati.php");}


if(isset($_POST['metodopag'])){   
    $_SESSION['metodopag']=$_POST['metodopag'];
    $_SESSION['nomepag']=$array_testo_pag[$_POST['metodopag']];
    $_SESSION['costopag']=$array_costo_pag[$_POST['metodopag']];
}

//PRENDO IL TOTALE CARELLO
foreach($cart->get_contents() as $item) {
 $totale=$totale+($item['price']*$item['qty']);
 //$subtotale=$subtotale+$item['price'];
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
				<h3 class="pull-left">Riassunto ordine </h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index.php">Home</a></li>
					<li><span>Riassunto ordine</span></li>
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
						<li data-step="2"><span>Indirizzo di spedizione</span></li>
						<li data-step="3"><span>Metodo di spedizione</span></li>
						<li data-step="4"><span>Metodo di pagamento</span></li>
						<li data-step="5" class="current"><span>Riassunto ordine</span></li>
						<li data-step="6"><span>Conferma Ordine</span></li>
					</ul>
					<!-- END STEP CHECK OUT -->
					
					<!-- CHECK OUT FORM -->
                                        <div class="form check-out-form" style="padding-top:15px;">
                                            <div class="row" style="height: 160px;">
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:17px;">Dati di fatturazione</b></label> 
					            </div>
                                                    <br /><br />
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
                                            
                                            <div class="row" style="height: 140px;">
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:17px;">Indirizzo di spedizione</b></label> 
					            </div>
                                                    <br /><br />
                                                    <?php
                                                    
                                                    if(isset($_SESSION['nome2'])){
    
                                                          $nomesped=$_SESSION['nome2'];
                                                          $cognomesped=$_SESSION['cognome2'];
                                                          $indirsped=$_SESSION['indirizzo2'];
                                                          $cittasped=$_SESSION['citta2'];
                                                          $provsped=$_SESSION['provincia2'];
                                                          $capsped=  $_SESSION['cap2'];
                                                          $emailsped=  $_SESSION['email2'];
                                                          $telsped=  $_SESSION['telefono2'];
                                                          $cellsped= $_SESSION['cellulare2'];
 
                                                     }
                                                     else {
                                                         
                                                          $nomesped=$list['nome'];
                                                          $cognomesped=$list['cognome'];
                                                          $indirsped=$list['indirizzo'];
                                                          $cittasped=$list['citta'];
                                                          $provsped=$list['provincia'];
                                                          $capsped=$list['cap'];
                                                          $emailsped=$list['email'];
                                                          $telsped=$list['telefono'];
                                                          $cellsped=$list['cellulare'];
                                                         
                                                         
                                                     }
                                                    
                                                
                                                    ?>
                                                   
							<div class="col-xs-4">
								<label><b>Nome:</b></label>
                                                                 <?=$nomesped;?>
							</div>
							<div class="col-xs-4">
								<label><b>Cognome:</b></label>
								 <?=$cognomesped;?>
							</div>
							<div class="col-xs-4">
								<label><b>Email: </b></label>
								 <?=$emailsped;?>
							</div>

							
							<div class="col-xs-4">
								<label><b>Indirizzo: </b></label>
								<?= $indirsped;?>
							</div>
                                                   
							<div class="col-xs-4">
								<label><b>Città: </b></label>
								<?=$cittasped;?>
							</div>
							<div class="col-xs-4">
								<label><b>Provincia: </b></label>
								<?=$provsped;?>
							</div>
							<div class="col-xs-4">
								<label><b>CAP: </b></label>
								<?=$capsped;?>
							</div>
                                                    	<div class="col-xs-4">
								<label><b>Telefono: </b></label>
								<?=$telsped;?>
							</div>
                                                    	<div class="col-xs-4">
								<label><b>Cellulare: </b></label>
								<?=$cellsped;?>
							</div>
                                 
                                                    	
					</div>
                                            
                                       <div class="row" >
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:17px;">Metodo di spedizione</b></label> 
					            </div>
                                                    <br />
        
							<div class="col-xs-12">	
                                                                 <?=$_SESSION['nomesped'];?>
						        </div>
						</div>
                                            
                                            <div class="row" style="margin-top:20px;" >
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:17px;">Metodo di pagamento</b></label> 
					            </div>
                                                    <br />
        
							<div class="col-xs-12">	
                                                                 <?=$_SESSION['nomepag'];?>
						        </div>
						</div>    
                                            
                         
                                 <div class="row" style="margin-top:20px;" >        
                                    <div class="col-xs-12">
                                                        <label><b style="font-size:17px;">Elenco articoli</b></label> 
					            </div>
                                                    <br />         
                                 <div class="col-xs-12">           
                                            	<!-- TABLE CART -->
				<div class="table-cn ">
					<table class="table table-cart">
						<thead>
							<tr>
								<th>Prodotto</th>
								<th>Quantità</th>
								<th>Subtotale</th>
								<th>Totale</th>
							</tr>
						</thead>
						<tbody>
                                                    
                                             <?php   foreach($cart->get_contents() as $item) {     
                                                 
                                                 $totalearticolo=($item['price']*$item['qty']);
                                             ?>
							<tr>
								<td class="td-item" >
<!--									<div class="img"> 
										<a href="<?=$item['info']['url'];?>">
                                                                                    <?php if(trim($item['info']['image'])=='Invalid file type.') $immagine="noimage.jpg" ; else $immagine=$item['info']['image']; ?>
											<img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$immagine;?>&h=100&w=80&far=1&bg=ffffff" alt="">
										</a>
									</div>-->
                                                                    <div class="info" >
										<a href="<?=$item['info']['url'];?>" ><?=$item['info']['nome'];?></a>
										<span class="attr">Codice : <span><?=$item['info']['codice'];?></span></span>
<!--										<span class="attr">Size : <span>XL</span></span>-->
									</div>
								</td>
								<td class="td-qty text-center" style="width:50px;padding:10px;">
							<?=$item['qty'];?>
								</td>
								<td class="td-sub text-center" style="width:100px;padding:10px;">
									<?=number_format($item['price'],2,',','.');?> &euro;
								</td>
								<td class="td-sub text-center">
									 <?=number_format($totalearticolo,2,',','.');?> &euro;
								</td>
              
								
							</tr>
                                             <?php } ?>
							
						</tbody>
						<tfoot>
							<tr class="tr-f">
                                                            <td class="td-item" style="padding: 10px;">
									
								</td>
                                                                <td style="padding: 10px;">
                                                                    Totale prodotti:
                                                                    
                                                                </td>
								<td class="td-sub text-center" style="padding: 10px;">
									
								</td>
								<td class="td-sub text-center" style="width:100px;padding:10px;">
									<?=number_format($totale,2,',','.');?> &euro;
								</td>
								
							</tr>
                                                        
                                                        <tr class="tr-f">
								<td class="td-item">
									
								</td>
                                                                <td style="padding: 10px;">
                                                                Totale iva:
                                                                    
                                                                </td>
								<td class="td-sub text-center" style="padding: 10px;">
                                                                   
								</td>
								<td class="td-sub text-center" style="padding: 10px;">
									 <?php $iva=($totale/100)*22; ?>
									<?=number_format($iva,2,',','.');?> &euro;
								</td>
								<td></td>
							</tr>
                                                     
                                                        <tr class="tr-f">
								<td class="td-item">
									
								</td>
								<td style="padding: 10px;">Totale spedizione:</td>
								<td class="td-sub text-center" style="padding: 10px;">
									
								</td>
								<td class="td-sub text-center" style="padding: 10px;">
									<?=number_format($_SESSION['costosped'],2,',','.');?> &euro;
								</td>
								<td></td>
							</tr>
                                                           <tr class="tr-f">
								<td class="td-item">
									
								</td>
								<td style="padding: 10px;">Totale metodo di pagamento:</td>
								<td class="td-sub text-center" style="padding: 10px;">
									
								</td>
								<td class="td-sub text-center" style="padding: 10px;">
									<?=number_format($_SESSION['costopag'],2,',','.');?> &euro;
								</td>
								<td></td>
							</tr>
                                                            <tr class="tr-f">
								<td class="td-item">
									
								</td>
                                                                <td style="padding: 10px;">
                                                                <b>Totale ordine</b>:
                                                                    
                                                                </td>
								<td class="td-sub text-center" style="padding: 10px;">
                                                                   
								</td>
								<td class="td-sub text-center" style="padding: 10px;">
									 <?php $iva=($totale/100)*22; ?>
                                                                    <b><?=number_format($iva+$totale+$_SESSION['costopag']+$_SESSION['costosped'],2,',','.');?> &euro;</b>
								</td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<!-- END TABLE CART -->
                                 </div>           
                                      
                              </div>  
                                
                                            
                                                   <div class="row" style="margin-top:20px;">
                                                    <div class="col-xs-12">
                                                        <label><b style="font-size:17px;">Note Ordine:</b></label> 
					            </div>
                                                    <br />
        
							<div class="col-xs-12">	
                                                            <form action="<?=BASE_URL;?>carrello6.php" method="POST" id="confermaord" >
                                                            <textarea style="width:100%;height:100px;" name="note"> </textarea>
                                                            <input type="hidden" name="totale" value="<?=number_format($iva+$totale+$_SESSION['costopag']+$_SESSION['costosped'],2,'.','.');?>" />
                                                            <input type="hidden" name="spesesped" value="<?=number_format($_SESSION['costosped'],2,'.','.');?>" />
                                                            <input type="hidden" name="spesepag" value="<?=number_format($_SESSION['costopag'],2,'.','.');?>" />
                                                            </form>
						        </div>
						</div>
                                            
                               
                                            
                                           <br /> 
                                          <div class="shop-button clearfix">
					  <a class="btn btn-13 text-uppercase pull-left" href="<?=BASE_URL;?>carrello4.php">Indietro</a>
                                          <a class="btn btn-13 text-uppercase pull-right" href="javascript:vodi(null)" onclick="$('#confermaord').submit();">Conferma ordine</a>
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