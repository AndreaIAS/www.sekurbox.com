
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?=${"title_".$lng};?> </title>
    <meta name="description" content="<?=${"description_".$lng};?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?=BASE_URL;?>favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?=BASE_URL;?>favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?=BASE_URL;?>favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?=BASE_URL;?>favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?=BASE_URL;?>favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?=BASE_URL;?>favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?=BASE_URL;?>favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?=BASE_URL;?>favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?=BASE_URL;?>favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?=BASE_URL;?>favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?=BASE_URL;?>favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?=BASE_URL;?>favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?=BASE_URL;?>favicon/favicon-16x16.png">
<link rel="manifest" href="<?=BASE_URL;?>favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?=BASE_URL;?>favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/bootstrap.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/animate.min.css">
    <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/font-awesome.min.css">
    <!-- Flaticon CSS-->
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>css/font/flaticon.css">
    <!-- Owl Caousel CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=BASE_URL;?>css/owl.theme.default.min.css">
    <!-- Main Menu CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/meanmenu.min.css">
    <!-- Nivo Slider CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>lib/custom-slider/css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="<?=BASE_URL;?>lib/custom-slider/css/preview.css" type="text/css" media="screen" />
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>css/select2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=BASE_URL;?>style.css">
    <!-- Modernizr Js -->
    <script src="<?=BASE_URL;?>js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- jquery-->
    <script src="<?=BASE_URL;?>js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>
    
    <script> 
    $(function() { 
        $.post('<?=BASE_URL;?>functionload.php', {function:'dimensioni_schermo', width: window.innerWidth, height:window.innerHeight }, function(json) {
            if(json.outcome == 'success') {
               if(json.width<=480) {$('.img_din').css('width','168px');}
            
            } else {
                alert('Unable to let PHP know what the screen resolution is!');
            }
        },'json');
    });
   </script> 

     

