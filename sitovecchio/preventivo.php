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
if (isset($_POST['inviamail'])) 
{	
	$email = $_POST['email'];
	$nome=$_POST['nome'];
	$cognome=$_POST['cognome'];
        $messaggio=$_POST['messaggio'];
	
	require "class/class.phpmailer.php";
	//istanziamo la classe
	$messaggio = new PHPmailer();
	$messaggio->IsHTML(true);
	//$messaggio->Host='Host SMTP';
	//definiamo le intestazioni e il corpo del messaggio
	$messaggio->From=$_POST['email'];
	$messaggio->FromName = "Sekurbox-Preventivo";
	//$messaggio->AddAddress('info@sekurbox.com');
        $messaggio->AddAddress('clapton_ci@yahoo.it');
	//$messaggio->AddReplyTo('multimedia@gieffecomunicazione.com'); 
	$messaggio->Subject="Richiesta di preventivo dal sito Sekurbox.com";
	$messaggio->Body="<br />Dati mittente:<br /><br />
                          <b>Email:</b> ".$email."<br />
                              <b>Nome:</b> ".$nome."<br />
                                  <b>Cognome:</b> ".$cognome."<br /><br />
                                      <b>Messaggio:</b><br />".$messaggio;
	//$messaggio->AddAttachment('http://www.sekurbox.com/css/stile.css'); // attach style sheet
	
	//definiamo i comportamenti in caso di invio corretto 
	//o di errore
	if(!$messaggio->Send()){ 
	  echo $messaggio->ErrorInfo; 
	}else{ 
	  $messaggio_inviato=$contattiok;

	}
}    
?>


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
                    <div id="stile_titolo_pagina"><?php echo $richiediprev; ?></div>
                	<div id="briciole_di_pane">
                    	<a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $richiediprev; ?>
                    </div>                
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="contatti"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                <div class="form">
                               <?php
                                        if (isset($messaggio_inviato)) {
                                                echo "<p>" . $messaggio_inviato . "</p>";
                                        } else
                                        {
                                ?>
                                <form id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="form_intestazione"><?php echo $titolo_form_registrazione;?></div>
                               
                                    <div class="form_row"><label>Email</label></div>                       
                                    <div class="form_row"><input type="email" name="email" required 
                                    style="border: 1px solid #ccc;color: #666666;height: 30px;width: 330px;"/></div>
                                    <div class="form_row_mezzo">
                                        <div class="form_row"><label><?php echo $nome;?></label></div>                       
                                        <div class="form_row"><input type="text" name="nome"  required/></div>                        
                                    </div>
                                    <div class="form_row_mezzo">
                                        <div class="form_row"><label><?php echo $cognome;?></label></div>                       
                                        <div class="form_row"><input type="text" name="cognome" /></div>                        
                                    </div>
                                     <div class="form_row"><label><?php echo $richiesta;?></label></div>  
                                     <div class="form_row">
                                         <textarea  name="messaggio" required style="height:100px;" ></textarea>
                                     </div>
                                    <div class="form_row"></div>   
                                   
                                    
                                    <div class="form_row_button">
                                        <input class="entra" type="submit" value="<?php echo $richiediprev;?>" name="inviamail" />              
                                    </div> 
                                </form>   
                       <?php } ?>
                </div>
            </div>
      </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html>        