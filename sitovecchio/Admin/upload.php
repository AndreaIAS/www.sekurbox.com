<?php
$url = 'images/'.time()."_".$_FILES['upload']['name'];
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
       $message = "Nessuna immagine caricata.";
    }
	else if ($_FILES['upload']["size"] == 0)
	{
   $message = "Il file ha una dimensione pari a 0.";
	}
	else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
    {
       $message = "Il formato deve essere JPG o PNG. Per favore controlla di aver selezionato un formato immagine corretto.";
    }
	else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
       $message = "Non è stato possibile caricare il file, qualcosa è andato storto";
    }
	else {
      $message = "";
	//Creo la variabile $uploadedfile e le dò il valore del file caricato
$uploadedfile=$_FILES['upload']['tmp_name'];
//Creo l'immagine da rielaborare
$src = imagecreatefromjpeg($uploadedfile);
//Leggo i valori larghezza e altezza dell'immagine caricata
list($width,$height)=getimagesize($uploadedfile);
//imposto la larghezza a 250px, voi potete modificare questo valore come più vi pare
$newwidth=250;
//con questo calcolo ottengo la larghezza giusta in base all'aspetto dell'immagine e della mia larghezza impostata
$newheight=($height/$width)*$newwidth;
//ora creo il contenitore con la nuova dimensione ottenuta
$tmp=imagecreatetruecolor($newwidth,$newheight);
//copio l'immagine e la ridimensiono nel nuovo contenitore
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
//creo il jpg con qualità al 100%, questo valore è a vostro piacimento
imagejpeg($tmp,$url,100);
//elimino il file da rielaborare in quanto non più necessario
imagedestroy($src);
//ora elimino il file temporaneo
imagedestroy($tmp);
//Se ci sono dei problemi durante la creazione del file probabilmente i permessi di scrittura non sono corretti quindi effettuiamo un ultimo controllo
if(!$tmp)
      {
         $message = "Errore durante lo spostamento del file. Potrebbe essere un problema di permessi in lettura/scrittura.";
      }
	//Associamo il numero funzione di CkEditor a una variabile
$funcNum = $_GET['CKEditorFuncNum'] ;
//ora lo script si occuperà di passare il messaggio generato o la foto caricata a CkEditor
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
	}
?> 