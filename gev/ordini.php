<?php
include("inc_config.php");

//$cart->empty_cart();
//Gestione attività carrello
if($_POST['action'] ) {

    switch ($_POST['action']) {
       case "add":
           
         $cart->add_item($_POST['item'],$_POST['itemdb'],$_POST['qty'],$_POST['price'],array("nome" => $_POST['nome'], "image" => $_POST['image'],"url" => $_POST['returnurl'],"codice" => $_POST['codart'],"taglia" => $_POST['taglia'],"colore" => $_POST['colore']));
         break;
       case "remove":
         $cart->del_item($_POST['id_item']);
         break;
       case "addqty":
         $cart->edit_item($_POST['id_item'],$_POST['qty_item']+1);
         break;  
       case "removeqty":
         if($_POST['qty_item']>1){
          $cart->edit_item($_POST['id_item'],$_POST['qty_item']-1);
         }else{
          $cart->del_item($_POST['id_item']);    
         }
         break;
    }   
       
                    }

   
$totale=0;

//PRENDO IL TOTALE CARELLO
foreach($cart->get_contents() as $item) {
 $totale=$totale+($item['price']*$item['qty']);
 //$subtotale=$subtotale+$item['price'];
} 
   
   
include("inc_header.php");
?>
<style>
    
    table th,table td { text-align: center}
    .table-cn .table-cart tbody tr td,.table-cn .table-cart thead tr th{padding-top:5px;padding-bottom:5px}
    
</style>

</head>
<body class="bg-body boxed">

	  <?php 
    include("inc_menu.php");  
    ?>
		
		<!-- BREAKCRUMB -->
		<section class="breakcrumb bg-grey">
			<div class="container">
				<h3 class="pull-left">I tuoi Ordini</h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="index-2.html">Home</a></li>
					<li><span>I tuoi Ordini</span></li>
				</ul>

			</div>
		</section>
		<!-- END BREAKCRUMB -->
		
		<!-- SHOP CART -->
                <section class="shop-cart" style="margin-top:20px;">
			<div class="container">

				<!-- TABLE CART -->
				<div class="table-cn ">
					<table class="table table-cart">
						<thead>
							<tr>
								<th>Numero</th>
								<th>Data</th>
								<th>Totale</th>
								<th>Costo spedizione</th>
								<th>Pagato</th>
                                                                <th>Spedito</th>
                                                                <th>Dettagli</th>
							</tr>
						</thead>
						<tbody>
                                                    
                                             <?php  
                                             
                                                    $db->query( "SELECT bag_ordini.* 
                                                                 FROM 
                                                                 bag_ordini
                                                                 WHERE id_utente='".$_SESSION['user']."'
                                                                 ORDER BY bag_ordini.id DESC");

                                                    $records = $db->resultset();


                                                 if ($db->rowCount() == 0) {

                                            ?>

                                              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

                                            <?php }else{ 
                                                
                                                foreach ($records as $list)  {      

                                             ?>
							<tr>
								<td class="td-item">
									<div class="info"> 
									 <span><?=$list['id'];?></span
									</div>
								</td>
								<td class="td-item">
                                                                      <div class="info"> 
									 <span><?=date('d/m/Y',strtotime($list['data']));?></span
									</div>
								</td>
                                                                <td class="td-item">
                                                                      <div class="info"> 
									 <span><?=$list['totale'];?></span
									</div>
								</td>
                                                                <td class="td-item">
                                                                      <div class="info"> 
									 <span><?=$list['spese_spe'];?></span
									</div>
								</td>
                                                                <td class="td-item">
                                                                      <div class="info"> 
                                                                          <span><img class="imgpagato"   src="<?=BASE_URL;?>images/<?=$list['pagato'];?>.png" border="0" /></span>
									</div>
								</td>
								 <td class="td-item">
                                                                      <div class="info"> 
                                                                          <span><img class="imgpagato"  src="<?=BASE_URL;?>images/<?=$list['spedito'];?>.png" border="0" /></span>
									</div>
								</td>
                                                                 <td class="td-item">
                                                                    <div class="info"> 
                                                                        <span id="det<?=$list['id'];?>" onclick="$('#<?=$list['id'];?>').slideToggle(function(){
                                                                           if( $('#det<?=$list['id'];?>').html()=='Chiudi' ) { $('#det<?=$list['id'];?>').html('Dettagli');} 
                                                                           else {$('#det<?=$list['id'];?>').html('Chiudi');}
                                                                        });" style="cursor:pointer">Dettagli</span>
							            </div>
								</td>
                                                   
							</tr>
                                                        <tr id="<?=$list['id'];?>" style="display:none;">
                                                            <td colspan="7">
                                                                
                                                                <div id="contentwrapper" class="contentwrapper" style="text-align:left;">

                                                                         

                                                                                <h4>Dettaglio Ordine</h4>

                                                                      <!--contenttitle-->

                                                        <!--               <a href="<?=BASE_URL;?>ordini.php?opt=new">
                                                                       <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
                                                                       </a>-->
                                                                        <?php
                                                                            $db->query(" SELECT bag_ordini.* 
                                                                                         FROM 
                                                                                         bag_ordini
                                                                                         WHERE id= '".$list['id']."' ");
                                                                            $records = $db->single();  
                                                                        ?>
                                                                        <div style="clear:both"></div>

                                                                        <div style="float:left;width:32%;margin-right:15px;text-align: left;">

                                                                        <h5>Dati Ordine</h5>
                                                                        -<b>Numero:</b> <?=$records['id'];?> <br />
                                                                        -<b>Data:</b>   <?=date('d/m/Y',strtotime($records['data']));?> <br />
                                                                        -<b>Tipo pagamento:</b> <?=$array_testo_pag[$records['tipo_pagam']];?> <br />
                                                                        -<b>Tipo spedizione:</b> <?=$array_testo_sped[$records['tipo_spedi']];?> <br />
                                                                        -<b>Note:</b> <?=$records['note'];?> <br /><br /><br />


                                                                        </div>
                                                                         <div style="float:left;width:32%;margin-right:15px;text-align: left;">
                                                                         <?php
                                                                            $db->query(" SELECT * 
                                                                                         FROM 
                                                                                         bag_utenti
                                                                                         WHERE id= '".$records['id_utente']."' ");
                                                                            $daticli = $db->single();  
                                                                        ?>   
                                                                        <h5>Dettaglio Cliente</h5>
                                                                        -<b>Nome cliente:</b> <?=$daticli['nome']." ".$daticli['cognome'];?> <br />
                                                                        -<b>Ragione Sociale:</b>   <?=$daticli['ragione'];?> <br />
                                                                        -<b>P.iva:</b> <?=$daticli['p_iva'];?> <br />
                                                                        -<b>Codice Fiscale:</b> <?=$daticli['cod_fiscale'];?> <br />
                                                                        -<b>Indirizzo:</b> <?=$daticli['indirizzo'];?> <br />
                                                                        -<b>Città:</b> <?=$daticli['citta'];?> <br />
                                                                        -<b>Cap:</b> <?=$daticli['cap'];?> <br />
                                                                        -<b>Telefono:</b> <?=$daticli['telefono'];?> <br />
                                                                        -<b>Email:</b> <?=$daticli['email'];?> <br /><br /><br />


                                                                        </div>
                                                                         <div style="float:left;width:32%;text-align: left;">

                                                                        <h5>Indirizzo di Spedizione</h5>
                                                                        <?php if($records['indirizzo']==''){ ?>
                                                                        -<b>Nome cliente:</b> <?=$daticli['nome']." ".$daticli['cognome'];?> <br />
                                                                        -<b>Indirizzo:</b> <?=$daticli['indirizzo'];?> <br />
                                                                        -<b>Città:</b> <?=$daticli['citta'];?> <br />
                                                                        -<b>Provincia:</b> <?=$daticli['provincia'];?> <br />
                                                                        -<b>Cap:</b> <?=$daticli['cap'];?> <br />
                                                                        <?php }  else { ?>  
                                                                        -<b>Nome cliente:</b> <?=$daticli['nome']." ".$daticli['cognome'];?> <br />
                                                                        -<b>Indirizzo:</b> <?=$records['indirizzo'];?> <br />
                                                                        -<b>Città:</b> <?=$records['citta'];?> <br />
                                                                        -<b>Provincia:</b> <?=$records['provincia'];?> <br />
                                                                        -<b>Cap:</b> <?=$records['cap'];?> <br />

                                                                        <?php }  ?>  

                                                                        </div>
                                                                            <div style="clear:both"></div>
                                                               <table class="table table-cart">

                                                                       

                                                                           <thead>
                                                                                <tr>
                                                                                     <th class="head1" style="width:330px;">Nome</th>
                                                                                    <th class="head0" style="width:150px;">Codice</th>
                                                                                    <th class="head1" style="width:150px;">Codice mepa</th>
                                                                                    <th class="head0" style="width:100px;"> Prezzo</th>
                                                                                    <th class="head1" >Quantità</th>
                                                                                    <th class="head0" style="width:100px;text-align:center;">Totale</th>

                                                                                </tr>
                                                                           </thead>


                                                                      <tbody>

                                                                    <?php     

                                                                            $db->query( "SELECT * 
                                                                                         FROM 
                                                                                         bag_det_ord
                                                                                         WHERE id_ordine='".$list['id']."'  ");

                                                                            $dettord = $db->resultset();

                                                                            $totalearticoli=0;

                                                                                      foreach ($dettord as $value)  {   $totalearticoli=$totalearticoli+($value['qta']*$value['prezzo']);    

                                                                                          $db->query( "SELECT bag_articoli.* 
                                                                                                       FROM 
                                                                                                       bag_articoli
                                                                                                       WHERE id='".$value['id_articolo']."' ");

                                                                                          $list = $db->single();

                                                                                          ?> 

                                                                                         <tr class="gradeX">
                                                                                                <td><?=$list['nome'];?></td>
                                                                                                <td><?=$list['codice'];?></td>
                                                                                                <td><?=$list['codice_mepa'];?></td>
                                                                                                <td><?=$value['prezzo'];?></td> 
                                                                                                <td><?=$value['qta'];?></td>
                                                                                                <td style="text-align:center;"><?=number_format($value['qta']*$value['prezzo'],2,',','.');?></td>
                                                                                         </tr>

                                                                                  <?php }  

                                                                                  $iva=($totalearticoli/100)*22;
                                                                                  ?>
                                                                                         <tr>
                                                                                         <td> </td>
                                                                                         <td> </td> 
                                                                                         <td> </td> 
                                                                                         <td style="border-left:0px solid;">  </td> 
                                                                                         <td style="border-left:0px solid;text-align:left;">TOTALE   ARTICOLI</td> 
                                                                                         <td style="text-align:center;"><?=number_format($totalearticoli,2,',','.');?> &euro; </td>       
                                                                                         </tr>
                                                                                          <tr>
                                                                                         <td> </td>
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;text-align:left;">  </td> 
                                                                                         <td style="border-left:0px solid;text-align:left;"> TOTALE IVA</td> 
                                                                                         <td style="text-align:center;"><?=number_format($iva,2,',','.');?> &euro; </td>       
                                                                                         </tr>
                                                                                         <tr>
                                                                                         <td> </td>
                                                                                          <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;text-align:left;"> TOTALE SPED. </td> 
                                                                                         <td style="text-align:center;"><?=number_format($array_costo_sped[$records['tipo_spedi']],2,',','.');?> &euro; </td>       
                                                                                         </tr>
                                                                                         <tr>
                                                                                         <td> </td>
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;text-align:left;">TOTALE METODO PAG.</td> 
                                                                                         <td style="text-align:center;"><?=number_format($array_costo_pag[$records['tipo_pagam']],2,',','.');?> &euro; </td>       
                                                                                         </tr>
                                                                                         <tr>
                                                                                         <td> </td>
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;"> </td> 
                                                                                         <td style="border-left:0px solid;text-align:left;">TOTALE  ORDINE</td> 
                                                                                         <td style="text-align:center;"><?=number_format($totalearticoli+$iva+$array_costo_pag[$records['tipo_pagam']]+$array_costo_sped[$records['tipo_spedi']],2,',','.');?> &euro; </td>       
                                                                                         </tr>

                                                                    </tbody>

                                                                   </table>

                                                             </div> 
                                                            </td>
                                                        </tr>
                                             <?php } 
                                             
                                             
                                            }?>
							
						</tbody>
						<tfoot>
     
                                                        
						</tfoot>
					</table>
				</div>

			</div>
		</section>
		<!-- END SHOP CART -->

	
		<?php
include("inc_footer.php");
?>