<?php
require ("../../config.php");
//include('db.php');
//session_start();
//$session_id='1'; // Session_id
//$t_width = 100;	// Maximum thumbnail width
//$t_height = 100;	// Maximum thumbnail height
$new_name = date('YmdHis')."_".substr($_GET['img'],0,-4)."-crop.jpg"; // Thumbnail image name

$path = BASE_PATH_HOME."images/img_slide/";

if(isset($_GET['t']) and $_GET['t'] == "ajax")
	{
		extract($_GET);
		//$ratio = ($t_width/$w); 
		$nw = $_GET['wfinal'];
		$nh = $_GET['hfinal'];
		$nimg = imagecreatetruecolor($nw,$nh);
		$im_src = imagecreatefromjpeg($path.$img);
		imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
		imagejpeg($nimg,$path.$new_name,90);
		mysql_query("UPDATE  slider SET img_crop ='".$new_name."' WHERE id='".$_GET['id']."' ");
		echo $new_name."?".time();
		exit;
	}
	
	?>