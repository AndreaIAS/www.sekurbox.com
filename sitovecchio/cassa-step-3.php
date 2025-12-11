<?php 
include 'include/connessione.php';
include "include/lingua.php"; 	
include 'include/leggi_immagine.inc.php';
		
if ($lingua == "it")
{
$title = "";
$description = "";
}
else
{
$title = "";
$description = "";
} 
include 'include/head.php';

if(!isset($_SESSION['user'])){ header("Location: http://www.sekurbox.com/".$lingua."/cassa-step-1.html");}

$session = session_id();
?>
<script type="text/javascript">
		function rb_controllo(){
			//CONTROLLO SPEDIZIONE
			var rb_scelto = false;
			for (counter = 0; counter < document.myform.id_spesa_di_spedizione.length; counter++) {
				if (document.myform.id_spesa_di_spedizione[counter].checked) 
					rb_scelto = true;
			}
			if (!rb_scelto) {
				alert("Selezionare un metodo di spdizione");
				return (false);
			}
			//CONTROLLO PAGAMENTO
			var rb_scelto = false;
			for (counter = 0; counter < document.myform.id_metodo_pagamento.length; counter++) {
				if (document.myform.id_metodo_pagamento[counter].checked) 
					rb_scelto = true;
			}
			if (!rb_scelto) {
				alert("Selezionare un metodo di pagamento");
				return (false);
			}
			return (true);
		}
	</script>
<head>
<body>
<div id="contenuto">
	<div id="contenuto2">
    	<div id="top">
			<?php include 'include/top.php'; ?>
        </div>
        <div id="testata">
			<?php include 'include/testata.php'; ?>
        </div>
		<div class="row_top">
        	<div id="titolo_pagina_sn">
                <div id="titolo_pagina">
                    <div id="stile_titolo_pagina"><?php echo $carrello;?></div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $carrello;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row_content">
				<div class="box_step_cassa">
                	<div class="box_step_cassa_spento"><?php echo $step_1;?></div>
                	<div class="box_step_cassa_acceso"><?php echo $step_2;?></div>
                	<div class="box_step_cassa_spento"><?php echo $step_3;?></div>
                </div>
                <form method="post" name='myform' action="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-4.html" onSubmit="return rb_controllo()">                
                <div id="colonna_sn_form">
                    <div class="form">
                        <?php include 'include/form-1-step-3.php'; ?>
                    </div>                
                </div>
                 <div id="carrello_ds_fix">                                              
                    <div id="carrello_ds">
                        <div id="carrello_ds_intestazione"><?php echo $il_tuo_carrello;?></div>
                        <?php include 'include/carrello-destra.php'; ?>
                        <div id="carrello_ds_action">
                            <div id="continua"><input type="submit" value="<?php echo $invia_ordine;?>" name="continua" class="continua_step" /></div>
                        </div>                
                    </div>
                </div>
                </form>        
        </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
</body>
</html> 