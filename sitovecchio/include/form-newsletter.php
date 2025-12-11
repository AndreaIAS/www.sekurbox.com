 <form id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form_intestazione"><?php echo $titolo_form_registrazione;?></div>
<?php
	if (isset($messaggio_inviato)) {
		echo "<p>" . $messaggio_inviato . "</p>";
	} else
	{
?>
    <div class="form_row"><label>Email</label></div>                       
    <div class="form_row"><input type="text" name="email" /></div>
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $nome;?></label></div>                       
        <div class="form_row"><input type="text" name="nome" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $cognome;?></label></div>                       
        <div class="form_row"><input type="text" name="cognome" /></div>                        
    </div>
    <div class="form_row"></div>   
    <div class="form_row">
       <span class="stile_info_privacy">
            <?php echo $leggi_informativa;?>
        </span>
    </div>
    <div class="form_row">
        <div class="form_row_piccolo">
        	<input type="checkbox" name="agree" />
        </div>                       
        <div class="form_row_grande">
            <span class="stile_info_privacy">
               <?php echo $acconsento;?>
            </span>
        </div>                        
    </div>
    <div class="form_row_button">
        <input class="entra" type="submit" value="<?php echo $iscriviti_newsletter;?>" name="iscrivimi" />              
    </div> 
</form>                        
<?php } ?>                       
