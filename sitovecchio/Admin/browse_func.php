<?php
function Elenca()
    {
 //Apro la directory contenente le immagini    
 $pics = opendir('../images/varie/');
 //Inizio con il ciclo while a caricare le immagini una alla volta
 while ($filename = readdir($pics)){
    //escludo file che non abbiano estensione regolare
        if ($filename != '.' && $filename != '..') {
        //assegno l'url dell'immagine
        $pathimg = '../images/varie/'.$filename;
        //stampo il codice html per caricare l'immagine e il link per eliminarla
        echo '<a href="#" onClick="insert(\''.$pathimg.'\')"><img src="'.$pathimg.'" /></a><a href="' . $_SERVER["PHP_SELF"] .'?img='. $filename .' ">ELIMINA</a>';
         } 
    }
 
 //se abbiamo cliccato su elimina  
 if(isset($_GET['img'])) {
  //impostiamo la directory contenente l'immagine
  $path = '../images/varie/';
 //otteniamo il nome del file
  $filename= $_GET['img'];
  //eliminiamo il file
 unlink($path.$filename);
 }
	}
?>