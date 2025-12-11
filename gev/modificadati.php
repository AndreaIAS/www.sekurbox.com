<?php
$referer=$_SERVER['HTTP_REFERER'];
include("inc_config.php");
include("inc_header.php");
?>

</head>
<body >
    
    <?php 
    include("inc_menu.php"); 
    ?>

    <!-- BREAKCRUMB -->
		<section class="breakcrumb bg-grey">
			<div class="container">
				<h3 class="pull-left">Modifica dati personali</h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="<?=BASE_URL;?>index.php">Home</a></li>
					<li><span>Modifica dati personali</span></li>
				</ul>
			</div>
		</section>
		<!-- END BREAKCRUMB -->
                
                	<!-- LOGIN REGISTER -->
                        <section class="login-register" style="margin-left:30px;">
			<div class="container">
				<div class="row">

				    <?php                 
                                    $db->query("SELECT * FROM bag_utenti WHERE id='".$_SESSION['user']."' ");
                                    $list=$db->single();
                                    ?>
					
					<!-- REGISTER -->
					<div class="col-md-6">

						<div class="heading _two text-left">
							
						</div>

						<div class="form login ">
                                                    
                                                    <form id="form_registrazione" action="javascript:void(null)" method="post" >
                                                        <input type="hidden" name="function" value="editutente" >
                                                        <input type="hidden" name="id" value="<?=$list['id'];?>" >
                                                        <div class="cart-collaterals"> 
                                                        <label>Tipologia: <?=$list['tipologia'];?></label> 
                                                        </div>
                                                        <br />
                                                        
                                                        <label>
                                                            Nome <?php if($list['tipologia']=='ente_pubblico'){ ?> Referente <?php } ?> <sup>*</sup></label>   
							<input type="text" name="nome" class="input-text" value="<?=$list['nome'];?>" required>
                                                        
                                                       
                                                        <label>Cognome <?php if($list['tipologia']=='ente_pubblico'){ ?> Referente <?php } ?> <sup>*</sup></label>
							<input type="text" name="cognome" id="cognome" class="input-text" required value="<?=$list['cognome'];?>">
                                                            
                                                         <?php if($list['tipologia']!='privato'){ ?>
                                                        <div>
                                                            <label><span id="ragsoc">
                                                           <?php  if($list['tipologia']=='azienda'){ ?>Ragione Sociale
                                                           <?php } else { echo "Nome ente:"; } ?>    
                                                                </span> <sup>*</sup></label>
                                                            <input type="text" class="input-text" id="ragione" name="ragione"  value="<?=$list['ragione'];?>">
                                                        </div>
                                                        <?php } else { ?> <input type="hidden" name="ragione"  value="">
                                                         <?php } ?>
                                                        
                                                         <?php if($list['tipologia']!='privato'){ ?>
                                                        <div id="divpiva">
                                                            <label>P.Iva<sup>*</sup></label>
                                                            <input type="text"  name="p_iva" id="p_iva" class="input-text"  value="<?=$list['p_iva'];?>">
                                                        </div>
                                                         <?php } else { ?> <input type="hidden" name="p_iva"  value="">
                                                         <?php } ?>
                                                         
                                                        <?php if($list['tipologia']!='azienda'){ ?>
                                                        <div id="divcodfisc" >
							<label>Codice Fiscale<sup>*</sup></label>
							<input type="text" name="cod_fiscale" id="cod_fiscale" class="input-text"  value="<?=$list['cod_fiscale'];?>">
                                                        </div>
                                                        <?php } else { ?> <input type="hidden" name="cod_fiscale"  value="">
                                                         <?php }  ?>
                                                        <label>Indirizzo <sup>*</sup></label>
							<input type="text" class="input-text" name="indirizzo" required  value="<?=$list['indirizzo'];?>">

							<div class="cart-collaterals"> 
                                                        <label>Nazione <sup>*</sup></label>
                                                        <select name="id_nazione" id="id_nazione">
                                                            <?php
                                                            $db->query("SELECT *
                                                                        FROM  
                                                                        nazioni
                                                                        ORDER by nome
                                                                       ");
                                                           $recordr = $db->resultset();   
                                                           foreach ($recordr AS $listn) {
                                                           ?> 
                                                           <option value="<?=$listn['id'];?>" <?php if($listn['id']==$list['id_nazione']) echo 'selected="selected"'; ?> >
                                                           <?=$listn['nome'];?>
                                                           </option>
                                                           <?php } ?>
                                                        </select>
                                                        </div>
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
                                                        <div class="cart-collaterals"> 
                                                        <label>Regione <sup>*</sup></label>
                                                        <select name="id_regione" id="id_regione" onchange="jQuery('#provincia').load('funzioni/registrazione.php #data',{function:'provincereg',id_regione:jQuery(this).val()});">
                                                            <?php
   
                                                          
                                                            
                                                            $db->query("SELECT *
                                                                        FROM  
                                                                        regioni
                                                                        ORDER by nome
                                                                       ");
                                                            $recordr = $db->resultset();   
                                                           foreach ($recordr as $listr) {
                                                           ?> 
                                                           <option value="<?=$listr['id'];?>" <?php if($listr['id']==$recordallid['idreg']) echo 'selected="selected"'; ?> >
                                                           <?=$listr['nome'];?>
                                                           </option>
                                                           <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div id="provincia" >
                                                            
                                                        <div class="cart-collaterals">
                                                          <label>Provincia <sup>*</sup></label>    
                                                          <select name="id_provincia" style="width:100%"  required onchange="jQuery('#comune').load('funzioni/registrazione.php #data',{function:'comunireg',id_provincia:jQuery(this).val()});" >
                                                          <option value="">Provincia</option>    
                                                           <?php
                                                             $db->query("SELECT * 
                                                                         FROM 
                                                                         province
                                                                         WHERE id_regione='".$recordallid['idreg']."'
                                                                         ORDER BY nome");

                                                            $records = $db->resultset();
                                                            foreach ($records as $listp){ ?>
                                                            <option value="<?=$listp['id'];?>" <?php if($listp['id']==$recordallid['idprov']) echo 'selected="selected"'; ?>><?=$listp['nome'];?></option>
                                                            <?php }  ?>
                                                            </select>
                                                        </div> 
                                                            
                                                            
                                                        </div>
                                                        <div id="comune" >
                                                            
                                                        <div class="cart-collaterals">
                                                            <label>Comune <sup>*</sup></label>      
                                                            <select style="width:100%" name="id_comune"  required>
                                                                <option value="">Comune</option>
                                                                <?php
                                                                 $db->query("SELECT * 
                                                                             FROM 
                                                                             comuni
                                                                             WHERE id_provincia='".$recordallid['idprov']."'
                                                                             ORDER BY nome");

                                                                $records = $db->resultset();
                                                                foreach ($records as $listc){?>
                                                                <option value="<?=$listc['id'];?>" <?php if($listc['id']==$recordallid['idcom']) echo "selected='selected'"; ?> ><?=$listc['nome'];?></option>
                                                                <?php } 


                                                                ?>
                                                            </select>
                                                        </div>    
                                                            
                                                            
                                                            
                                                        </div>
                                                        
                                                        <label>CAP<sup>*</sup></label>
							<input type="text"  name="cap" class="input-text" required  value="<?=$list['cap'];?>">
                                                        
                                                        <label>Telefono</label>
							<input type="text"  name="telefono" class="input-text"  value="<?=$list['telefono'];?>" >
                                                        
                                                        <label>Cellulare</label>
							<input type="text"  name="cellulare" class="input-text"  value="<?=$list['cellulare'];?>">
                                                  
							<button class="btn btn-13 btn-submit text-uppercase">Registrati</button>
                                                       
                                                    </form> 
                                                    <div id="errmess"></div>
						</div>

					</div>

					<!-- END REGISTER -->

				</div>
			</div>
		</section>
		<!-- END LOGIN REGISTER -->

                             
<?php
include("inc_footer.php");
?>
                
<script>
$(document).ready(function() {


    $("#form_registrazione").submit(function(){  

         $.post("<?=BASE_URL;?>functionload.php",jQuery("#form_registrazione").serialize(),              
              function(data) {    
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                         }  
                             else {                                
                // alert(data.campo);
                $('#form_registrazione').fadeOut();
                $('#errmess').html('<span style="color:green;">Aggiornamento dati effettuato correttamente.</span>');
                setTimeout(function(){window.location.href = "<?php echo $_SERVER['HTTP_REFERER'];  ?>";},5000);                                     
                               }                                              
                             },              
              "json");       
                  });
                  
         
 
});
</script>
                