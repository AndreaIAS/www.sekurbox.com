<?php
	require '../Admin/include/db.inc.php';
	
	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$codice = $_POST["codice_esterno"];
$tipologia = $_POST["tipologia"];

if($codice!=''){
    
  if ($tipologia==1){
     
      $result = mysql_query('SELECT codice_per_privato FROM clienti WHERE attivo="si" AND codice_per_privato="'.$codice.'"');
      if(mysql_num_rows($result)==0){ echo "false"; }
      else{echo "true" ;}
      
  } else if($tipologia==2){
      
       $result = mysql_query('SELECT codice_per_installatore FROM clienti WHERE attivo="si" AND codice_per_installatore="'.$codice.'"');
      if(mysql_num_rows($result)==0){ echo "false"; }
      else{echo "true" ;}
      
  } else {echo "true" ;} 
  
                 }
else echo "true";


