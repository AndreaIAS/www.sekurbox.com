<?php
 
$dir = "images/banner_" . $lingua . ""; // Senza slash finale
 
$img = array();
$img = glob($dir."/*");
 
$con = count($img)-1;
$ran = rand(0,$con);
 
//echo "<img src=\"http://www.sekurbox.com/".$img[$ran]."\" alt=\"\" />";
 
?>
