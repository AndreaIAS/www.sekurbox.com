<?php
function leggi_immagine($cartella, $dim) 
		    {
			if (is_dir($cartella)) {

		    $listaFile = scandir($cartella);
		    $grandezzaarray=sizeof($listaFile);
		    if ($grandezzaarray > 2) { 
		    	foreach($listaFile as $value) 
		    	{ 
					if($value == '.' || $value == '..' || substr($value, 0, 1)=="." || substr($value, 0, 1)=="_")
		    		{ 
		    		continue; 
		    	} 
		   			 echo '<img src="http://www.sekurbox.com/'.$cartella.'/'.$value. '" class="flex" width="' . $dim . '" />'; 
		    }  
		    } else { 
		    echo '<img src="http://www.sekurbox.com/images/news-no-photo.gif" />'; 
		    } 
					} 	
else { 
		    echo '<img src="http://www.sekurbox.com/images/news-no-photo.gif" />'; 
		    } 
	
		    }
				
?>