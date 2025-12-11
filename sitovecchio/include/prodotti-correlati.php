                         <?php
							$Risultato_correlati=mysql_query("SELECT p.id_prodotto, p.url, p.url_eng, p.nome_ita, p.nome_eng, p.codice, p.visible, pc.id FROM prodotti AS p 
							INNER JOIN prodotti_correlati AS pc ON pc.id_prodotto = ". $id_prodotto . " AND pc.id_prodotto_correlato = p.id_prodotto AND p.visible = '1' 
							GROUP BY p.codice", $db);
							$tot_records = mysql_num_rows($Risultato_correlati);	    		   
							if (!$Risultato_correlati)
							{
							die ("La tabella selezionata non esiste" . mysql_error());
							}
							if ($tot_records == 0)
							{
								echo "<p>" . $nessun_prodotto_correlato . "</p>";
							}
							while ($riga_Correlati=mysql_fetch_array($Risultato_correlati))
			 				{
							if ($lingua=="it")
							{
							$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga_Correlati['url']); 
							$myNewString=str_replace(' ','-',$myNewString);							
							}
							else
							{
							$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga_Correlati['url_eng']); 
							$myNewString=str_replace(' ','-',$myNewString);							
							}
						?>
                    <div class="prodotto_correlato">
                    	<div class="foto_prodotto_correlato">
								<?php 
                                    leggi_immagine("images/miniature/prodotti/" . $riga_Correlati['id_prodotto'], 75); 
                                ?>
                        </div>
                        <div class="titolo_prodotto_correlato">
							<?php 
							 echo "<a href='http://www.marss.eu/" . $lingua . "/prodotto" . $riga_Correlati['id_prodotto'] . "/" . $myNewString .".html'>";
							 echo "(" . $riga_Correlati['codice'] . ") ";
							 if ($lingua=="it") {echo $riga_Correlati['nome_ita'];} else {echo $riga_Correlati['nome_eng']; }
							 echo "</a>";
							?>
                        </div> 
                    </div>
 					<?php }?>