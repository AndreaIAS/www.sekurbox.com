<?php

//Configurazione
error_reporting(E_ALL);
ini_set('display_errors', '1');
//echo $_SERVER['DOCUMENT_ROOT'];
session_cache_limiter ('private, must-revalidate');
$cache_limiter = session_cache_limiter();
session_cache_expire(60); // in minutes
include('cart.class.php');
session_start();


//numero di pagine di prodotti da visualizzare
if(isset($_POST['viewpage'])) $_SESSION['viewpage']=$_POST['viewpage'];
if(!isset($_SESSION['viewpage'])) $_SESSION['viewpage']=9;

$pagename=basename($_SERVER['PHP_SELF']);


//Array per l'upload di file o imamgini
$array_img = array("jpg","jpeg","gif","png","JPG","JPEG","GIF","PNG");
$array_files = array("swf","gif","jpg","SWF","GIF","JPG");

$array_testo_pag = array(1 => "Acquisto in contrassegno, pagamento alla consegna. ",
                         2 => "Pagamento tramite carta di credito",
                         3 => "Bonifico Bancario Anticipato.",
                         4 => "Paypal");

$array_dati_pag = array(1 => "",
                         2 => "",
                         3 => "Dati bonifico bancario",
                         4 =>"");

$array_costo_pag = array(1 => "5.00",
                         2 => "0.00",
                         3 => "0.00",
                         4 => "0.00"
                        );


$array_testo_sped = array(1 => "Spedizione tramite corriere espresso"
                         );


$array_costo_sped = array(
                        1 => "9.90"
                   );


define("EMAIL_ADM", '');
define("SITE_NAME","Gevenit.com");
define("EMAIL_ADM_NAME","Gevenit.com");

define("IMAGE_DIR", 'upload/image/');
define("FILE_DIR", 'upload/files/');
//$maildb = array(
//                   'mail' => 'postmaster@gevenit.com',
//                   'pass'=>'gevenit2014',
//                   'host'=>'smtp.gevenit.com',
//                   'reply'=>'gevenit@gevenit.com',
//                   'name'=>'Gevenit.it');

/* Production configs */

define("BASE_IMAGE", '/var/www/vhosts/promocenter.it/httpdocs/upload/image/');
define("BASE_PATH", '/var/www/vhosts/promocenter.it/httpdocs/');

define("BASE_URL", 'http://www.promocenter.it/gevenit.com/');


define('pathactiveuser', BASE_URL.'attivautente.php');
define('secretword','tonio1622wqo234');

/* testing configs */ /*
define ("BASE_IMAGE", '/var/www/localhost/htdocs/WWW/GieffeProjects/www.gevenit.com-old/home/upload/image/');
define ("BASE_PATH_HOME", '/var/www/localhost/htdocs/WWW/GieffeProjects/www.gevenit.com-old/home/');
define("BASE_URL", 'http://192.168.1.82/WWW/GieffeProjects/www.gevenit.com-old/' );
*/
 // **************************DATI DATABASE ***************************************** //
 /**/
 define("DB_HOST", 'localhost');
 define("DB_NAME", 'pulizie');
 define("DB_USER", 'pulizie');
 define("DB_PW", 'pulizie!!?'); /*

 * /
 define("DB_HOST", '127.0.0.1');
 define("DB_NAME", 'gevenit');
 define("DB_USER", 'root');
 define("DB_PW", 'rootpass'); */
 // *************************************************************** //


# CONNESSIONE a DB
 require_once ("classe_Database.php");
 $db=new Database(DB_HOST,DB_USER,DB_PW,DB_NAME);

#Gestione Cart
$cart =& $_SESSION['mycart'];
if(!is_object($cart)) $cart = new CartClass();

#LOG OUT
if (isset($_REQUEST['logout'])) {


 unset($_SESSION['user']);
 unset($_SESSION['nome']);
 unset($_SESSION['email']);
header ("Location: index.php");

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
		$keyname = 'config_'.$key;
		$phpThumb->setParameter($keyname, $value);
	}
}
$ServerInfo['phpthumb_version'] = $phpThumb->phpthumb_version;
$ServerInfo['im_version']       = $phpThumb->ImageMagickVersion();;
$ServerInfo['gd_string']        = phpthumb_functions::gd_version(true);
$ServerInfo['gd_numeric']       = phpthumb_functions::gd_version(false);
unset($phpThumb);
$phpThumbBase= BASE_URL.'phpThumb.php';

require("inc_function.php");
require("navigator.php");
require_once ("class.phpmailer.php");

$title="";
$description="";
$keywords="";



?>
