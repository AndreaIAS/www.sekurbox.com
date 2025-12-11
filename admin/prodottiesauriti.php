<?php
    require ("config.php");
    require ("inc_header.php");    
    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt']; else   $todo = 'view';
?>


    <script type="text/javascript" src="<?=BASE_URL;?>js/uploadify/jquery.uploadify.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/charCount.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/ui.spinner.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tooltip.jquery.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tinymce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/editor.js"></script> 
     <link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>js/uploadify/uploadify.css" />

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  
    <script>
    jQuery(document).ready(function(){ jQuery('input:checkbox, input:radio, select.uniformselect, input:file').uniform();});
    </script>
    
    <style>
    .stdform label{width: 100px; text-align:right;padding:0px 0px 0px 0px;}
    .stdform span.field, .stdform div.field { margin-left: 0px;}
    </style>


</head>

<body>


<?php  

require("inc_menu.php"); 
require("inc_leftside.php"); 


if ($todo=='view') {  ?>


  
  <div class="centercontent tables">

        <div id="contentwrapper" class="contentwrapper">

                 <div class="contenttitle2">

                	<h3>Gestione Prodotti</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>prodottiesauriti.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>

                   <thead>
                        <tr>
                            <th class="head1" style="width:330px;">Nome</th>
                            <th class="head0" style="width:100px;">Codice gevenit</th>
                            <th class="head1" style="width:100px;">Codice mepa</th>
                            <th class="head0" style="width:100px;">Codice fornitore</th>
                            <th class="head1" style="width:70px;"> Prezzo</th>
                            <th class="head0" style="width:270px;">Sottocategoria</th>
                            <th class="head1" style="width:130px;">Quantità</th>
                            <th class="head0" style="width:230px;">&nbsp;</th>
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>  
                            <th class="head1" style="width:330px;">Nome</th>
                            <th class="head0" style="width:100px;">Codice gevenit</th>
                            <th class="head1" style="width:100px;">Codice mepa</th>
                            <th class="head0" style="width:100px;">Codice fornitore</th>
                             <th class="head1" style="width:70px;"> Prezzo</th>
                            <th class="head0" style="width:270px;">Sottocategoria</th> 
                            <th class="head1" style="width:130px;">Quantità</th>
                            <th class="head0" style="width:230px;">&nbsp;</th>
                        </tr>

                    </tfoot>

              <tbody>

            <?php     
            
                    $db->query( "SELECT bag_articoli.* 
                                 FROM 
                                 bag_articoli
                                 WHERE quantita=0
                                 ORDER BY bag_articoli.nome");
            
                    $records = $db->resultset();
                
            
                 if ($db->rowCount() == 0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ foreach ($records as $list)  {    ?> 

                 <tr class="gradeX">
                        <td><?=$list['nome'];?></td>
                        <td><?=$list['codice'];?></td>
                        <td><?=$list['codice_mepa'];?></td>
                        <td><?=$list['codice_fornitore'];?></td>
                        <td><?=$list['prezzo'];?></td> 
                        <td>
                         <?php 
                             $db->query("SELECT * FROM bag_scat WHERE id='".$list['id_sottocategoria']."' ");
                             $listm=$db->single();
                             echo $listm['nome'];   
                            ?>
                
                        </td> 
                        
                        <td><center><?=$list['quantita'];?></center></td>                  
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§<?=$list['id'];?>§elimina§bag_articoli">Elimina</a></td>
                        <form id="edit<?=$list['id'];?>" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                        <input type="hidden" name="opt" id="opt" value="edit" />
                        <input type="hidden" value="<?=$list['id'];?>" id="id" name="id" />
                        </form> 
                 </tr>

          <?php }  ?>

            </tbody>

           </table>

     </div> 

  </div>             

           <br /><br />

                 <?php   }    }   //FINE VISUALIZZAZIONE  

else if($todo=='new') {  //INIZIO INSERIMENTO NUOVO PRODOTTO

     $db->query("SELECT max(id) AS idmax FROM bag_articoli ");
     $listm = $db->single();
     $nextid=$listm['idmax']+1;      
     
     ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="insprodotto" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVO PRODOTTO</h3></div><!--contenttitle--><br />
                       
                      
                        <p>
			<b>Nome</b><br />
                            <input type="text" name="nome" id="nome" class="smallinput" required />
                        </p>
                        <p>
                        <b>Descrizione </b><br />
                          <textarea  name="descrizione" id="descrizione" class="tinymce"></textarea>
                        </p>  
                         <p>
                            <b>Prezzo</b><br />
                            <span class="field"><input type="text" name="prezzo" id="prezzo" class="smallinput" /></span>
                        </p>
                        <p>
                            <b>Prezzo Scontato</b><br />
                            <span class="field"><input type="text" name="prezzo_scontato" id="prezzo_scontato" class="smallinput" /></span>
                        </p>
                        
                        <p>
                           <b>Sottocategoria</b><br />
                            <span class="field">
                            <select name="id_sottocategoria" class="uniformselect">
                            <?php 
                             $db->query("SELECT * FROM bag_scat order by nome");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                            	<option value="<?=$listm['id'];?>"><?=$listm['nome'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                       </p>
<!--                        <p>
                            <b>Prodotto disponibile</b><br />
                            <span class="field">
                            <select name="disponibile" class="uniformselect">
                            <option value="s">Si</option>
                            <option value="n">No</option>
                            </select>
                            </span>
                        </p>-->
                         <p>
			<b>Quantità</b><br />
                            <input type="text" name="quantita" id="quantita" class="smallinput" required />
                        </p>
                        <p>
                            <b>Tempo di consegna: </b><br />
                            <span class="field"><input type="text" name="disponibile_tra" id="disponibile_tra" class="smallinput" /></span>
                        </p>
                        
                        <p>
                            <b>Prezzo Disponibile</b><br />
                            <span class="field">
                            <select name="prezzo_disponibile" class="uniformselect">
                            <option value="s">Si</option>
                            <option value="n">No</option>
                            </select>
                            </span>
                        </p>
                        
                        <p>
                        <b>Testo Offerta</b> <br />
                        <textarea  name="testo_offerta" id="testo_offerta" class="tinymce"></textarea>
                        </p> 
                        
                        
 
        	        <p>
			<b>Codice gevenit</b><br />
                       <span class="field"><input type="text" name="codice" id="codice" class="smallinput"/></span>
                       </p>
                       
                        <p>
			<b>Codice mepa</b><br />
                       <span class="field"><input type="text" name="codice_mepa" id="codice_mepa" class="smallinput"/></span>
                       </p>
                       
                       <p>
			<b>Codice fornitore</b><br />
                       <span class="field"><input type="text" name="codice_fornitore" id="codice_fornitore" class="smallinput"/></span>
                       </p>
                       
                       <p>
			<b>Taglie disponibili: </b><br />
                       <span class="field"><input type="text" name="taglia" id="taglia" class="smallinput"/></span>
                       </p>
                       
                       <p>
			<b>Colori disponibili: </b><br />
                       <span class="field"><input type="text" name="colore" id="colore" class="smallinput"/></span>
                       </p>
                       
                       
                       
                       
                       <p>
			<b>Scheda Tecnica</b><br />
                        <input type="hidden" class="smallinput" value="" name="tecnica" id="tecnica" />
                       </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="tecnica_upload" id="tecnica_upload" />
                            </span>
                            
                    </div> 
                    <div id="boxtecnica1" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="tecnica1" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#tecnica_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifypdf.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'scheda_tecnica','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#tecnica').val(data);
                                jQuery('#tecnica1').attr('src','<?=$phpThumbBase;?>?src=../images/icona_pdf.gif');
                                jQuery('#boxtecnica1').fadeIn();
                                                                               } 
                                                         });
                    });
                    </script> 
                    
                        <p >
			<b>Scheda di Sicurezza</b><br />
                        <input type="hidden" class="smallinput" value="" name="sicurezza" id="sicurezza" />
                       </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="sicurezza_upload" id="sicurezza_upload" />
                            </span>
                            
                    </div> 
                    <div id="boxsicurezza1" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="sicurezza1" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#sicurezza_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifypdf.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'scheda_sicurezza','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#sicurezza').val(data);
                                jQuery('#sicurezza1').attr('src','<?=$phpThumbBase;?>?src=../images/icona_pdf.gif');
                                jQuery('#boxsicurezza1').fadeIn();
                                                                               } 
                                                         });
                    });
                    </script>  
                      <br /> <br />
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------- <br />  
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------
                      <br /><br /> 
                    <p>
			<b>Immagine principale</b><br />
                        <input type="hidden" class="smallinput" value="" name="img1" id="img1" />
                       </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img1_upload" id="img1_upload" />
                            </span>
                            
                    </div> 
                    <div id="box1" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="image1" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img1_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'img1','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img1').val(data);
                                jQuery('#image1').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box1').fadeIn();
                                                                               } 
                                                         });
                    });
                    </script> 
       
      		    <p>
			<b>Immagine 2</b><br />
                        <input type="hidden" class="smallinput" value="" name="img2" id="img2" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img2_upload" id="img2_upload" />
                            </span> 
                    </div> 
                    <div id="box2" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="image2" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img2_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'img2','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img2').val(data);
                                jQuery('#image2').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box2').fadeIn();
                                                                               } 
                        });
                    });
                    </script>

                    
		 <p>
		  <b>Immagine 3</b><br />
                        <input type="hidden" class="smallinput" value="" name="img3" id="img3" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img3_upload" id="img3_upload" />
                            </span>
                            
                    </div> 
                    <div id="box3" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="image3" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img3_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'img3','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img3').val(data);
                                jQuery('#image3').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box3').fadeIn();
                                                                               } 
                        });
                    });
                    </script>  
                    
                    
                    <p>
		  <b>Immagine 4</b><br />
                        <input type="hidden" class="smallinput" value="" name="img4" id="img4" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img4_upload" id="img4_upload" />
                            </span>
                            
                    </div> 
                    <div id="box4" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="image4" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img4_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'img4','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img4').val(data);
                                jQuery('#image4').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box4').fadeIn();
                                                                               } 
                         });
                    });
                    </script> 

                        <p>
		  <b>Immagine 5</b><br />
                        <input type="hidden" class="smallinput" value="" name="img5" id="img5" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img5_upload" id="img5_upload" />
                            </span>
                            
                    </div> 
                    <div id="box5" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="image5" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img5_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'img5','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img5').val(data);
                                jQuery('#image5').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box5').fadeIn();
                                                                               } 
                         });
                    });
                    </script>  
                    
                    
  
                     <br />
                          <p class="stdformbutton" style="margin-left:470px;">
                        	<button id="submit" class="submit radius2">Inserisci</button>
                        </p>
                        <p>
                        <div id="err_mess"></div>
                        </p>
                        </form>
                    
                     </div> 

        </div> 

    </div>


<?php }  //FINE INSERIMENTO PRODOTTO

else if($todo=='edit') { //INIZIO MODIFICA PRODOTTO

     $db->query("SELECT * FROM bag_articoli WHERE id='".$_REQUEST['id']."' ");
     $list=$db->single();
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editprodotto" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>PRODOTTO</h3></div><!--contenttitle--><br />
                       
<p>
			<b>Nome</b><br />
                        <input type="text" name="nome" id="nome" class="smallinput" value="<?=$list['nome'];?>"  required/>
                        </p>
                        <p>
                        <b>Descrizione </b><br />
                          <textarea  name="descrizione" id="descrizione" class="tinymce"><?=$list['descrizione'];?></textarea>
                        </p>  
                         <p>
                            <b>Prezzo</b><br />
                            <span class="field"><input type="text" name="prezzo" id="prezzo" class="smallinput" value="<?=$list['prezzo'];?>" /></span>
                        </p>
                        <p>
                            <b>Prezzo Scontato</b><br />
                            <span class="field"><input type="text" name="prezzo_scontato" id="prezzo_scontato" class="smallinput" value="<?=$list['prezzo_scontato'];?>"/></span>
                        </p>
                        
                        <p>
                           <b>Sottocategoria</b><br />
                            <span class="field">
                            <select name="id_sottocategoria" class="uniformselect">
                            <?php 
                             $db->query("SELECT * FROM bag_scat order by nome");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                            	<option value="<?=$listm['id'];?>" <?php if($list['id_sottocategoria']==$listm['id']) echo "selected='selected'";  ?>><?=$listm['nome'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                       </p>
<!--                        <p>
                            <b>Prodotto disponibile</b><br />
                            <span class="field">
                            <select name="disponibile" class="uniformselect">
                            <option value="s" <?php if($list['disponibile']=='s') echo "selected='selected'";  ?>>Si</option>
                            <option value="n" <?php if($list['disponibile']=='n') echo "selected='selected'";  ?>>No</option>
                            </select>
                            </span>
                        </p>-->
                         <p>
			<b>Quantità</b><br />
                            <input type="text" name="quantita" id="quantita" class="smallinput" value="<?=$list['quantita'];?>" required />
                        </p>
                        <p>
                            <b>Tempo di consegna: </b><br />
                            <span class="field"><input type="text" name="disponibile_tra" id="disponibile_tra" class="smallinput" value="<?=$list['disponibile_tra'];?>"/></span>
                        </p>
                        
                        <p>
                            <b>Prezzo Disponibile</b><br />
                            <span class="field">
                            <select name="prezzo_disponibile" class="uniformselect">
                            <option value="s" <?php if($list['prezzo_disponibile']=='s') echo "selected='selected'";  ?> >Si</option>
                            <option value="n" <?php if($list['prezzo_disponibile']=='n') echo "selected='selected'";  ?> >No</option>
                            </select>
                            </span>
                        </p>
                        
                        <p>
                        <b>Testo Offerta</b> <br />
                        <textarea  name="testo_offerta" id="testo_offerta" class="tinymce"><?=$list['testo_offerta'];?></textarea>
                        </p> 
                     
        	        <p>
			<b>Codice gevenit</b><br />
                       <span class="field"><input type="text" name="codice" id="codice" class="smallinput" value="<?=$list['codice'];?>"/></span>
                       </p>
                       
                        <p>
			<b>Codice mepa</b><br />
                       <span class="field"><input type="text" name="codice_mepa" id="codice_mepa" class="smallinput" value="<?=$list['codice_mepa'];?>"/></span>
                       </p>
                       
                       <p>
			<b>Codice fornitore</b><br />
                       <span class="field"><input type="text" name="codice_fornitore" id="codice_fornitore" class="smallinput" value="<?=$list['codice_fornitore'];?>"/></span>
                       </p>
                       
                       <p>
			<b>Taglie disponibili:</b><br />
                       <span class="field"><input type="text" name="taglia" id="taglia" class="smallinput" value="<?=$list['taglia'];?>"/></span>
                       </p>
                       
                       <p>
			<b>Colori disponibili:</b><br />
                       <span class="field"><input type="text" name="colore" id="colore" class="smallinput" value="<?=$list['colore'];?>"/></span>
                       </p>
                           <p>
		  <b>Scheda Tecnica</b><br />
                  <input type="hidden" class="smallinput" name="tecnica" id="tecnica" value="<?=$list['scheda_tecnica'];?>" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       
                    <span class="field">
                    <input  name="tecnica_upload" id="tecnica_upload" value="<?=$list['scheda_tecnica'];?>"/>
                    </span>
                            
                    </div> 
                    <div id="boxtecnica1" style=" <?php if($list['scheda_tecnica']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                        <a href="../schede/<?=$list['scheda_tecnica'];?>" target="_blank">
                            <img id="tecnica1" src="<?=$phpThumbBase;?>?src=../images/icona_pdf.gif"  border="0" />  
                        </a>     
                    <span style="cursor: pointer;" onclick="jQuery('#tecnica').val('');jQuery('#boxtecnica1').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminascheda',image:'<?=$list['scheda_tecnica'];?>',idprod:'<?=$list['id'];?>',titolo:'scheda_tecnica'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#tecnica_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifypdf.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'scheda_tecnica','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#tecnica').val(data);
                                jQuery('#tecnica1').attr('src','<?=$phpThumbBase;?>?src=../images/icona_pdf.gif');
                                jQuery('#boxtecnica1').fadeIn();
                                                                               } 
                        });
                    });
                    </script>    
                    
                    
                             <p>
		  <b>Scheda Sicurezza</b><br />
                  <input type="hidden" class="smallinput" name="sicurezza" id="sicurezza" value="<?=$list['scheda_sicurezza'];?>" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       
                    <span class="field">
                    <input  name="sicurezza_upload" id="sicurezza_upload" value="<?=$list['scheda_sicurezza'];?>"/>
                    </span>
                            
                    </div> 
                    <div id="boxsicurezza1" style=" <?php if($list['scheda_sicurezza']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                        <a href="../schede/<?=$list['scheda_sicurezza'];?>" target="_blank">
                            <img id="sicurezza1" src="<?=$phpThumbBase;?>?src=../images/icona_pdf.gif"  border="0" />  
                        </a>     
                    <span style="cursor: pointer;" onclick="jQuery('#sicurezza').val('');jQuery('#boxsicurezza1').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminascheda',image:'<?=$list['scheda_sicurezza'];?>',idprod:'<?=$list['id'];?>',titolo:'scheda_sicurezza'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#sicurezza_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifypdf.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'scheda_sicurezza','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#sicurezza').val(data);
                                jQuery('#sicurezza1').attr('src','<?=$phpThumbBase;?>?src=../images/icona_pdf.gif');
                                jQuery('#boxsicurezza1').fadeIn();
                                                                               } 
                        });
                    });
                    </script>  
                       
                        <br /> <br />
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------<br />
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------
                      <br /><br />   
                       <p>
			<b>Immagine principale</b><br />
                  <input type="hidden" class="smallinput" name="img1" id="img1" value="<?=$list['img1'];?>" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       
                    <span class="field">
                    <input  name="img1_upload" id="img1_upload" value="<?=$list['img1'];?>"/>
                    </span>
                            
                    </div> 
                    <div id="box1" style=" <?php if($list['img1']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                    <img id="image1" src="<?=$phpThumbBase;?>?src=../images/img_prod/<?=$list['img1'];?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                    <span style="cursor: pointer;" onclick="jQuery('#img1').val('');jQuery('#box1').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoprod',image:'<?=$list['img1'];?>',idprod:'<?=$list['id'];?>',titolo:'img1'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img1_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'img1','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img1').val(data);
                                jQuery('#image1').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box1').fadeIn();
                                                                               } 
                        });
                    });
                    </script> 


                     <p>
			<b>Immagine 2</b><br />
                        <input type="hidden" class="smallinput" name="img2" id="img2" value="<?=$list['img2'];?>" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       
                    <span class="field">
                    <input  name="img2_upload" id="img2_upload" value="<?=$list['img2'];?>" />
                    </span>
                            
                    </div> 
                    <div id="box2" style=" <?php if($list['img2']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                    <img id="image2" src="<?=$phpThumbBase;?>?src=../images/img_prod/<?=$list['img2'];?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                    <span style="cursor: pointer;" onclick="jQuery('#img2').val('');jQuery('#box2').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoprod',image:'<?=$list['img2'];?>',idprod:'<?=$list['id'];?>',titolo:'img2'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img2_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'img2','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img2').val(data);
                                jQuery('#image2').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box2').fadeIn();
                                                                               } 
                        });
                    });
                    </script>  

		<p>
		<b>Immagine 3</b><br />
                        <input type="hidden" class="smallinput"  name="img3" id="img3" value="<?=$list['img3'];?>"  />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img3_upload" id="img3_upload"  />
                            </span>
                            
                    </div> 
                    <div id="box3" style=" <?php if($list['img3']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                    <img id="image3" src="<?=$phpThumbBase;?>?src=../images/img_prod/<?=$list['img3'];?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                    <span style="cursor: pointer;" onclick="jQuery('#img3').val('');jQuery('#box3').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoprod',image:'<?=$list['img3'];?>',idprod:'<?=$list['id'];?>',titolo:'img3'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img3_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'img3','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img3').val(data);
                                jQuery('#image3').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box3').fadeIn();
                                                                               } 
                        });
                    });
                    </script>  
                    
                    
                <p>
		<b>Immagine 4</b><br />
                        <input type="hidden" class="smallinput"  name="img4" id="img4" value="<?=$list['img4'];?>"  />
                </p>
                    <br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img4_upload" id="img4_upload"  />
                            </span>
                            
                    </div> 
                    <div id="box4" style=" <?php if($list['img4']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                    <img id="image4" src="<?=$phpThumbBase;?>?src=../images/img_prod/<?=$list['img4'];?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                    <span style="cursor: pointer;" onclick="jQuery('#img4').val('');jQuery('#box4').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoprod',image:'<?=$list['img4'];?>',idprod:'<?=$list['id'];?>',titolo:'img4'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img4_upload').uploadify({
                            height        : 40,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'img4','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#img4').val(data);
                                jQuery('#image4').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box4').fadeIn();
                                                                               } 
                        });
                    });
                    </script> 
                    
                    
                 <p>
		 <b>Immagine 5</b><br />
                 <input type="hidden" class="smallinput"  name="img5" id="img5" value="<?=$list['img5'];?>"  />
                 </p><br />
                    
                    <div style="float:left;width:150px;">       
                        <span class="field">
                        <input  name="img5_upload" id="img5_upload"  />
                        </span>    
                    </div> 
                    <div id="box5" style=" <?php if($list['img5']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                    <img id="image5" src="<?=$phpThumbBase;?>?src=../images/img_prod/<?=$list['img5'];?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                    <span style="cursor: pointer;" onclick="jQuery('#img5').val('');jQuery('#box5').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoprod',image:'<?=$list['img5'];?>',idprod:'<?=$list['id'];?>',titolo:'img5'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img5_upload').uploadify({
                            height     : 50,
                            width      : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyprod.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'img5','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                            jQuery('#img5').val(data);
                            jQuery('#image5').attr('src','<?=$phpThumbBase;?>?src=../images/img_prod/'+data+'&iar=1&w=50&h=50&aoe=1');
                            jQuery('#box5').fadeIn();
                                                                               } 
                        });
                    });
                    </script> 

                    
                    <p class="stdformbutton" style="margin-left:470px;">
                        <button id="submit" class="submit radius2">Salva</button>
                    </p>
                        <p>
                    <div id="err_mess"></div>
                        </p>

                        </form>


                     </div> 
        

        </div> 

  </div> 


<?php }  //FINE EDIT PRODOTTO

?>


<script>

        jQuery("#form_prodotti").submit(  
        
                function () { 
                         jQuery.post("<?=BASE_URL;?>functionload.php",jQuery("#form_prodotti").serialize(),
                              function(data) {  
                           
                                            //Se ci sono errori in fase di registrazione 
                                            if(data.errore!='no'){
                                                
                                            jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                                            }  
                                             else { 
                                                
                                             jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                                          setTimeout(function(){window.location.href = "prodottiesauriti.php";},1500); 
                                                    
                                                   }                                         
                                             },          
                              "json"
                              );
                 
                           } 
                          );

</script>  

</body>

</html>
      