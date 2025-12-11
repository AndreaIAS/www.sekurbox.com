<?php

if (!isset($_SESSION['admin_account']['login']) AND $pagename!="login.php") {  header("Location: login.php"); }

function ieversion() {
  $match=preg_match('/MSIE ([0-9].[0-9])/',$_SERVER['HTTP_USER_AGENT'],$reg);
  if($match==0)
    return -1;
  else
    return floatval($reg[1]);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Multivel Admin</title>
<script type="text/javascript" src="<?=BASE_URL;?>js/jquery-2.2.0.js"></script>
<script src="<?=BASE_URL;?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=BASE_URL;?>fileinput/js/fileinput_orig.js"></script>
<script src="<?=BASE_URL;?>fileinput/js/locales/it.js"></script>
<link href="<?=BASE_URL;?>fileinput/css/fileinput_orig.css" media="all" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="<?=BASE_URL;?>js/jquery-ui-1.11.4/jquery-ui1.11.4.min.js"></script>

<link href="<?=BASE_URL;?>bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link rel="stylesheet" media="screen" href="<?=BASE_URL;?>js/jquery-ui-1.11.4/jquery-ui.css"/>
<link rel="stylesheet" href="<?=BASE_URL;?>css/style.default.css" type="text/css" />

<!--<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery-1.7.2.js"></script>-->

<!--<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>-->
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.cookie.js"></script>
<?php if(ieversion()==9) { ?>
<link rel="stylesheet" media="screen" href="<?=BASE_URL;?>css/style.ie9.css"/>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<?php } else if(ieversion()==8) { ?>
<link rel="stylesheet" media="screen" href="<?=BASE_URL;?>css/style.ie8.css"/>
<?php } ?>
      <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="<?=BASE_URL_HOME;?>css/font-awesome.min.css">



