<?php 

 //Include config
include('config.php');
?>
<div id="dati">
    
<p>
<b>Categoria</b><br />
<span class="field">
<select name="id_categoria" class="uniformselect" onchange="jQuery('#ajax2').show();jQuery('#sottocategorie').load('<?=BASE_URL;?>loadcategorie.php #dati2',{idcat:jQuery(this).val()},function() {jQuery('#ajax2').hide();}); ">
    <option value="0">Scegli categoria</option>
<?php 
 $db->query("SELECT * FROM bag_categorie WHERE id_macro ='".$_POST['idmacro']."' order by nome_it");
 $resultm=$db->resultset();
 foreach ($resultm as $listm) {?>
    <option value="<?=$listm['id'];?>"><?=$listm['nome_it'];?></option>
   <?php } ?>                        
</select>
</span>
<img src="<?=BASE_URL;?>images/ajax-loader1.gif" style="display:none;" id="ajax2" />
</p>



</div>

<div id="dati2">
    
<p>
<b>Sottocategoria</b><br />
<span class="field">
<select name="id_sottocategoria" class="uniformselect">
    <option value="0">Scegli sottocategoria</option>
<?php 
 $db->query("SELECT * FROM bag_scat WHERE id_categoria ='".$_POST['idcat']."' order by nome_it");
 $resultm=$db->resultset();
 foreach ($resultm as $listm) {?>
    <option value="<?=$listm['id'];?>"><?=$listm['nome_it'];?></option>
   <?php } ?>                        
</select>
</span>
</p>



</div>