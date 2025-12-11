<?php
$query="SELECT *  
        FROM prodotti
        WHERE visible = '1'
        GROUP BY id_prodotto ORDER BY posizione ASC LIMIT 0,4";
$Risultato = mysql_query($query, $db) or die(mysql_error($db));
$x=0;
while ($riga=mysql_fetch_array($Risultato))
{
    
if ($lingua=="it")
{
    $myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga['url']); 
    $myNewString=str_replace(' ','-',$myNewString);							
}
else
{
    $myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga['url_eng']); 
    $myNewString=str_replace(' ','-',$myNewString);							
}    

	
echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotto" . $riga['id_prodotto'] . "/" . $myNewString .".html' style='text-decoration:none;'>";
if ($x==0)
{
echo '<div class="hp_prodotto_sn">';
}
else if ($x==1) 
{
echo '<div class="hp_prodotto_ds">';
}	
else if ($x==2) 
{
echo '<div class="hp_prodotto_sn">';
}
else if ($x==3) 
{
echo '<div class="hp_prodotto_ds">';
}	 
?>               
               
               		<div class="hp_prodotto_img">
						<?php leggi_immagine("images/miniature/prodotti/" . $riga['id_prodotto'], 130);?>
                        </div>
               		<div class="hp_prodotto_info">
                    	<div class="hp_prodotto_titolo"><?php if ($lingua=="it") { echo $riga['nome_ita'];} else { echo $riga['nome_eng'];}?></div>
                        
                        <?php echo calcolaprezzo($riga['id_prodotto'],'home','');?>

                        <div class="hp_prodotto_button"><img src="http://www.sekurbox.com/images/hp_acquistalo_ora.png" /></div>
                    </div>                    
               </div></a>
<?php
$x=$x+1;
}
?>                              