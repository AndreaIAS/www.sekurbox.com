<?php
function leggi_immagine($cartella, $dim) 
		    { 
		    $listaFile = scandir($cartella);
		    $grandezzaarray=sizeof($listaFile);
		    if ($grandezzaarray > 2) { 
		    	foreach($listaFile as $value) 
		    	{ 
					if($value == '.' || $value == '..' || substr($value, 0, 1)=="." || substr($value, 0, 1)=="_")
		    		{ 
		    		continue; 
		    	} 
		   			 echo '<img src="http://www.marss.eu/'.$cartella.'/'.$value. '" class="flex" width="' . $dim . '" />'; 
		    }  
		    } else { 
		    echo '<img src="http://www.marss.eu/images/prodotto-no-photo.gif" />'; 
		    } 
		    }
				
?>
