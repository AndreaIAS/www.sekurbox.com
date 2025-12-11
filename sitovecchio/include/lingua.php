<?php
$lingue = array(0=>'VERSIONE ITALIANA', 1=> 'ENGLISH VERSION');
$flags = array(0=>'it', 1=>'uk'); 
$lingua = $_GET['lingua'];
if (!$lingua) $lingua = "it"; // default italiano
 
 switch ($lingua)
      {
         case "it":
            include "lingue/it.php";
            break;
         case "uk":
            include "lingue/eng.php";
            break;
      }
?>