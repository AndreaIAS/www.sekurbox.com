<div id="cerca">
<p><?php echo $frase_form_cerca;?></p>
<form id="" method="POST" action ="http://www.sekurbox.com/<?php echo $lingua;?>/prodotti.html">
    <input type="text" name="cerca_prodotto" value="" />
    <input type="submit" value="<?php echo $cerca;?>" class="cerca" />                                                         
</form>
</div>
<?php
// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{	 
/*$Risultato_menu_prodotti=mysql_query("SELECT 
                                     sp.*, cp.*  
                                     FROM sezioni_prodotti sp
                                     LEFT OUTER JOIN categorie_prodotti AS cp ON sp.id_sezione = cp.id_sezione 
                                     ORDER BY sp.posizione, cp.posizione ASC", $db);*/

$querymacro="SELECT  * FROM sezioni_prodotti GROUP BY sezioni_prodotti.id_sezione ORDER by posizione";




}
else
{
// TUTTI GLI ALTRI						
/*$Risultato_menu_prodotti=mysql_query("SELECT 
                                     sp.*, cp.*  
                                     FROM sezioni_prodotti sp
                                     LEFT OUTER JOIN categorie_prodotti AS cp ON sp.id_sezione = cp.id_sezione
                                     WHERE sp.puglia ='0' AND cp.puglia='0'
                                     ORDER BY sp.posizione, cp.posizione ASC", $db);*/

$querymacro="SELECT  * FROM sezioni_prodotti WHERE sezioni_prodotti.puglia='0' GROUP BY sezioni_prodotti.id_sezione ORDER by posizione";
}
/*if (!$Risultato_menu_prodotti)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}*/

        
/*
 $sezione = "";
$x=0;
while ($riga_menu_prodotti=mysql_fetch_array($Risultato_menu_prodotti))
{	
?> 

<?php 
	if ($lingua =="it")
	{
	$sezione_lg = $riga_menu_prodotti['nome_sezione_ita'];	
	}
	else
	{
	$sezione_lg = $riga_menu_prodotti['nome_sezione_eng'];	
	}
	if ($sezione != $sezione_lg)
	{
		if($x==0)
		{
			echo '<div class="titolo_menu_laterale">';
			echo '<a href="javascript:void(null)" onclick="$(\'.menu_laterale\').slideUp();$(\'#'.$riga_menu_prodotti['id_sezione'].'\').slideDown();"';
                        if (isset($_GET['id_sezione']) && $_GET['id_sezione']==$riga_menu_prodotti['id_sezione'] ){ 
                            
                            echo 'style="color: #ff6e00"';
                        } 
                        

                        echo '>';
				if ($lingua=="it") { echo $riga_menu_prodotti['nome_sezione_ita']; } else { echo $riga_menu_prodotti['nome_sezione_eng']; }
			echo '</a>';
			echo '</div><ul id="'.$riga_menu_prodotti['id_sezione'].'" class="menu_laterale">';
                        echo '<li>';
	                echo '<a href="http://www.sekurbox.com/' . $lingua . '/prodotti' . $riga_menu_prodotti['id_sezione'] . '.html">';
	                if ($lingua=="it") { echo "Tutto"; } else { echo "All"; }
	                echo '</a></li>';
		}
		else 
		{
			echo '</ul>';
			echo '<div class="titolo_menu_laterale">';
			echo '<a href="javascript:void(null)" onclick="$(\'.menu_laterale\').slideUp();$(\'#'.$riga_menu_prodotti['id_sezione'].'\').slideDown();"';
                        if (isset($_GET['id_sezione']) && $_GET['id_sezione']==$riga_menu_prodotti['id_sezione'] ){ 
                            
                            echo 'style="color: #ff6e00"';
                        } 
                        echo '>';
				if ($lingua=="it") { echo $riga_menu_prodotti['nome_sezione_ita']; } else { echo $riga_menu_prodotti['nome_sezione_eng']; }
			echo '</a>';
			echo '</div><ul id="'.$riga_menu_prodotti['id_sezione'].'" class="menu_laterale" >';
                        echo '<li>';
	                echo '<a href="http://www.sekurbox.com/' . $lingua . '/prodotti' . $riga_menu_prodotti['id_sezione'] . '.html">';
	                if ($lingua=="it") { echo "Tutto"; } else { echo "All"; }
	                echo '</a></li>';
		}
		$x=1;
	}
	echo '<li>';
	echo '<a href="http://www.sekurbox.com/' . $lingua . '/prodotti' . $riga_menu_prodotti['id_sezione'] . "-" . $riga_menu_prodotti['id_categoria'] . '.html">';
	if ($lingua=="it") { echo $riga_menu_prodotti['categoria_ita']; } else { echo $riga_menu_prodotti['categoria_eng']; }
	echo '</a></li>';
	
	if ($lingua=="it") {$sezione = $riga_menu_prodotti['nome_sezione_ita']; } else {$sezione = $riga_menu_prodotti['nome_sezione_eng'];}	
}
echo '</ul>'; 


*/

                        $resultmacro=mysql_query($querymacro) or die(mysql_error());
                        while($listmacro=  mysql_fetch_array($resultmacro)){  
                            
                            // SE IL CLIENTE E' PUGLIESE	
                            if($_SESSION['id_regione'] == 16){
                                
                                $querycat="SELECT * FROM categorie_prodotti WHERE id_sezione='".$listmacro['id_sezione']."' ORDER by posizione";
                            } else {
                                
                                $querycat="SELECT * FROM categorie_prodotti WHERE id_sezione='".$listmacro['id_sezione']."'AND categorie_prodotti.puglia='0' ORDER by posizione";
                            }
                                
                            ?>

                            <div class="titolo_menu_laterale">
                                <a href="javascript:void(null)" onclick="$('.menu_laterale').slideUp();$('#<?=$listmacro['id_sezione'];?>').slideDown();"
                                   <?php if (isset($_GET['id_sezione']) && $_GET['id_sezione']==$listmacro['id_sezione'] ){echo 'style="color: #ff6e00"';} ?>  >
                                <?php if ($lingua=="it") { echo $listmacro['nome_sezione_ita']; } else { echo $listmacro['nome_sezione_eng']; } ?>
                                </a>  
                            </div>
                            <ul id="<?=$listmacro['id_sezione'];?>" class="menu_laterale">
                              <li>
                                  <a href="http://www.sekurbox.com/<?=$lingua;?>/prodotti<?=$listmacro['id_sezione'];?>.html">
                                      <b><?php if ($lingua=="it") { echo "Tutto"; } else { echo "All"; } ?></b>
                                  </a>
                              </li> 
                              
                              <?php
                              
                              $resultcat=mysql_query($querycat) or die(mysql_error());
                              while($listcat=mysql_fetch_array($resultcat)){?>
                                                                
                                  <li>
                                      <a href="http://www.sekurbox.com/<?=$lingua;?>/prodotti<?=$listmacro['id_sezione'];?>-<?=$listcat['id_categoria'];?>.html">
                                          <b><?php if ($lingua=="it") { echo $listcat['categoria_ita']; } else { echo $listcat['categoria_eng']; } ?></b>
                                      </a>
                                  </li>
                               <?php   
                               
                               $queryscat="SELECT  * FROM sottocategorie_prodotti WHERE id_categoria='".$listcat['id_categoria']."' ORDER by id_sottocategoria";
                               $resultscat=mysql_query($queryscat) or die(mysql_error());
                               while($listscat=  mysql_fetch_array($resultscat)){ ?>
                                  
                                  <li style="margin-left:10px;">
                                      <a href="http://www.sekurbox.com/<?=$lingua;?>/prodotti<?=$listmacro['id_sezione'];?>-<?=$listcat['id_categoria'];?>-<?=$listscat['id_sottocategoria'];?>.html">
                                          <?php if ($lingua=="it") { echo $listscat['sottocategoria_ita']; } else { echo $listscat['sottocategoria_eng']; } ?>
                                      </a>
                                  </li>
                                   
                  
                                     <?php    } }  ?>
                  
                  </ul>

<?php }



if (isset($_GET['id_sezione']) && $_GET['id_sezione']!='' )
{ ?>

<script>

$('#<?=$_GET['id_sezione'];?>').slideDown();

</script>

<?php } ?>
    
