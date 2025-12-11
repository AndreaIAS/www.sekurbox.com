<?php

include("inc_config.php");

if(!isset($_SESSION['user_site'])){header("Location: ".BASE_URL."registrati.php");}
  
$title_it="Sekurbox - Dettagli ordine";
$title_en="Sekurbox - Order Details";
$description_it="";
$description_en="";


include("inc_header.php");
?>

<meta name="robots" content="noindex">

</head>

<body>
 <div class="wrapper-area">
        
    <?php  
    include("inc_menu.php");  
    ?>
        <!-- Header Area End Here -->
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?=$lang['dettagli_ordine'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['dettagli_ordine'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inner Page Banner Area End Here -->
        <!-- Checkout Page Area Start Here -->
        <div class="checkout-page-area" style="padding-top:30px;">
            <div class="container">
<!--                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="checkout-page-top">
                            <p><i class="fa fa-check" aria-hidden="true"></i><a href="#"> Returning customer? Click here to login</a></p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="checkout-page-top">
                            <p><i class="fa fa-check" aria-hidden="true"></i><a href="#"> Returning customer? Click here to login</a></p>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="order-sheet">
                            <h2 class="cart-area-title"><?=$lang['dati_fatturazione'];?></h2>
                            <?php
                                                    
                            $db->query( " SELECT bag_utenti.*, comuni.nome  AS nomecomune"
                                      . " FROM bag_utenti "
                                      . " INNER JOIN comuni on comuni.id=bag_utenti.id_comune "
                                      . " WHERE bag_utenti.id='".$_SESSION['user_site']."' ");
                            $list=$db->single();
                            ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b>Tipologia utente:</b></label> <?=$list['tipologia'];?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['nome'];?>:</b></label>
                                         <?=$list['nome'];?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['cognome'];?>:</b></label>
                                         <?=$list['cognome'];?>
                                </div>
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b>Email: </b></label>
                                         <?=$list['email'];?>
                                </div>
                                <?php if($list['tipologia']!='privato'){ ?>
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['ragione'];?>:</b></label>
                                        <?=$list['ragione'];?>
                                </div>

                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['piva'];?>: </b></label>
                                        <?=$list['p_iva'];?>
                                </div>
                                <?php } ?>
                                <?php if($list['tipologia']=='privato'){ ?>
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['cod_fisca'];?>: </b></label>
                                        <?=$list['cod_fiscale'];?>
                                </div>
                                <?php } ?>

                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['indirizzo'];?>: </b></label>
                                        <?=$list['indirizzo'];?>
                                </div>

                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['citta'];?>: </b></label>
                                        <?=$list['nomecomune'];?>
                                </div>

                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['cap'];?>: </b></label>
                                        <?=$list['cap'];?>
                                </div>
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['telefono'];?>: </b></label>
                                        <?=$list['telefono'];?>
                                </div>
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label><b><?=$lang['cellp'];?>: </b></label>
                                        <?=$list['cellulare'];?>
                                </div>

                                 <div class="shop-button clearfix">
                                 <a class="btn btn-13 text-uppercase pull-left" href="<?=BASE_URL;?>modificadati.php">Modifica dati</a>
                                 </div>
                        </div>
                    </div>

                </div>
<form id="checkout-form" action="<?=BASE_URL;?>carrello2.php" method="POST" name="checkout-form" >  
    
          <div class="row">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="order-sheet">
                                <div class="row">         
                                      <div class="billing-details-area">
                                            <h2 class="cart-area-title"><?=$lang['dati_spedizione'];?></h2>
                                            <div class="ship-to-another-area">
                                            <h2 class="cart-area-title" style="font-size:14px;"><?=$lang['sped_diverso'];?>
                                           <span><input type="checkbox" name="sped_diverso" id="sped_diverso" onclick="if($(this).prop('checked')){$('#new_ship :input ').prop('required',true);  $('#new_ship').show();}else{$('#new_ship :input ').prop('required',false);$('#new_ship').hide();}"/></span></h2>
                                              </div>
                                        </div>
                                </div>     

                   <div class="row">   
                       
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none;" id="new_ship">     

                           <div class="row">
                               
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">  
                                <label class="control-label" style="width:100%;"><?=$lang['nome'];?> <sup>*</sup></label>
                            <input type="text" name="nome" class="form-control" >
                            </div>
                            </div>
                            
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">     
                            <label class="control-label"><?=$lang['cognome'];?> <sup>*</sup></label>
                            <input type="text" name="cognome" id="cognome" class="form-control" >
                            </div>
                             </div>
                               
                           </div>    

                            <div class="row">   
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">   
                            <label class="control-label">Email <sup>*</sup></label>
                            <input type="email" class="form-control" name="email"  >
                             </div>
                             </div>
                            </div>

                           <div class="row">   
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group"> 
                          
                            <label class="control-label"><?=$lang['nazione'];?><sup>*</sup></label>
                            <select name="id_nazione"   id="id_nazione" class="select2">
                                <option value=""><?=$lang['select_nazione'];?></option>   
                                 <?php

                                $db->query("SELECT *
                                            FROM  
                                            nazioni
                                            ORDER by id
                                           ");
                               $recordr = $db->resultset();   
                               foreach ($recordr as $list) {
                               ?> 
                               <option value="<?=$list['id'];?>" <?php if($list['id']=='106') echo "selected='selected'";?> ><?=$list['nome_'.$lng];?></option>
                               <?php
                               } 
                               ?>
                            </select>
                            </div>
                           </div>
                          </div>     

                          <div class="row">   
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group" id="div_reg">        
                               
                    
                        <label class="control-label" for="id_regione"><?=$lang['regione'];?><sup>*</sup></label>
                       

                          <select name="id_regione" class="select2" id="id_regione" 
                              onchange="jQuery('#provincia').load('functionload.php #data',{function:'provincereg',id_regione:jQuery(this).val()},
                                                  function(){$('.select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '100%'
                                             });});" >
                               <option value=""><?=$lang['select_regione'];?></option> 
                                <?php
                                $db->query("SELECT *
                                            FROM  
                                            regioni
                                            ORDER by nome
                                           ");
                               $recordr = $db->resultset();   
                               foreach ($recordr as $list) {
                               ?> 
                               <option value="<?=$list['id'];?>"><?=$list['nome'];?></option>
                               <?php } ?>
                          </select>
                        </div>
                          </div>  
                        </div>
                            <div class="row" >   
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group" id="provincia">   
                            </div>
                            </div>
                            </div>    
                            <div class="row" >   
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group" id="comune">   
                            </div>
                            </div>
                            </div> 

                            <div class="row">   
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">   
                                    <label class="control-label"><?=$lang['indirizzo'];?> <sup>*</sup></label>
                                    <input type="text" class="form-control" name="indirizzo" >
                                    </div>
                                </div> 
                            </div>  
                            <div class="row">     
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">  
                            <label class="control-label"><?=$lang['cap'];?><sup>*</sup></label>
                            <input type="text"  name="cap" class="form-control" >
                            </div>
                             </div> 
                            </div>
                             <div class="row">      
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">  
                            <label class="control-label"><?=$lang['telefono'];?>*</label>
                            <input type="text"  name="telefono" class="form-control" >
                             </div>
                             </div>  
                           
                                 
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">  
                            <label class="control-label"><?=$lang['cellp'];?></label>
                            <input type="text"  name="cellulare" class="form-control" >
                                  </div>
                             </div> 
                             </div>    
        
                          
   </div>     
  </div>        
   </div>
                    </div>

                </div>
        
            <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="payment-option order-sheet">
                            
                        <div class="row">         
                          <div class="billing-details-area">
                                <h2 class="cart-area-title"><?=$lang['sped_metod'];?></h2>  
                          </div>
                        </div> 
                            
                        <div class="form-group">
                            <span><input type="radio" name="metodo_sped" value="Corriere Bartolini" checked="" for="8" />Corrire Bartolini (+ € 8.00) </span>
                        </div>
                        <div class="form-group">
                            <span><input type="radio" name="metodo_sped" value="Corriere Gls" for="8" />Corrire GLS (+ € 8.00) </span>
                        </div>
                        <div class="form-group">
                            <span><input type="radio" name="metodo_sped" value="Ritiro presso negozio di Lecce" for="0"/>Ritiro presso Negozio di Lecce (+ € 0.00) </span>
                        </div>
                        </div>
                    </div>
                </div>

                 <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="payment-option order-sheet">
                            
                        <div class="row">         
                          <div class="billing-details-area">
                                <h2 class="cart-area-title"><?=$lang['pay_metod'];?></h2>  
                          </div>
                        </div> 
                            
<!--                        <div class="form-group">
                            <span><input type="radio" name="pay_metod" value="Carta di Credito"  for="0" />Carta di credito (+ € 0.00) </span>
                        </div>-->
                        <div class="form-group">
                            <span><input type="radio" name="pay_metod" value="Bonifico Bancario" for="0" checked=""/>Bonifico bancario (+ € 0.00) </span>
                        </div>
                        <div class="form-group">
                            <span><input type="radio" name="pay_metod" value="Contrassegno" for="6"/>Contrassegno (+ € 6.00)  </span>
                        </div>
                        </div>
                    </div>
                </div>
             <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="payment-option order-sheet" style="padding: 0px 35px;">
                            
                        <div class="row">         
                          <div class="billing-details-area" style="margin-bottom: -2px;">
                                <h2 class="cart-area-title"><?=$lang['note_ordine'];?></h2>  
                          </div>
                        </div> 
                            
                        <div class="form-group">
                           <textarea  name="note_ordine" id="note_ordine" style="width:90%; height:90%;"/></textarea>
                        </div>
                    
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="order-sheet">
                            <h2><?=$lang['your_order'];?></h2>
                            <ul>
                                   
                            <?php  
                                foreach($cart->get_contents() as $item) {     
                                $totalearticolo=($item['price']*$item['qty']);
                            ?>
                                <li><?=$item['qty'];?> x <?=ucfirst(strtolower($item['info']['nome']));?><span>&euro; <?=number_format($totalearticolo,2,',','.');?> </span></li>
                            <?php } ?>     
                              
                            
                            </ul>
                            <h3><?=$lang['imponibile'];?><span> &euro; <?=number_format($totalecarr,2,',','.');?> </span></h3>
                            <h3><?=$lang['iva'];?><span>&euro; <?=number_format(($totalecarr/100)*22,2,',','.');?> </span></h3>
                            <h3><span style="color:#009392;float:none;"><?=$lang['totale_carrello'];?></span><span> &euro; <?=number_format((($totalecarr/100)*22)+$totalecarr,2,',','.');?> </span></h3>
                            <h3><?=$lang['shipping_cost'];?><span id="shipp_cost" >&euro; <?=number_format(8,2,',','.');?></span></h3>
                            <h3><?=$lang['payment_cost'];?><span id="pay_cost">&euro; <?=number_format(0,2,',','.');?></span></h3>
                            <h3 style="color:#009392;float:none;"><?=$lang['totale_ordine'];?><span id="tot_ord" for="<?=((($totalecarr/100)*22)+$totalecarr)+8;?>">&euro; <?=number_format(((($totalecarr/100)*22)+$totalecarr)+8,2,',','.');?></span></h3>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pLace-order">
                            <a href='<?=BASE_URL;?>carts' class="btn-send-message" style="float:left;"> <?=$lang['carrello'];?></a>
                            <button class="btn-send-message" type="submit" value="conferma" > <?=$lang['acquista'];?></button>
                        </div>
                    </div>
                </div> 
</form>

            </div>
        </div>
        <!-- Checkout Page Area End Here -->
        <!-- Footer Area Start Here -->
        <?php  
    include("inc_footer.php");  
     ?>  
        <!-- Footer Area End Here -->
    </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- jquery-->
    <script src="<?=BASE_URL;?>js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap js -->
    <script src="<?=BASE_URL;?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?=BASE_URL;?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?=BASE_URL;?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?=BASE_URL;?>js/wow.min.js" type="text/javascript"></script>
    <!-- Plugins js -->
    <script src="<?=BASE_URL;?>js/plugins.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="<?=BASE_URL;?>js/jquery.countdown.min.js" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?=BASE_URL;?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
    <!-- Select2 Js -->
    <script src="<?=BASE_URL;?>js/select2.min.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        var vecchio_sped =parseFloat($("input[name='metodo_sped']").attr("for"));
        var vecchio_costo =parseFloat($("input[name='pay_metod']").attr("for"));
        
        $(document).on("change","input[name='metodo_sped']",function(){     
             $('#shipp_cost').html('&euro; '+parseFloat($(this).attr("for")).toFixed(2).replace(".", ","));
             
             var totale_ordine_prima=parseFloat($('#tot_ord').attr("for"));
             var totale_aggiornato=totale_ordine_prima-vecchio_sped+parseFloat($(this).attr("for"));
             $('#tot_ord').attr("for",totale_aggiornato);
             $('#tot_ord').html('&euro; '+totale_aggiornato.toFixed(2).replace(".", ","));
             vecchio_sped=parseFloat($(this).attr("for"));
        });
        
        
       
        
        $(document).on("change","input[name='pay_metod']",function(){     
             $('#pay_cost').html('&euro; '+parseFloat($(this).attr("for")).toFixed(2).replace(".", ","));
             
             var totale_ordine_prima=parseFloat($('#tot_ord').attr("for"));
             var totale_aggiornato=totale_ordine_prima-vecchio_costo+parseFloat($(this).attr("for"));
             $('#tot_ord').attr("for",totale_aggiornato);
             $('#tot_ord').html('&euro; '+totale_aggiornato.toFixed(2).replace(".", ","));
             vecchio_costo=parseFloat($(this).attr("for"));
        });
        
        $("#id_nazione").change(function(){ 

         if($('#id_nazione option:selected').val()==106) {        
                 $('#div_reg').fadeIn();
                 $('#id_regione').prop('required',true);
                 $('#div_prov').fadeIn();
                 $('#id_provincia').prop('required',true);
                 $('#div_com').fadeIn();
                 $('#id_comune').prop('required',true);  
              }
                                                                    
         else  { $('#div_reg').fadeOut();
                 $('#id_regione').prop('required',false);
                 $('#div_prov').fadeOut();
                 $('#id_provincia').prop('required',false);
                 $('#div_com').fadeOut();
                 $('#id_comune').prop('required',false);   
               }
    });
  
    });   
        
        
        
        
   </script>     
        
</body>

</html>
