<div class="section-container tabs" data-section="tabs">
    <section class="section">
        <p class="title"><a href="#"><?php echo $descrizione;?></a></p>
            <div class="content">
                <p>
                    <?php if ($lingua=="it") {echo $riga_det['descrizione_ita'];} else {echo $riga_det['descrizione_eng'];} ?>
                </p>
            </div>
    </section>
                            <section class="section">
                                <p class="title"><a href="#"><?php echo $allegati;?></a></p>
                                    <div class="content">
										 <?php
										$Risultato_schede_tecniche=mysql_query("SELECT schede_tecniche.id_scheda_tecnica,
																											   schede_tecniche.scheda_tecnica_nome, 
																											   schede_tecniche.scheda_tecnica_size,
																											   schede_tecniche.lingua, 
																											   prodotti_correlati_schede_tecniche.id_scheda_tecnica, 
																											   prodotti_correlati_schede_tecniche.id_prodotto_correlato
																								 FROM 
																								schede_tecniche
																								INNER JOIN 
																								prodotti_correlati_schede_tecniche
																								ON schede_tecniche.id_scheda_tecnica = prodotti_correlati_schede_tecniche.id_scheda_tecnica
																								WHERE prodotti_correlati_schede_tecniche.id_prodotto_correlato = '" . mysql_real_escape_string($id_prodotto) . "' 
																								and
																								schede_tecniche.lingua = '" . mysql_real_escape_string($lingua) . "'
																								", $db);	            
										if (!$Risultato_schede_tecniche)
										{
										die ("La tabella selezionata non esiste" . mysql_error());
										}
										$tot_records = mysql_num_rows($Risultato_schede_tecniche);
										if ($tot_records > 0)
										{ 
										echo'<h4>' . $schede_tecniche . '</h4>';
										}
										else
										{
										echo "";
										}
										while ($riga_st=mysql_fetch_array($Risultato_schede_tecniche))
										{										
											echo '<ul>
												<li><a href="http://www.marss.eu/pdf/schedetecniche/' . $riga_st['scheda_tecnica_nome'] . '" target="_blank">' . $riga_st['scheda_tecnica_nome'] . '</a> (' . bytesToSize($riga_st['scheda_tecnica_size']) . ')</li>
											</ul>';
										}
                                        ?> 
									 	<?php
										$Risultato_manuali=mysql_query("SELECT manuali.id_manuale,
																											   manuali.manuale_nome, 
																											   manuali.manuale_size, 
																											   manuali.lingua,
																											   prodotti_correlati_manuali.id_manuale, 
																											   prodotti_correlati_manuali.id_prodotto_correlato
																								 FROM 
																								manuali
																								INNER JOIN 
																								prodotti_correlati_manuali
																								ON manuali.id_manuale = prodotti_correlati_manuali.id_manuale
																								WHERE prodotti_correlati_manuali.id_prodotto_correlato = '" . mysql_real_escape_string($id_prodotto) . "'
																								 and
																								 manuali.lingua = '" . mysql_real_escape_string($lingua) . "'
																								 ", $db);	
												
										if (!$Risultato_manuali)
										{
										die ("La tabella selezionata non esiste" . mysql_error());
										}
										$tot_records = mysql_num_rows($Risultato_manuali);
										if ($tot_records > 0)
											{ 
												echo '<h4>' . $manuali . '</h4>';
											}
										while ($riga_m=mysql_fetch_array($Risultato_manuali))
										{
											echo'
											<ul>
												<li><a href="http://www.marss.eu/pdf/manuali/' . $riga_m['manuale_nome'] . '" target="_blank">' . $riga_m['manuale_nome'] . '</a> (' . bytesToSize($riga_m['manuale_size']) . ')</li>
											</ul>';
											}
                                        ?> 
									
									  <?php
										$Risultato_sw=mysql_query("SELECT  software.id_software,
																							 software.nome_ita, 
																							 software.nome_eng,
																							 software.url, 
																							 prodotti_correlati_software.id_software, 
																							 prodotti_correlati_software.id_prodotto_correlato
																				 FROM 
																							software
																				 INNER JOIN 
																							prodotti_correlati_software
																				 ON 
																							software.id_software = prodotti_correlati_software.id_software
																				 WHERE 
																				 prodotti_correlati_software.id_prodotto_correlato = '" . mysql_real_escape_string($id_prodotto) . "'", $db);	
												
										if (!$Risultato_sw)
										{
										die ("La tabella selezionata non esiste" . mysql_error());
										}
										$tot_records = mysql_num_rows($Risultato_sw);
										if ($tot_records > 0)
										{ 
										echo'<h4>Software</h4>';
										}
										while ($riga_st=mysql_fetch_array($Risultato_sw))
										{
										
											if ($lingua=="it") 
											{ 
											$nome_software = $riga_st['nome_ita']; 
											} 
											else 
											{ 
											$nome_software = $riga_st['nome_eng']; 
											}
											echo'
											<ul>
												<li><a href="' . $riga_st['url'] . '" target="_blank">' . $nome_software . '</a></li>
											</ul>';
										}
                                      ?>                                             
                                    </div>
                            </section>
                            <section class="section">
                                <p class="title"><a href="#"><?php echo $applicazioni;?></a></p>
                                    <div class="content">
                						<div id="controller" class="hidden">
											<?php
                                                function serie_img($cartella)
                                                {
                                                    $listaFile = scandir($cartella);
                                                    foreach($listaFile as $value)
                                                    {
                                                    if($value == '.' || $value == '..')
                                                        {
                                                            continue;
                                                        }
                                                	echo '<span class="jFlowControl"></span>';
                                                    }
                                                }
                                                serie_img("images/galleria/prodotti/applicazioni/" . $riga_det['id_prodotto']);
                                            ?>
    								</div>
  											<?php
											$directory ="images/galleria/prodotti/applicazioni/" . $riga_det['id_prodotto'];
											$images = count(glob($directory . '/*.jpg')); 
											if ($images > 1)
											{
												echo '<div id="prevNext">
        													<img src="http://www.marss.eu/images/prev.png" alt="Previous Tab" class="jFlowPrev" />
        													<img src="http://www.marss.eu/images/next.png" alt="Next Tab" class="jFlowNext" />
    													</div>';
											}
  											?>
 									<div id="slides">
                   						<?php 
	   	 									leggi_immagine("images/galleria/prodotti/applicazioni/" . $riga_det['id_prodotto'], 810);
										?>
									</div>
                           		</div>
                            </section>     
</div>