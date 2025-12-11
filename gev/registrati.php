<?php
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
				<h3 class="pull-left">Login/Registrati</h3>
				<ul class="nav-breakcrumb  pull-right">
					<li><a href="<?=BASE_URL;?>index.php">Home</a></li>
					<li><span>Login/Registrazione</span></li>
				</ul>

			</div>
		</section>
		<!-- END BREAKCRUMB -->
                
                <!-- LOGIN REGISTER -->
		<section class="login-register">
			<div class="container">
				<div class="row">

					<!-- LOGIN -->
					<div class="col-md-6">

                                            <?php if(!isset($_SESSION['user'])) { ?>
                                            
						<div class="heading _two text-left">
							<h2>Login/Area privata</h2> 
                                                        <div id="errmesslogin"></div> 
						</div>
                                                 
					      <div class="form login ">
                                               <form id="form_login" action="javascript:void(null)" method="post" >
                                                    
                                                        <input type="hidden" name="function" value="login" >
                                                        
							<label>Indirizzo Email  <sup>*</sup></label>
							<input type="email" name="email" id="email" class="input-text" required>

							<label>Password <sup>*</sup></label>
							<input type="password" name="password" id="password" class="input-text" required>
							
<!--							<div class="check-box">
								<input type="checkbox" class="checkbox" id="remenber">
								<label for="remenber">Remember Me</label>
							</div>-->

							<p>
								<a href="<?=BASE_URL;?>recuperapwd.php">Password dimenticata?</a>
							</p>

							<button class="btn btn-13 btn-submit text-uppercase">Login</button>
                                                   </form>
                                                  
                                            <?php } else { ?>
                                                  
                                                  <div class="heading _two text-left">
							<h2>Benvenuto <?=$_SESSION['nome'];?></h2> 
						  </div>
                                                 
					      <div class="form login ">
                                                  - <a href="<?=BASE_URL;?>modificadati.php">Modifica dati personali</a>  <br />
                                                  - <a href="<?=BASE_URL;?>change_pwd.php">Modifica password</a>  <br />
                                                  - <a href="<?=BASE_URL;?>ordini.php">I tuoi ordini</a>  <br />
                                                  - <a href="<?=BASE_URL;?>index.php?logout">Logout</a>  <br />                                           
                                                  
                                                
                                                  </div>  
                                             <?php } ?>         
                                                   
							<div class="btn-group">

							</div>
						</div>

					</div>
					<!-- END LOGIN -->
					
					<!-- REGISTER -->
					<div class="col-md-6">

						<div class="heading _two text-left">
							<h2>Crea un nuovo account</h2>
						</div>

						<div class="form login ">
                                                    
                                                    <form id="form_registrazione" action="javascript:void(null)" method="post" >
                                                        <input type="hidden" name="function" value="registrati" >
                                                        <div class="cart-collaterals"> 
                                                        <label>Tipologia <sup>*</sup></label>
                                                        <select name="tipologia" id="tipologia">
                                                            <option value="azienda">Azienda</option>
                                                            <option value="privato" selected="selected">Privato</option>
                                                            <option value="ente_pubblico" >Ente pubblico</option>
                                                        </select>
                                                        </div>
                                                        
                                                        <label>Nome  <span id="nomeref" style="display:none;">Referente</span><sup>*</sup></label>
							<input type="text" name="nome" class="input-text" required>
                                                        
                                                       
                                                        <label>Cognome <span id="cognref" style="display:none;">Referente</span><sup>*</sup></label>
							<input type="text" name="cognome" id="cognome" class="input-text" required>
                                                        
                                                        
							<label>Email <sup>*</sup></label>
							<input type="email" class="input-text" name="email" required <?php if(isset($_POST['newsletter'])) echo 'value="'.$_POST['newsletter'].'"';?>>

							<label>Password<sup>*</sup></label>
							<input type="password"  name="password" id="password2" class="input-text" required>

							<label>Conferma password<sup>*</sup></label>
							<input type="password" name="confpass" class="input-text" data-equal-id="password2" required>
                                                        
                                                        <div id="divragsoc" style="display:none">
                                                            <label><span id="ragsoc">Ragione Sociale</span><span id="nomeente" style="display:none;">Nome ente</span> <sup>*</sup></label>
                                                            <input type="text" class="input-text" id="ragione" name="ragione" >
                                                        </div>
                                                        <div id="divpiva" style="display:none">
                                                            <label>P.Iva<sup>*</sup></label>
                                                            <input type="text"  name="p_iva" id="p_iva" class="input-text" >
                                                        </div>
                                                        
                                                        <div id="divcodfisc" >
							<label>Codice Fiscale<sup>*</sup></label>
							<input type="text" name="cod_fiscale" id="cod_fiscale" class="input-text" >
                                                        </div>
                                                        
                                                        <div class="cart-collaterals"> 
                                                        <label>Nazione <sup>*</sup></label>
                                                        <select name="id_nazione"  required id="id_nazione" onchange="jQuery('#provincia').load('funzioni/registrazione.php #data',{function:'provincereg',id_regione:jQuery(this).val()});">
                                                            <option value="">Scegli Nazione</option>   
                                                             <?php

                                                            $db->query("SELECT *
                                                                        FROM  
                                                                        nazioni
                                                                        ORDER by id
                                                                       ");
                                                           $recordr = $db->resultset();   
                                                           foreach ($recordr as $list) {
                                                           ?> 
                                                           <option value="<?=$list['id'];?>" ><?=$list['nome'];?></option>
                                                           <?php } ?>
                                                        </select>
                                                        </div>
                                                        
                                                        <div class="cart-collaterals"> 
                                                        <label>Regione <sup>*</sup></label>
                                                        <select name="id_regione" required id="id_regione" onchange="jQuery('#provincia').load('funzioni/registrazione.php #data',{function:'provincereg',id_regione:jQuery(this).val()});">
                                                           <option value="">Scegli Regione</option> 
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
                                                        <div id="provincia" ></div>
                                                        <div id="comune" ></div>
                                                        
                                                        <label>Indirizzo <sup>*</sup></label>
							<input type="text" class="input-text" name="indirizzo" required>
                                                        
                                                        <label>CAP<sup>*</sup></label>
							<input type="text"  name="cap" class="input-text" required>
                                                        
                                                        <label>Telefono*</label>
							<input type="text"  name="telefono" class="input-text" required>
                                                        
                                                        <label>Cellulare</label>
							<input type="text"  name="cellulare" class="input-text" >
                                                        
                                                        <label>Informativa sulla privacy ai sensi della Legge n. 675/96 sulla tutela dei diritti personali:</label>
                                                        <textarea class="input-text" style="text-align: left;height: 150px;font-size:11px;">
Gentile Signore/a,

desideriamo informarLa che il D.lgs. n. 196 del 30 giugno 2003 ("Codice in materia di protezione dei dati personali") prevede la tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali.

Secondo la normativa indicata, tale trattamento sarà improntato ai principi di correttezza, liceità e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti.

Ai sensi dell'articolo 13 del D.lgs. n.196/2003, pertanto, Le forniamo le seguenti informazioni:

1. I dati da Lei forniti verranno trattati per le seguenti finalità: a. raccolta e conservazione dei Suoi dati personali al fine della fornitura del servizio e per fornire all'Autorità Giudiziaria le informazioni eventualmente richieste; b. raccolta, conservazione ed elaborazione dei Suoi dati personali per scopi amministrativo - contabili, compresa l'eventuale trasmissione di fatture commerciali;


2. Il trattamento sarà effettuato con le seguenti modalità: il trattamento avverrà con modalità totalmente automatizzate.

3. Il conferimento di alcuni dati è obbligatorio, per le finalità di conclusione del contratto. L'eventuale rifiuto di fornire i dati obbligatori comporta la mancata prosecuzione del rapporto.

4. I dati non saranno comunicati ad altri soggetti, nè saranno oggetto di diffusione

5. Il titolare e responsabile del trattamento è: marestore.it.

6. In ogni momento potrà esercitare i Suoi diritti nei confronti del titolare del trattamento, ai sensi dell'art.7 del D.lgs.196/2003, che per Sua comodità riproduciamo integralmente:

Decreto Legislativo n.196/2003,
Art. 7 - Diritto di accesso ai dati personali ed altri diritti

1. L'interessato ha diritto di ottenere la conferma dell'esistenza o meno di dati personali che lo riguardano, anche se non ancora registrati, e la loro comunicazione in forma intelligibile.

2. L'interessato ha diritto di ottenere l'indicazione:

a) dell'origine dei dati personali;
b) delle finalità e modalità del trattamento;
c) della logica applicata in caso di trattamento effettuato con l'ausilio di strumenti elettronici;
d) degli estremi identificativi del titolare, dei responsabili e del rappresentante designato ai sensi dell'articolo 5, comma 2;
e) dei soggetti o delle categorie di soggetti ai quali i dati personali possono essere comunicati o che possono venirne a conoscenza in qualità di rappresentante designato nel territorio dello Stato, di responsabili o incaricati.

3. L'interessato ha diritto di ottenere:

a) l'aggiornamento, la rettificazione ovvero, quando vi ha interesse, l'integrazione dei dati;
b) la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non è necessaria la conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;
c) l'attestazione che le operazioni di cui alle lettere a) e b) sono state portate a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai quali i dati sono stati comunicati o diffusi, eccettuato il caso in cui tale adempimento si rivela impossibile o comporta un impiego di mezzi manifestamente sproporzionato rispetto al diritto tutelato.

4. L'interessato ha diritto di opporsi, in tutto o in parte:

a) per motivi legittimi al trattamento dei dati personali che lo riguardano, ancorchè pertinenti allo scopo della raccolta;
b) al trattamento di dati personali che lo riguardano a fini di invio di materiale pubblicitario o di vendita diretta o per il compimento di ricerche di mercato o di comunicazione commerciale.            
                                                        </textarea>
                                                        
                                                        <input type="checkbox" name="privacy" required>
                                                         Ho preso visione ed accetto l'informativa ai sensi della Legge n. 675/96 sulla tutela dei diritti personali.
                                                         <br /><br />
                                                         
                                                        <input type="checkbox" name="newsletter" >Voglio ricevere la newsletter di Gevenit.com
                                                        <br /><br /><br />
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
    
      $('[data-equal-id]').bind('input', function() {
          var to_confirm = $(this);
         var to_equal = $('#' + to_confirm.data('equalId'));

            if(to_confirm.val() != to_equal.val())
                this.setCustomValidity('Le due password devono essere uguali');
            else
                this.setCustomValidity('');
          });
          
          
   
          
          
    
    $("#tipologia").change(function(){ 
        
        if($('#tipologia option:selected').val()=='azienda'){  $('#nomeente').fadeOut();$('#cognref').fadeOut();$('#nomeref').fadeOut();$('#ragsoc').fadeIn();
                                                               $('#divragsoc').fadeIn();$('#ragione').prop('required',true);
                                                               $('#divcodfisc').fadeOut();$('#cod_fiscale').prop('required',false);
                                                               $('#divpiva').fadeIn();$('#p_iva').prop('required',true);
                                                            }
        else if($('#tipologia option:selected').val()=='privato') {    $('#nomeente').fadeOut();$('#cognref').fadeOut();$('#nomeref').fadeOut();$('#ragsoc').fadeIn();
                                                                       $('#divragsoc').fadeOut();$('#ragione').prop('required',false);
                                                                       $('#divpiva').fadeOut();$('#p_iva').prop('required',false);
                                                                       $('#divcodfisc').fadeIn(); $('#cod_fiscale').prop('required',true); 
                                                                      
                                                                    }
        else  {  $('#nomeente').fadeIn();$('#cognref').fadeIn();$('#nomeref').fadeIn();$('#ragsoc').fadeOut();
                 $('#ragione').prop('required',true);
                 $('#divpiva').fadeIn();$('#p_iva').prop('required',true);
                 $('#divcodfisc').fadeIn(); $('#cod_fiscale').prop('required',true);
                 
              }
    });
    

    $("#form_registrazione").submit(function(){  

         $.post("<?=BASE_URL;?>functionload.php",jQuery("#form_registrazione").serialize(),              
              function(data) {    
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                                if(data.campo=="email"){$('#errmess').html('<span style="color:red;">Attenzione email già presente. Inserire un indirizzo email diverso.</span>');} 
                                else { $('#errmess').html('<span style="color:red;">Errore in invio mail di registrazione</span>');  }
                            }  
                             else {                                
                // alert(data.campo);
                $('#form_registrazione').fadeOut();
                $('#errmess').html('<span style="color:green;">Registrazione effettuata correttamente.<br />Attivo il tuo account, dalla mail che ti abbiamo inviato.<br />\n\
            Controlla anche la cartella della posta indesiderata.</span>');
               // setTimeout(function(){window.location.href = "<?php echo BASE_URL;?>index.php";},5000);                                     
                               }                                              
                             },              
              "json");       
                  });
                  
      $("#form_login").submit(function(){  

         $.post("<?=BASE_URL;?>functionload.php",jQuery("#form_login").serialize(),              
              function(data) {    
                            //Se ci sono errori in fase di registrazione 
                            if(data.errore!='no'){
                                $('#errmesslogin').html('<span style="color:red;">Attenzione, dati errati o account ancora non attivato.</span>');
                            }  
                             else {                                
                setTimeout(function(){window.location.href = "<?php echo $_SERVER['HTTP_REFERER'] ;?>"},500);                                     
                               }                                              
                             },              
              "json");       
                  });            
 
});
</script>
                