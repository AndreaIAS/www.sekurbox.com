<?php  

//session_cache_limiter ('private, must-revalidate');   
//$cache_limiter = session_cache_limiter();
//session_cache_expire(60); // in minutes
session_start();

//error_reporting(E_ALL); 
//error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
//ini_set('display_errors', '1');

//echo $_SERVER['DOCUMENT_ROOT'];

$pagename = explode("/",$_SERVER['PHP_SELF']);
$pagename = end($pagename);

define ("DEBUG", false);

define("IMAGE_SIZE", 800*1024);
define("FILE_SIZE", 1000*1024);

$array_img = array("jpg","jpeg","gif","png","JPG","JPEG","GIF","PNG");
$array_files = array("swf","gif","jpg","SWF","GIF","JPG");

$array_testo_pag = array(1 => "Acquisto in contrassegno, pagamento alla consegna. ", 
                         2 => "Pagamento tramite carta di credito", 
                         3 => "Bonifico Bancario Anticipato.");

$array_dati_pag = array( 1 => "", 
                         2 => "", 
                         3 => "Dati bonifico bancario");

$array_costo_pag = array(1 => "5.00", 
                         2 => "0.00",
                         3 => "0.00" 
                   );


$array_testo_sped = array(1 => "Spedizione tramite posta, pacco celere 3. ", 
                         2 => "Spedizione tramite corriere espresso"
                         );


$array_costo_sped = array(1 => "5.00", 
                        2 => "9.90"
                   );
//echo $_SERVER['DOCUMENT_ROOT'];
# COSTANTI

 define("IMAGE_DIR", 'upload/image/');
 define("FILE_DIR", 'upload/files/');
 define ("BASE_IMAGE", '/web/htdocs/www.sekurbox.com/home/upload/image/');
 define ("BASE_PATH", '/web/htdocs/www.sekurbox.com/home/admin/');
 define ("BASE_PATH_HOME", '/web/htdocs/www.sekurbox.com/home/');
 
 define("BASE_URL", 'https://www.sekurbox.com/admin/');
 define("BASE_URL_HOME", 'https://www.sekurbox.com/');

  //**************************DATI DATABASE *****************************************//

 define("DB_HOST", '62.149.150.196');
 define("DB_NAME", 'Sql690670_4');
 define("DB_USER", 'Sql690670');
 define("DB_PW", 'c03ea19d');
 
 //***************************************************************//
 



if (isset($_REQUEST['logout']))
{
  if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
   setcookie("cookname", "", time()-60*60*24*100, "/");
   setcookie("cookpass", "", time()-60*60*24*100, "/");
  }	
	session_unset();
	session_destroy();
    header ("Location: index.php"); 
}



//*********************** CONFIGURAZIONE HP THUMB ************************//
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

$phpThumbBase      = BASE_URL.'phpThumb.php';

# CONNESSIONE a DB
 require_once ("classe_Database.php");
 
 $db=new Database(DB_HOST,DB_USER,DB_PW,DB_NAME); 


require_once ("inc_function.php");	
require_once ("class.phpmailer.php");
//require_once ("navigator.php");



?>