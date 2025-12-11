<?php 
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
$id_prodotto = $_GET["id_prodotto"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
function svuota_cartella($dirpath) {  
$handle = opendir($dirpath);  
while (($file = readdir($handle)) !== false) {  
//echo "Cancellato: " . $file . "<br/>";  
@unlink($dirpath . $file);  
}  
closedir($handle);  
}
 
svuota_cartella("../images/galleria/prodotti" . "/" . "$id_prodotto" . "/");
$galleria = "../images/galleria/prodotti/" . "$id_prodotto";
svuota_cartella("../images/miniature/prodotti" . "/" . "$id_prodotto" . "/");
$miniatura = "../images/miniature/prodotti/" . "$id_prodotto";


if(isset($_FILES['foto'])) 
{ 
$file=$_FILES['foto']; 
$nome= $file['name']; 
$path="grandi/" . "$nome"; 
$vett=explode("/",$file['type']); 
$tipo=$vett[0]; 
if($tipo!="image")
{
}
else 
{ 
move_uploaded_file($file['tmp_name'],$path) or die("errore upload, controllare percorso"); 
$dim = 400; 
list($width, $height, $type, $attr) = getimagesize($path); 
$numero = ($dim/$width); 
$thumb = imagecreatetruecolor($width*$numero, $height*$numero); 
$source = imagecreatefromjpeg($path); 
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width*$numero, $height*$numero, $width, $height); 
imagejpeg($thumb, $galleria . "/" .$nome, 100);

$path = $galleria . "/" . $nome; 
$dim =130; 
list($width, $height, $type, $attr) = getimagesize($path); 
$numero = ($dim/$width); 
$thumb = imagecreatetruecolor($width*$numero, $height*$numero); 
$source = imagecreatefromjpeg($path); 
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width*$numero, $height*$numero, $width, $height); 
imagejpeg($thumb, $miniatura . "/" .$nome, 100);

header('Location: http://www.sekurbox.com/Admin/update/modifica_prodotto.php?id_prodotto=' . $id_prodotto);  
}
} 
?>

<?php mysql_close($db); ?>
</body>
</html>