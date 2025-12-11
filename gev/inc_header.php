<?php
$browser=getBrowser();
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?=$title;?></title>
        <meta name="description" content="<?=$description;?>">
        <meta name="keywords" content="<?=$keywords;?>">

	<!-- Google Font -->
	<link href='<?=BASE_URL;?>js/fontgoogle.css' rel='stylesheet' type='text/css'>

	<!-- Library CSS -->
	<link rel="stylesheet" href="<?=BASE_URL;?>fonts/font-awesome-4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>css/library/bootstrap.min.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>css/library/owl.carousel.css">
        <link rel="stylesheet" href="<?=BASE_URL;?>css/library/owl.transitions.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>css/library/jquery-ui.min.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>css/library/jquery.fancybox.css">

	<!-- MAIN STYLE -->
        <link rel="stylesheet" href="<?=BASE_URL;?>css/navigator.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>css/style.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>css/color-green.css">

	<?php if($browser['name']=='Internet Explorer' ){ ?>
        <script src="<?=BASE_URL;?>js/html5.js"></script>
        <script src="<?=BASE_URL;?>js/css3-mediaqueries.js"></script>
        <?php } ?>
