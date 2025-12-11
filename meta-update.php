<?php
/************************ YOUR DATABASE CONNECTION STARTS HERE ****************************/
	define ("DB_HOST", "localhost"); // set database host (usually localhost)
	define ("DB_USER", "Database_User"); // set database user
	define ("DB_PASS","Database_Password"); // set database password
	define ("DB_NAME","Database_Name"); // set database name
/************************ YOUR DATABASE CONNECTION ENDS HERE ****************************/

	$truncate = 160; // set number of characters in seo meta description (Consider your GLOBAL META DESCRIPTION too)

/************************ VALUES BELOW USUALLY MODIFIED FOR CC VERSIONS LESS THAN 5 ************************/
	$table	= "CubeCart_inventory"; // set database table to modify
	$desCol = "description"; // set description column
	$seoCol = "seo_meta_description"; // set seo meta description column
	$prodId = "product_id"; // set product ID column
	$nameCol = "name"; // set name column
	$keyCol = "seo_meta_keywords"; // set seo meta keywords column
/************************ END DATABASE TABLE & COLUMN ALLOCATIONS ************************/

/************************ BELOW USUALLY DOES NOT TO BE MODIFIED ****************************/
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link);
	$query	= "SELECT $desCol, $prodId, $nameCol FROM $table";
	$result = mysql_query($query, $link);
	$rows = mysql_num_rows($result);
	echo "$rows products modified.<hr /><hr /> \n";
	while(($row = mysql_fetch_assoc($result))) {
		$row[$desCol] = rip_tags_description($row[$desCol]);
		$row[$nameCol] = rip_tags_keywords($row[$nameCol]);
		$name[] = $row[$nameCol];
		$description[] = $row[$desCol];
		$productId[] = $row[$prodId];
	}
	function rip_tags_description($string) {
		global $truncate;
		$string = preg_replace ('/<[^>]*>/', ' ', $string);
		$string = str_replace("\r", '', $string);
		$string = str_replace("\n", ' ', $string);
		$string = str_replace("\t", ' ', $string);
		$string = str_replace("&nbsp;&nbsp;&nbsp;", ' ', $string);
		$string = str_replace("&nbsp;&nbsp;", ' ', $string);
		$string = str_replace("&nbsp; &nbsp;", ' ', $string);
		$string = trim(preg_replace('/ {2,}/', ' ', $string));
		$string = preg_replace("/&#?[a-z0-9]{2,8};/i","",$string);
		$string = preg_replace("#[[:punct:]]#", "", $string);
		$string = trim($string, ", ");
		$string = trim($string, " ,");
		$string = trim($string, ",");
		$string = str_replace("  ", ' ', $string);
		$string = trim($string);
		$string = substr($string, 0, $truncate);
		return $string;
	}
	function rip_tags_keywords($string) {
		$string = preg_replace ('/<[^>]*>/', ' ', $string);
		$string = str_replace("\r", '', $string);
		$string = str_replace("\n", ' ', $string);
		$string = str_replace("\t", ' ', $string);
		$string = trim(preg_replace('/ {2,}/', ' ', $string));
		$string = preg_replace("/&#?[a-z0-9]{2,8};/i","",$string);
		$string = preg_replace("#[[:punct:]]#", "", $string);
		$string = preg_replace("[^-\w\d\s\.=$'€%]",'',$string);
		$string = str_replace(' ', ', ', $string);
		$string = str_replace(' ,', '', $string);
		$string = trim($string, ", ");
		$string = trim($string, " ,");
		$string = trim($string, ",");
		$string = trim($string);
		return $string;
	}
	echo "<a name='des'></a><hr />BEGIN SEO META DESCRIPTION INSERTION | <a href='#key'>Jump to Keywords Insertion</a><hr /><hr /><hr /><br />\n";
	foreach (array_combine($description, $productId) as $d => $p){
		$sql = "UPDATE $table SET $seoCol = '".$d."' WHERE $prodId = '".$p."'";
		$query = mysql_query($sql);
		echo $sql;
		echo "<br /><br />";
	}
	echo "<a name='key'></a><hr /><hr /><hr />BEGIN SEO META KEYWORDS INSERTION | <a href='#des'>Jump to Description Insertion</a><hr /><hr /><hr /><br />\n";
	foreach (array_combine($name, $productId) as $n => $p){
		$sql = "UPDATE $table SET $keyCol = '".$n."' WHERE $prodId = '".$p."'";
		$query = mysql_query($sql);
		echo $sql;
		echo "<br /><br />";
	}
	echo "<hr />$rows products modified. <a href='#des'>Top</a>\n";
	unset ($truncate);
	mysql_close($link);
?>