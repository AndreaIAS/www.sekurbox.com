<?php

//Configurazione
//error_reporting(E_ALL & ~E_NOTICE);
//ini_set('display_errors', '1');
//echo $_SERVER['DOCUMENT_ROOT']; die();
//session_cache_limiter ('private, must-revalidate');
//$cache_limiter = session_cache_limiter();
//session_cache_expire(60); // in minutes

include('cart.class.php');

session_start();


define("BASE_IMAGE", '/web/htdocs/www.sekurbox.com/home/upload/image/');
define("BASE_PATH", '/web/htdocs/www.sekurbox.com/home/');
define("BASE_URL", 'https://www.sekurbox.com/');


$pagename = basename($_SERVER['PHP_SELF']);


//Array per l'upload di file o imamgini
$array_img = array("jpg", "jpeg", "gif", "png", "JPG", "JPEG", "GIF", "PNG");
$array_files = array("swf", "gif", "jpg", "SWF", "GIF", "JPG");

$array_testo_pag = array(
    1 => "Acquisto in contrassegno, pagamento alla consegna. ",
    2 => "Pagamento tramite carta di credito",
    3 => "Bonifico Bancario Anticipato.",
    4 => "Paypal"
);

$array_dati_pag = array(
    1 => "",
    2 => "",
    3 => "Dati bonifico bancario",
    4 => ""
);

$array_costo_pag = array(
    1 => "5.00",
    2 => "0.00",
    3 => "0.00",
    4 => "0.00"
);


$array_testo_sped = array(1 => "Spedizione tramite corriere espresso");

$array_costo_sped = array(1 => "9.90");


define("EMAIL_ADM", 'info@sekurbox.com');
define("SITE_NAME", "Sekurbox.com");
define("EMAIL_ADM_NAME", "Sekurbox.com");

define("IMAGE_DIR", 'upload/image/');
define("FILE_DIR", 'upload/files/');



//LINGUA                              
if (isset($_REQUEST['setlng'])) {

    unset($_SESSION['lng']);

    switch ($_REQUEST['setlng']) {

        case 'it':
            $_SESSION['lng'] = 'it';
            break;
        case 'en':
            $_SESSION['lng'] = 'en';
            break;
        default:
            $_SESSION['lng'] = 'it';
    }
}

if (!isset($_SESSION['lng'])) {
    $_SESSION['lng'] = 'it';
    $lng = $_SESSION['lng'];
} else {
    $lng = $_SESSION['lng'];
}

require("lang_" . $lng . ".php");

// FINE LINGUA



//**************************DATI DATABASE *****************************************//

define("DB_HOST", '62.149.150.196');
define("DB_NAME", 'Sql690670_4');
define("DB_USER", 'Sql690670');
define("DB_PW", 'c03ea19d');

//***************************************************************//

define('pathactiveuser', BASE_URL . 'attivautente.php');
define('secretword', 'seK1622wqo234');

# CONNESSIONE a DB
require_once("classe_Database.php");
$db = new Database(DB_HOST, DB_USER, DB_PW, DB_NAME);

#Gestione Cart
$cart = &$_SESSION['mycart'];
if (!is_object($cart)) $cart = new CartClass();

#LOG OUT
if (isset($_REQUEST['logout'])) {

    session_unset();
    session_destroy();
    header("Location: index.php");
}


// *********************** CONFIGURAZIONE HP THUMB ************************ //
$ServerInfo['gd_string']  = 'unknown';
$ServerInfo['gd_numeric'] = 0;
//ob_start();
if (!include_once('phpthumb.functions.php')) {
    //ob_end_flush();
    die('failed to include_once("phpthumb.functions.php")');
}
if (!include_once('phpthumb.class.php')) {
    //ob_end_flush();
    die('failed to include_once("phpthumb.class.php")');
}
//ob_end_clean();
$phpThumb = new phpThumb();
if (include_once('phpThumb.config.php')) {
    foreach ($PHPTHUMB_CONFIG as $key => $value) {
        $keyname = 'config_' . $key;
        $phpThumb->setParameter($keyname, $value);
    }
}
$ServerInfo['phpthumb_version'] = $phpThumb->phpthumb_version;
$ServerInfo['im_version']       = $phpThumb->ImageMagickVersion();;
$ServerInfo['gd_string']        = phpthumb_functions::gd_version(true);
$ServerInfo['gd_numeric']       = phpthumb_functions::gd_version(false);
unset($phpThumb);
$phpThumbBase = BASE_URL . 'phpThumb.php';


//$phpThumb = new phpThumb();
//if (include_once('phpThumb.config.php')) {
//	foreach ($PHPTHUMB_CONFIG as $key => $value) {
//		$keyname = 'config_'.$key;
//		$phpThumb->setParameter($keyname, $value);
//	}
//}
//$ServerInfo['phpthumb_version'] = $phpThumb->phpthumb_version;
//$ServerInfo['im_version']       = $phpThumb->ImageMagickVersion();;
//$ServerInfo['gd_string']        = (new phpthumb_functions)->gd_version(true);
//$ServerInfo['gd_numeric']       = (new phpthumb_functions)->gd_version(false);
//unset($phpThumb);

$phpThumbBase      = BASE_URL . 'phpThumb.php';

require("inc_function.php");
//require("navigator.php");
require_once("class.phpmailer.php");

$title = "";
$description = "";
$keywords = "";
