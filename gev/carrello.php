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
$pesototale=0;

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
                            <h3 class="pull-left">Carrello</h3>
                            <ul class="nav-breakcrumb  pull-right">
                                    <li><a href="index-2.html">Home</a></li>
                                    <li><span>Carrello</span></li>
                            </ul>

                    </div>
		</section>
		<!-- END BREAKCRUMB -->
		
		<!-- SHOP CART -->
		<section class="shop-cart">
			<div class="container">

				<!-- TABLE CART -->
				<div class="table-cn ">
					<table class="table table-cart">
						<thead>
							<tr>
								<th>Prodotto</th>
								<th>Quantità</th>
								<th>Subtotale</th>
								<th>Totale</th>
								<th>Elimina</th>
							</tr>
						</thead>
						<tbody>
                                                    
                                             <?php  
                                             
                                             
                                             foreach($cart->get_contents() as $item) {     
                                                 
                                                $totalearticolo=($item['price']*$item['qty']);
                       
                                             ?>
							<tr>
								<td class="td-item">
									<div class="img"> 
										<a href="<?=$item['info']['url'];?>">
                                                                                    <?php if(trim($item['info']['image'])=='Invalid file type.') $immagine="noimage.jpg" ; else $immagine=$item['info']['image']; ?>
											<img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$immagine;?>&h=100&w=80&far=1&bg=ffffff" alt="">
										</a>
									</div>
									<div class="info">
										<a href="<?=$item['info']['url'];?>"><?=$item['info']['nome'];?></a>
										<span class="attr">Codice : <span><?=$item['info']['codice'];?></span></span>
                                                                              
                                                                                <?php if($item['info']['taglia']!=''){ ?>
                                                                                <span class="attr">Taglia : <span><?=$item['info']['taglia'];?></span></span>
                                                                                <?php } ?>
                                                                                <?php if($item['info']['colore']!=''){ ?>
                                                                                <span class="attr">Colore : <span><?=$item['info']['colore'];?></span></span>
                                                                                <?php } ?>
<!--										<span class="attr">Size : <span>XL</span></span>-->
									</div>
								</td>
								<td class="td-qty text-center">
									<div class="qty">
                                                                            <form method="POST" name="add_<?= $item['id'] ;?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                                                            <input type="hidden" name="id_item" value="<?= $item['id'] ;?>" />
                                                                            <input type="hidden" name="action" value="addqty" />
                                                                            <input type="hidden" name="qty_item" value="<?=$item['qty'];?>" />
                                                                            </form>
                                                                            <form method="POST" name="sub_<?= $item['id'] ;?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                                                            <input type="hidden" name="id_item" value="<?= $item['id'] ;?>" />
                                                                            <input type="hidden" name="action" value="removeqty" />
                                                                            <input type="hidden" name="qty_item" value="<?=$item['qty'];?>" />
                                                                            </form>
                                                                            <form method="POST" name="red_<?=$item['id'];?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                                                            <input type="hidden" name="id_item" value="<?=$item['id'];?>" />
                                                                            <input type="hidden" name="action" value="remove" />
                                                                            </form>
                                                                            <button class="qty-plus" onclick="document.add_<?=$item['id'];?>.submit();">+</button>
								            <input type="text" class="input-text" value="<?=$item['qty'];?>" readonly="readonly">
									    <button class="qty-minus" onclick="document.sub_<?= $item['id'] ;?>.submit();">-</button>
									</div>
								</td>
								<td class="td-sub text-center">
									<?=number_format($item['price'],2,',','.');?> &euro;
								</td>
								<td class="td-sub text-center">
									 <?=number_format($totalearticolo,2,',','.');?> &euro;
								</td>
              
								<td class="td-remove text-center">
									<a href="javascript:void(null)" onclick="document.red_<?=$item['id'];?>.submit();"><img src="<?=BASE_URL;?>images/icon-delete.png" alt=""></a>
								</td>
							</tr>
                                             <?php } ?>
							
						</tbody>
						<tfoot>
							<tr class="tr-f">
								<td class="td-item">
									
								</td>
                                                                <td>
                                                                    Totale prodotti:
                                                                    
                                                                </td>
								<td class="td-sub text-center">
									
								</td>
								<td class="td-sub text-center" style="width:150px;">
									<?=number_format($totale,2,',','.');?> &euro;
								</td>
								<td></td>
							</tr>
                                                        
                                                        <tr class="tr-f">
								<td class="td-item">
									
								</td>
                                                                <td>
                                                                Totale iva:
                                                                    
                                                                </td>
								<td class="td-sub text-center">
                                                                   
								</td>
								<td class="td-sub text-center">
									 <?php $iva=($totale/100)*22; ?>
									<?=number_format($iva,2,',','.');?> &euro;
								</td>
								<td></td>
							</tr>
                                                        <tr class="tr-f">
								<td class="td-item">
									
								</td>
								<td>Totale carrello:</td>
								<td class="td-sub text-center">
									
								</td>
								<td class="td-sub text-center">
									<?=number_format($iva+$totale,2,',','.');?> &euro;
								</td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<!-- END TABLE CART -->
				
				<!-- CART BUTTON -->
				<div class="shop-button clearfix">
					<a href="<?=BASE_URL;?>index.php" class="btn btn-13 pull-left">PRODOTTI</a>
                                        <?php
                                        if($_SESSION['nazione']==2){ 
                                             $linkprocedi=BASE_URL."acquistiestero.php";                                            
                                        } else { $linkprocedi=BASE_URL."carrello1.php";  }
                                            
                                       ?>
                                                            
                                        <?php if($totale!=0){ ?>
					<a href="<?=$linkprocedi;?>" class="btn btn-13 pull-right">PROCEDI</a>
                                        <?php } ?>
                                  
                                        
				</div>
				<!-- END CART BUTTON -->
				
				<!-- CART COLLATERALS -->
<!--				<div class="cart-collaterals">
					<div class="row">
						<div class="col-sm-6 col-md-4">
							<h2>Have a Gift Card?</h2>
							<input type="text" class="input-text" placeholder="Enter gift code...">
							<button class="btn btn-13">APPLY</button>
						</div>
						<div class="col-sm-6 col-md-4">
							<h2>Got a Coupon?</h2>
							<input type="text" class="input-text" placeholder="Enter coupon code...">
							<button class="btn btn-13">APPLY</button>
						</div>
						<div class="col-sm-12 col-md-4">
							<h2>Esitimate &amp; Tax</h2>

							<label>Country <sup>*</sup></label>
							<select>
								<option>Select Option...</option>
								<option>Afghanistan</option>
								<option>Åland Islands</option>
								<option>Albania</option>
							</select>

							<label>State/ Province<sup>*</sup></label>
							<select>
								<option>Select Option...</option>
								<option>Alabama</option>
								<option>Alaska</option>
								<option>American Samoa</option>
							</select>

							<label>State/ Province</label>
							<input type="text" class="input-text" placeholder="Select Option...">

							<button class="btn btn-13">Get a Qoute</button>

						</div>
					</div>
				</div>-->
				<!-- END CART COLLATERALS -->

			</div>
		</section>
		<!-- END SHOP CART -->

	
		<?php
include("inc_footer.php");
?>