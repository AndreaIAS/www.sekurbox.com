<?php

//if (!function_exists('mysql_escape_string')) {
//	/**
// 	* mysql_escape_string — Escapes a string for use in a mysql_query
// 	*
// 	* @link https://dev.mysql.com/doc/refman/8.0/en/string-literals.html#character-escape-sequences
// 	*
// 	* @param string $unescaped_string
// 	* @return string
// 	* @deprecated
// 	*/
//	function mysql_escape_string(string $unescaped_string): string
//	{
//    	$replacementMap = [
//        	"\0" => "\\0",
//        	"\n" => "\\n",
//        	"\r" => "\\r",
//        	"\t" => "\\t",
//        	chr(26) => "\\Z",
//        	chr(8) => "\\b",
//        	'"' => '\"',
//        	"'" => "\'",
//        	"%" => "\%",
//        	'\\' => '\\\\'
//    	];
//
//    	return \strtr($unescaped_string, $replacementMap);
//	}
//}

function dataesplicita($value){

               $arr_set=array("Domenica","Lunedì","Martedì","Mercoledì","Giovedì","Venerdì","Sabato");
               $arr_mesi=array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
               $settimana = $arr_set[date("w", strtotime($value))];
               $giorno = date("j", strtotime($value));
               $mese = $arr_mesi[date("n", strtotime($value))-1];
               $anno = date("o", strtotime($value));
               $data = "".$settimana."&nbsp;".$giorno."&nbsp;".$mese."&nbsp;".$anno."";
 return $data;
}

function togliaccenti($stringa){

	$stringa = trim($stringa);
	$stringa = str_replace("�","&agrave;",$stringa);
	$stringa = str_replace("�","&egrave;",$stringa);
	$stringa = str_replace("�","&eacute;",$stringa);
	$stringa = str_replace("�","&ograve;",$stringa);
	$stringa = str_replace("�","&ugrave;",$stringa);
	$stringa = str_replace("�","&igrave;",$stringa);
	$stringa = str_replace("'","&#8217;",$stringa);
	$stringa = str_replace("�","&#180;",$stringa);
	$stringa = str_replace("�","&quot;",$stringa);
	$stringa = str_replace("�","&quot;",$stringa);
	$stringa = str_replace("�","&#8217;",$stringa);
	$stringa = str_replace("�","&#8210;",$stringa);
	$stringa = str_replace("�","&#149;",$stringa);
	$stringa = str_replace("*","&#42;",$stringa);

	return $stringa;
}


function Codicerandom($lunghezza){
$N_Caratteri = $lunghezza;
$Stringa = "";
For($I=0;$I<$N_Caratteri;$I++){
              do{$N = Ceil(rand(48,122));}
              while(!((($N >= 48) && ($N <= 57)) || (($N >= 65) && ($N <= 90)) || (($N >= 97) && ($N <= 122))));
             $Stringa = $Stringa.Chr ($N);
             }
return $Stringa;
}


function emailpresente($email) {

$db->query("SELECT * FROM
            bag_utenti
            WHERE
            email = '".mysql_escape_string($email)."' ");
$list= $db->rowCount();


if ($list>0) { return 1; }else return 0;
}





function seo_url($testo){

 $testo = utf8_decode($testo);
 $testo = str_replace(" ","-",$testo);
 $testo = str_replace("è","e",$testo);
 $testo = str_replace("é","e",$testo);
 $testo = str_replace("ò","o",$testo);
 $testo = str_replace("à","a",$testo);
 $testo = str_replace("ù","u",$testo);
 $testo = str_replace("ì","i",$testo);
 $html['string']=strip_tags(preg_replace('#[^A-Za-z0-9- ]#', '', $testo));
 $reWriteUrl = ucWords($html['string']);
 return $reWriteUrl;

}



function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}


function ritornagiorno($value){

               $arr_set=array("Domenica","Luned�","Marted�","Mercoled�","Gioved�","Venerd�","Sabato");
               $arr_mesi=array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
               $settimana = $arr_set[date("w", strtotime($value))];
               $giorno = date("j", strtotime($value));
               $mese = $arr_mesi[date("n", strtotime($value))-1];
               $anno = date("o", strtotime($value));
               $data = "".$settimana."&nbsp;".$giorno."&nbsp;".$mese."&nbsp;".$anno."";
 return $giorno;
}

function ritornamese($value){

               $arr_set=array("Domenica","Luned�","Marted�","Mercoled�","Gioved�","Venerd�","Sabato");
               $arr_mesi=array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
               $settimana = $arr_set[date("w", strtotime($value))];
               $giorno = date("j", strtotime($value));
               $mese = $arr_mesi[date("n", strtotime($value))-1];
               $anno = date("o", strtotime($value));
               $data = "".$settimana."&nbsp;".$giorno."&nbsp;".$mese."&nbsp;".$anno."";
 return $mese;
}
function sendMail($to, $subject, $body, $altBody){
	require_once("PHPMailer/PHPMailerAutoload.php");
	//require ("res/Mailer/class.phpmailer.php");
	//require ("res/Mailer/class.smtp.php");
    $maildb = array(
                   'mail' => 'postmaster@gevenit.com',
                   'pass'=>'gevenit2014',
                   'host'=>'smtp.gevenit.com',
                   'reply'=>'gevenit@gevenit.com',
                   'name'=>'Gevenit.com');

	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	$mail->IsSMTP();
	//$mail->SMTPDebug = 4;
	//$mail->Debugoutput = 'html';
	$mail->Host = $maildb['host'];
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Username = $maildb['mail'];
	$mail->Password = $maildb['pass'];

	$mail->setFrom($maildb['mail']);
	$mail->FromName = $maildb['name'];

	$mail->addAddress($to);

	$mail->addReplyTo($maildb['reply'], 'Info');
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = $altBody;
	if(!$mail->send()) {
		$headers = 'From: '. $maildb['mail'] . "\r\n" .
            'Reply-To: '. $maildb['reply'] . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
		if (mail ($to,$subject,$altBody,$headers)){
			$err = 'Mail Error';    //e' stata inviata una mail alternativa
		}else{
			$err = 'Critical Mail Error'; // non e' stata inviata nemmeno la mail alternativa
		}
		mail ('matteo.nuzzachi@gmail.com',$err,$altBody);
		return false;
	} else {
		return true;
	}
}

?>
