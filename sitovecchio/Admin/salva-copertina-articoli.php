<?php 
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
$id_articolo = $_GET["id_articolo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include 'include/head.php';?></title>
</head>

<body>
<?php
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'articoli.php';
function svuota_cartella($dirpath) {  
$handle = opendir($dirpath);  
while (($file = readdir($handle)) !== false) {  
echo "Cancellato: " . $file . "<br/>";  
@unlink($dirpath . $file);  
}  
closedir($handle);  
} 
svuota_cartella("../images/miniature/articoli" . "/" . "$id_articolo" . "/");
$minia = "../images/miniature/articoli" . "/" . "$id_articolo";
//se la cartella non esiste, la creo.. se esiste no... 
if(!is_dir($minia)) 
    { 
        mkdir("../images/miniature/articoli" . "/" . "$id_articolo", 0777, true); 
    }  
//vai col ciclo.. 

if(isset($_FILES['miniatura'])) 
{ 
$file=$_FILES['miniatura']; 
$nome= $file['name']; 
//QUESTA INVECE LA DEVI DICHIARARE QUA PERCHè $nome è DIVERSO PER TUTTI. 
$path= "grandi" . "/" . "$nome"; 
//echo $nome; 
$vett=explode("/",$file['type']); 
$tipo=$vett[0]; 
if($tipo!="image"){}//non mi carico file che non sono immagini
else 
{ 
move_uploaded_file($file['tmp_name'],$path) or die("errore upload, controllare percorso"); 
print"immagine $num caricata con successo; <br />"; 
//il ridimensionamento devo farlo qua, sennò si perde i NOMI DELLE VARIABILI DELLE PATH!!! 
$dim = 253; 
list($width, $height, $type, $attr) = getimagesize($path); 
// Creo la versione 150*n dell'immagine (thumbnail) 
$numero = ($dim/$width); 
$thumb = imagecreatetruecolor($width*$numero, $height*$numero); 
$source = imagecreatefromjpeg($path); 

imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width*$numero, $height*$numero, $width, $height); 
// Salvo l'immagine ridimensionata 
imagejpeg($thumb, $minia . "/" .$nome, 100); // 65 è la qualità dell'immagine, da 0 a 100 
if(file_exists($minia . "/" .$nome)) { 
	echo "miniatura ridimensionata e salvata<br>";
	$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'articoli.php';
	header ('Refresh: 1; URL=' . $redirect);
	echo "<img src='img/loaders/1d_2.gif'> Immagine ridimensionata e salvata<br />";  
	echo 'Se la pagina non viene visualizzata, <a href="' . $redirect . '">clicca qui</a>.</p></body>';
	die();			   		   
               } else { 
                echo "<br>ATTENZIONE!! MINIATURA NON CREATA!!!<br>"; 
               } 
}//fine caricamento 

} 

?>

<?php mysql_close($db); ?>
</body>
</html>