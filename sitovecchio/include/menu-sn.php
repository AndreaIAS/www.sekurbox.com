<?php 
		  
		  if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) 
		  {
		   	  if ($pagina=="area_riservata") 
			  {
				  echo '<li class="evidenzia">' . $area_riservata . '</li>';
			  }
			  else 
			  {
				echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/area-riservata.html">' . $area_riservata . '</a></li>';
			  }	
	  		  	echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/logout.html">Logout</a></li>';
		  }
		  else
		  {
			  
			  if ($pagina=="registrati") 
			  {
				  echo '<li class="evidenzia">' . $registrati . '</li>';
			  }
			  else 
			  {
				echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/registrati.html">' . $registrati . '</a></li>';
			  }	
			  
			  if ($pagina=="login") 
			  {
				  echo '<li class="evidenzia">Login</li>';
			  }
			  else 
			  {
				echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/login.html">Login</a></li>';
			  }	
			  
			  if ($pagina=="newsletter") 
			  {
				  echo '<li class="evidenzia">' . $iscriviti_newsletter . '</li>';
			  }
			  else 
			  {
				echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/iscriviti-alla-newsletter.html">' . $iscriviti_newsletter . '</a></li>';
			  }	
		  }
		  
		  if ($pagina=="guida_acquisto") 
		  {
			  echo '<li class="evidenzia">' . $guida_acquisto . '</li>';
		  }
		  else 
		  {
			echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/guida-acquisto.html" rel="nofollow">' . $guida_acquisto . '</a></li>';
		  }

		  
	  	  if ($pagina=="condizioni_vendita") 
		  {
			  echo '<li class="evidenzia">' . $condizioni_di_vendita . '</li>';
		  }
		  else 
		  {
			echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/condizioni-di-vendita.html" rel="nofollow">' . $condizioni_di_vendita . '</a></li>';
		  }

		  if ($pagina=="diritto_di_recesso") 
		  {
			  echo '<li class="evidenzia">' . $diritto_di_recesso . '</li>';
		  }
		  else 
		  {
			echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/diritto-di-recesso.html" rel="nofollow">' . $diritto_di_recesso . '</a></li>';
		  }

	  	  if ($pagina=="note_legali") 
		  {
			  echo '<li class="evidenzia">' . $note_legali . '</li>';
		  }
		  else 
		  {
			echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/note-legali.html" rel="nofollow">' . $note_legali . '</a></li>';
		  }	

	  	  if ($pagina=="privacy") 
		  {
			  echo '<li class="evidenzia">' . $normativa_sulla_privacy . '</li>';
		  }
		  else 
		  {
			echo '<li><a href="http://www.sekurbox.com/' . $lingua . '/normativa-privacy-sekurbox.html" rel="nofollow">' . $normativa_sulla_privacy . '</a></li>';
		  }			  	  	
?>
