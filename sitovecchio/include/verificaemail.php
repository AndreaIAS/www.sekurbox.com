<?php
	require '../Admin/include/db.inc.php';
	
	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$email = $_REQUEST["email"];

// VERIFICATION
$result = mysql_query('SELECT email FROM clienti WHERE email="'.$email.'"');

if(mysql_num_rows($result)>=1)
        {
        echo "false";
        }
else
        {
        echo "true" ;
        }

mysql_free_result($result);
mysql_close($db);