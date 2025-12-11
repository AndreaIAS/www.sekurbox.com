<?
require ("config.php");

   $filename="utenti.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
   
   
   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it><head>
<title>Esportazione utenti in excel</title></head>
<body>
<table border="1">
<tr>
    <td>Email</td><td>Nome</td><td>Telefono</td><td>Cellulare</td>
</tr>
<?

 
                 
                
                $db->query("SELECT bag_utenti.*
                          FROM 
                          bag_utenti
                          WHERE  bag_utenti.newsletter='s' 
                          AND bag_utenti.importato='n' 
                          ");
                
                $result =  $db->resultSet();
  foreach ($result as $list) { 
      
      $db->query( "UPDATE bag_utenti
                   SET importato='s' 
                   WHERE  bag_utenti.id='".$list['id']."'
                          ");
                
      $db->execute();
      
      ?>

<tr><td><?=$list['email'];?></td><td><?=$list['nome']." ".$list['cognome'];?></td><td><?=$list['telefono']?></td><td><?=$list['cellulare']?></td></tr>
   
<?php }
?>
</table>
</body></html>