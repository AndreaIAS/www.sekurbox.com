<?php
// Variabili
$nome = $_GET['img'];
$id_articolo = $_POST["id_articolo"];
$minia = "../images/galleria/articoli" . "/" . "$id_articolo";
// Cancella tutto il contenuto della cartella
function svuota_cartella($dirpath) {  
$handle = opendir($dirpath);  
while (($file = readdir($handle)) !== false) {  
//echo "Cancellato: " . $file . "<br/>";  
@unlink($dirpath . $file);  
}  
closedir($handle);  
}

svuota_cartella("../images/galleria/articoli" . "/" . "$id_articolo" . "/");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// imposto larhezza ed altezza dell'immagine ritagliata
	$targ_h = 250;
	$targ_w = 680;
	  // imposto la qualità dell'output
	$jpeg_quality = 100;
	// URL del file sorgente (immagine originale)
	$src = "grandi" . "/" . "$nome";
	  // creo l'immagine sorgente
	$img_r = imagecreatefromjpeg($src);
	  // creo la nuova immagine delle dimensioni specificate
	$dst_r = imagecreatetruecolor( $targ_w, $targ_h );
	  // creo una copia dell'immagine sorgente opportunamente ritagliata
	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);
	  // stampo a video l'output
  imagejpeg($dst_r, $minia . "/" .$nome, $jpeg_quality);
  
  
  echo "<img src='img/loaders/1d_2.gif'> Immagine ridimensionata e salvata<br />";  
  $redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'articoli.php';
 header ('Refresh: 1; URL=' . $redirect);
  echo '<p>Se la pagina non viene visualizzata, <a href="' . $redirect . '">clicca qui</a>.</p>';
}
?>