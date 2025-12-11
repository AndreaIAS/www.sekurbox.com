<?php 

if(!isset($_REQUEST['id_ordine'])){ exit();die();}

include("inc_config.php");

     $db->query("SELECT * 
                 FROM 
                 bag_ordini
                 WHERE id='".$_REQUEST['id_ordine']."' 
                ");
     $ordine = $db->single();
     
     $db->query("SELECT * 
                 FROM 
                 bag_det_ord
                 INNER JOIN bag_prodotti ON bag_prodotti.id=bag_det_ord.id_articolo
                 WHERE id_ordine='".$_REQUEST['id_ordine']."' 
                ");
     $articoli = $db->resultset();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ordine</title>
<style>
body 
{
margin:0px;
background:#FFF;
font-family:Calibri,Arial, Helvetica, sans-serif;
}
img
{
border:none;
text-decoration:none;
}
div#container 
{  
margin:0 auto 0 auto;
width:100%;
}
#content
{
margin:0 auto;
width:100%;
height:auto;
float:left;
padding-bottom:30px;
background:#f3f1f1;
}
#content_fix
{
margin:0 auto;
width:800px;
height:auto;
}
#content h2
{
/*width:1100px;*/
width:100%;
height:20px;
float:left;	
font-size:20px;
color:#0a0c09;
margin:20px 0 10px 0;
}
#ricevuta
{
/*width:1060px;*/
width:95%;
height:auto;
float:left;
padding:5px 2.5%;
background:#FFF;
color:#0a0c09;
font-size:18px;
}
#ricevuta_alert
{
/*width:1040px;*/
width:100%;
height:auto;
float:left;
border:#d72c38 2px dotted;
padding:10px;
}
#carrello
{
/*width:1100px;*/
width:100%;
height:auto;
float:left;
}
.intestazione_tab_carrello
{
/*width:1100px;*/
width:100%;
height:30px;
float:left;
background:#009392;
color:#FFF;
margin:5px 0 0 0;
font-size:16px;
padding-top:5px;
text-align:center;
}
.intestazione_tab_carrello_prodotto
{
width:70%;
height:30px;
float:left;
}
.intestazione_tab_carrello_prezzo
{
width:10%;
height:30px;
float:left;
}
.intestazione_tab_carrello_sconto
{
width:10%;
height:30px;
float:left;
}
.intestazione_tab_carrello_totale
{
width:10%;
height:30px;
float:left;
}
.carrello_box_prodotto
{
/*width:1100px;*/
width:100%;
height:60px;
float:left;
margin:3px 0 0 0;
text-align:center;
font-size:18px;
color:#322a7c;
background:#FFF;
padding: 5px 0;
}
.carrello_prodotto
{
width:685px;
height:100px;
float:left;
}
.carrello_prodotto_img
{
width:10%;
height:100px;
float:left;
}
.carrello_prodotto_titolo
{
width:60%;
height:100px;
float:left;
margin-left:10px;
}
.carrello_prodotto_titolo a
{
font-size:18px;
color:#322a7c;
text-decoration:none;	
}
.carrello_prodotto_prezzo
{
width:10%;
height:100px;
float:left;
}
.carrello_prodotto_sconto
{
width:10%;
height:100px;
float:left;
}
.carrello_prodotto_totale
{
width:10%;
height:100px;
float:left;
}
#carrello_totale
{
/*width:1100px;*/
width:100%;
height:auto;
float:left;
background:#f2f2f2;
color:#322a7c;
margin:10px 0 20px 0;
font-size:18px;
padding-top:5px;
background:#FFF;
}
.carrello_totale_sn
{
/*width:900px;*/
width:70%;
height:30px;
float:left;
text-align:right;
}
.carrello_totale_ds
{
/*width:150px;*/
width:20%;
height:30px;
float:left;
text-align:right;
margin-right:50px;
}
</style>
</head>   
<body> 	
	<div id="container">
		<div id="content">
			<div id="content_fix">
				<h2><?=$lang['conferma_ordine'];?> numero SK<?=$_REQUEST['id_ordine'];?></h2>
				
                    <div id="ricevuta"> 
                         <img src="<?=BASE_URL;?>img/logo1.png" style="width:140px;float:right;" border="0" /><br />
                    <p>
                    Gentile Cliente,<br />
                    la ringraziamo per aver ordinato i nostri prodotti.<br />
                    Di seguito il dettaglio dell'ordine:<br /><br />
                    <strong>ID ORDINE:</strong> SK<?php echo $_REQUEST['id_ordine'];?><br />
                    <?php $data_ordine = date("d/m/Y", strtotime($ordine['data']));?>
                    <strong>DATA ORDINE:</strong> <?php echo $data_ordine;?><br /><br />
                    <strong>L'ordine verrà spedito con:</strong><br />
                    <?php echo $ordine['tipo_spedi'] . '&nbsp;(&euro; ' . $ordine['spese_spe'] . ")";?><br /><br />                            
                    <strong>Hai scelto di pagare con:</strong><br />
                    <?php echo $ordine['tipo_pagam'] . '&nbsp;(&euro; ' . $ordine['spese_pag'] . ')';?>
                    <?php
                    if($ordine['tipo_pagam']=='Carta di Credito'){  // CARTA DI CREDITO ?>
                    <br />   
                    Se ancora non hai effettuato il pagamento, puoi sempre farlo dalla tua area privata, nella sezione: <a href="<?=BASE_URL;?>ordini.php">I tuoi ordini</a>  
                    <?php } ?>
                    <br />
                    
                    </p>
                   <?php if($ordine['tipo_pagam']=='Bonifico Bancario' ){ ?>
                        <div id="ricevuta_alert">
                                <?php echo $lang['testo_pag_bon'];?>
                        </div>
                   <?php  }?>
		      </div>
	
                <div id="carrello">
                   	<div class="intestazione_tab_carrello">
                        <div class="intestazione_tab_carrello_prodotto"> <?=$lang['nome'];?></div>
                        <div class="intestazione_tab_carrello_prezzo"><?=$lang['prezzo'];?></div>
                        <div class="intestazione_tab_carrello_sconto"><?=$lang['quantita'];?></div>
                        <div class="intestazione_tab_carrello_totale"><?=$lang['totale'];?></div>
                	</div>
	<?php
        
        $totale_articoli=0;
        foreach ($articoli AS $articolo){
            $totale_articoli=$totale_articoli+($articolo['prezzo']*$articolo['qta']);
            ?>
                    
		<div class="carrello_box_prodotto">
		<div class="carrello_prodotto_img"><img src="<?=BASE_URL;?>upload/prodotti/<?=$articolo['immagine'];?>" alt="cart" style="width:80px;" class="img-responsive"></div>
		<div class="carrello_prodotto_titolo"><?php echo $articolo['nome_'.$lng]; ?></div>                
                <div class="carrello_prodotto_prezzo"><?php echo $articolo['prezzo'];?></div>
		<div class="carrello_prodotto_sconto"><?php echo $articolo['qta']; ?></div>
                <div class="carrello_prodotto_totale"><?php echo "&euro; " . number_format(($articolo['prezzo']*$articolo['qta']), 2, ',', '.');?></div>

                </div>
	<?php } ?>
                
                <div id="carrello_totale">
                    <div class="carrello_totale_sn">Imponibile</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format($totale_articoli, 2, ',', '.'); ?></div>
                     <div class="carrello_totale_sn">Iva</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format(($totale_articoli/100)*22, 2, ',', '.'); ?></div>
                    <div class="carrello_totale_sn">Spese di spedizione</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format($ordine['spese_spe'], 2, ',', '.'); ?></div>    
                    <div class="carrello_totale_sn">Spese di pagamento</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format($ordine['spese_pag'], 2, ',', '.'); ?></div> 								
                    <div class="carrello_totale_sn">TOTALE</div>
                    <div class="carrello_totale_ds">
                        &euro; <?php echo number_format((($totale_articoli/100)*22)+$totale_articoli+$ordine['spese_spe']+$ordine['spese_pag'], 2, ',', '.'); ?>
                    </div>
                </div>
               <br />  <br />  <br />
                                <div style="text-align:left;width:100%">
                                <img src="<?=BASE_URL;?>img/logo1.png" style="width:230px;" border="0" /><br />
                                &nbsp;&nbsp;Sito Internet: <a style='color: #19a9e5;' href='https://www.sekurbox.com'>Sekurbox.com</a><br />
                                &nbsp;&nbsp;Email: <a style='color: #19a9e5;' href='mailto:info@sekurbox.com'>info@sekurbox.com</a><br />  
                                </div>
               </div>                  
		</div>
	</div>
</div>
</body>
</html>