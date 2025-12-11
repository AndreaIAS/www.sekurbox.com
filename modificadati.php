<?php

include("inc_config.php");


if( !isset($_SESSION['user_site'])){
    header("Location: index.php");
}

$title_it="Sekurbox.com | Modifica dati personali.";
$description_it="Modifica dati personali.";


$title_en="Sekurbox.com | Modify account data.";
$description_en="Modify account data.";

include("inc_header.php");
?>

<meta name="robots" content="noindex">
</head>

<body>
 <div class="wrapper-area">
        
    <?php  
    include("inc_menu.php");  
    ?>
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?=$lang['personal_data'];?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=$lang['personal_data'];?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Login Registration Page Area Start Here -->
        <div class="login-registration-page-area">
            <div class="container">
                <div class="row">
                  
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                     
                                   <?php                 
                                    $db->query("SELECT * FROM bag_utenti WHERE id='".$_SESSION['user_site']."' ");
                                    $list=$db->single();
                                    ?>   
                        
                        <div class="login-registration-field">
                            <h2 class="cart-area-title"><?=$lang['personal_data'];?></h2>
                            
                <form id="checkout-form" action="javascript:void(null)" method="post" >
                                 
                          <input type="hidden" name="function" value="editutente" >
                           <input type="hidden" name="id" value="<?=$list['id'];?>" >

                        <div class="cart-collaterals" style="margin-bottom:10px;"> 
                           <label>Tipologia: <?=$list['tipologia'];?></label> 
                        </div>
                                
                                
                            <label>Nome <sup>*</sup></label>
                            <input type="text" name="nome" class="input-text" value="<?=$list['nome'];?>" required>


                            <label>Cognome <span id="cognref" style="display:none;">Referente</span><sup>*</sup></label>
                            <input type="text" name="cognome" id="cognome" class="input-text" value="<?=$list['cognome'];?>" required>

                            <?php if($list['tipologia']!='privato'){ ?>
                            
                            <div id="divragsoc"  class="cart-collaterals" style="display:none">
                             <label><span id="ragsoc">Ragione Sociale</span>
                             <sup>*</sup></label>
                             <input type="text" class="input-text" id="ragione" name="ragione" value="<?=$list['ragione'];?>" >
                            </div>
                            <div id="divpiva" style="display:none">
                                <label>P.Iva<sup>*</sup></label>
                                <input type="text"  name="p_iva" id="p_iva" class="input-text"  value="<?=$list['p_iva'];?>">
                            </div>
                            <input type="hidden" name="cod_fiscale"  value=""> 
                            <?php } else{ ?>
                            <input type="hidden" name="ragione"  value="">    
                              <input type="hidden" name="p_iva"  value="">  
                             

                            <div id="divcodfisc" >
                            <label>Codice Fiscale<sup>*</sup></label>
                            <input type="text" name="cod_fiscale" id="cod_fiscale" class="input-text"  value="<?=$list['cod_fiscale'];?>">
                            </div>
                            
                              <?php } ?>

                           <div class="cart-collaterals" > 
                            <label>Nazione <sup>*</sup></label>
                            <select name="id_nazione"  required id="id_nazione" class="select2">
                                <option value="">Scegli Nazione</option>   
                                 <?php

                                $db->query("SELECT *
                                            FROM  
                                            nazioni
                                            ORDER by id
                                           ");
                               $recordr = $db->resultset();   
                               foreach ($recordr as $listn) {
                               ?> 
                               <option value="<?=$listn['id'];?>" <?php if($listn['id']==$list['id_nazione']) echo 'selected="selected"'; ?> ><?=$listn['nome_'.$lng];?></option>
                               <?php
                               } 
                               ?>
                            </select>
                            </div>

                        <div class="form-group" style="margin-top:10px;" id="div_reg">
                        <label class="control-label" for="id_regione">Regione</label>
                        <div class="cart-collaterals" >

                            <?php
                                                        
                              $db->query("SELECT regioni.id AS idreg, province.id AS idprov,
                                          comuni.id AS idcom
                                          FROM  
                                          regioni
                                          INNER JOIN province ON province.id_regione=regioni.id
                                          INNER JOIN comuni on comuni.id_provincia=province.id
                                          AND comuni.id='".$list['id_comune']."'
                                           ");
                              $recordallid = $db->single();

                            ?>
                            
                            
                          <select name="id_regione" required class="select2" id="id_regione" 
                              onchange="jQuery('#provincia').load('functionload.php #data',{function:'provincereg',id_regione:jQuery(this).val()},
                                                  function(){$('.select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '100%'
                                             });});" >
                               <option value="">Scegli Regione</option> 
                                <?php
                                $db->query("SELECT *
                                            FROM  
                                            regioni
                                            ORDER by nome
                                           ");
                               $recordr = $db->resultset();   
                               foreach ($recordr as $listr) {
                               ?> 
                               <option value="<?=$listr['id'];?>" <?php if($listr['id']==$recordallid['idreg']) echo 'selected="selected"'; ?>><?=$listr['nome'];?></option>
                               <?php } ?>
                          </select>
                            
                        </div>
                        </div>
                            
                        <div class="cart-collaterals" style="margin-bottom:10px;" id="div_prov">
                        <label>Provincia <sup>*</sup></label>    
                        <select required name="id_provincia" style="width:100%" class="select2" 
                             onchange="jQuery('#comune').load('functionload.php #data',{function:'comunireg',id_provincia:jQuery(this).val()},
                                         function(){$('.select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '100%'
                                             });});" >
                            <?php
                                 $db->query("SELECT * 
                                             FROM 
                                             province
                                             WHERE id_regione='".$recordallid['idreg']."'
                                             ORDER BY nome");

                                $records = $db->resultset();
                                foreach ($records as $listp){ ?>
                                <option value="<?=$listp['id'];?>" <?php if($listp['id']==$recordallid['idprov']) echo 'selected="selected"'; ?>><?=$listp['nome'];?></option>
                                <?php } ?>
                            </select>
                        </div> 
                            
                        <div class="cart-collaterals" style="margin-bottom:10px;" id="div_com">
                            <label>Comune <sup>*</sup></label>      
                                <select required style="width:100%" name="id_comune"  class="select2">
                                    <option value="">Comune</option>
                                    <?php
                                     $db->query("SELECT * 
                                                 FROM 
                                                 comuni
                                                 WHERE id_provincia='".$recordallid['idprov']."' 
                                                 ORDER BY nome");

                                    $records = $db->resultset();
                                    foreach ($records as $listc){?>
                                    <option value="<?=$listc['id'];?>"  <?php if($listc['id']==$recordallid['idcom']) echo "selected='selected'"; ?>><?=$listc['nome'];?></option>
                                    <?php } ?>

                                </select>
                        </div>     

                            <label>Indirizzo <sup>*</sup></label>
                            <input type="text" class="input-text" name="indirizzo" required value="<?=$list['indirizzo'];?>">

                            <label>CAP<sup>*</sup></label>
                            <input type="text"  name="cap" class="input-text" required value="<?=$list['cap'];?>">

                            <label>Telefono*</label>
                            <input type="text"  name="telefono" class="input-text" required value="<?=$list['telefono'];?>">

                            <label>Cellulare</label>
                            <input type="text"  name="cellulare" class="input-text" value="<?=$list['cellulare'];?>">
                             <br /><br />
                                                         

                                                        <button class="btn-send-message disabled" type="submit" value="Login"><?=$lang['aggiorna'];?></button>
                            </form>
                             <div id="errmess"></div>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Registration Page Area End Here -->
        <!-- Footer Area Start Here -->
    <?php  
    include("inc_footer.php");  
     ?>    
          
        </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

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
    
      <?php include("script_condivisi.php"); ?>
    
    
<script>
    
$(document).ready(function() {
    
      $('[data-equal-id]').bind('input', function() {
          var to_confirm = $(this);
         var to_equal = $('#' + to_confirm.data('equalId'));

            if(to_confirm.val() != to_equal.val())
                this.setCustomValidity('Le due password devono essere uguali');
            else
                this.setCustomValidity('');
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
    

    $("#checkout-form").submit(function(){  

         $.post("<?=BASE_URL;?>functionload.php",jQuery("#checkout-form").serialize(),              
              function(data) {    
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                               
                            }  
                             else {                                
                // alert(data.campo);
                $('#checkout-form').fadeOut();
                $('#errmess').html('<span style="color:green;margin-left:0px;">Aggiornamento dati effettuato correttamente.</span>');
              setTimeout(function(){window.location.href = "<?php echo BASE_URL;?>index.php";},7000);                                     
                               }                                              
                             },              
              "json");       
                  });
                  
           
 
});
$('.select2').select2({
            theme: 'classic',
            dropdownAutoWidth: true,
            width: '100%'
 });
</script>
    
</body>

</html>
