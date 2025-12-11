<?php 
include 'include/connessione.php';
include "include/lingua.php"; 
include 'include/leggi_immagine.inc.php';
			
if ($lingua == "it")
{
$title = "";
$description = "";
$titolo = "Registrati";
$h2 ="Registrazione eseguita con successo";
$testo = "
<p>
Complimenti ti sei registrato con successo al sito www.sekurbox.com.<br />
Adesso puoi eseguire il <a href='http://www.sekurbox.com/it/login.html'>Login</a> per acquistare in maniera pi&ugrave; veloce. I dati per accedere sono quelli che hai scelto in fase di registrazione. Ti abbiamo anche inviato un'email da conservare con le credenziali di accesso al sito.
</p>
";
}
else
{
$title = "";
$description = "";
$titolo = "Guida all'acquisto";
$h2 ="Come acquistare su www.sekurbox.com";
$testo = "
<p>
</p>                
";
} 
include 'include/head.php'; 
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
                    <div id="stile_titolo_pagina"><?php echo $note_legali;?></div>
                    <div id="briciole_di_pane">                    	
                    	<a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $titolo; ?>
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
                    <?php $pagina="registrati"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                 <h2><?php echo $h2; ?></h2>
                 <?php echo $testo; ?>
            </div>
      </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
</body>
</html>        