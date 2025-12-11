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


  
  
 <!-- DIV per associare il prodotto ai tag -->
 
 <div style="display:none">
 <div id="data" style="width:750px;height:550px;">
 </div>
  <div id="datal" style="width:750px;height:550px;">
 </div>
 <div id="datacorr" style="width:750px;height:550px;">
 </div>
 <div id="dataass" style="width:750px;height:550px;">
 </div>
 </div> 
 
<!-- -->       

  <div class="centercontent tables">

        <div id="contentwrapper" class="contentwrapper">

                 <div class="contenttitle2">

                	<h3>Gestione Prodotti</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>index.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        
                    </colgroup>

                   <thead>
                        <tr>
                            
                            <th class="head1" >Nome</th>
                            <th class="head0" >Codice</th>
                            <th class="head1" >Categoria</th>
                            <th class="head0" >&nbsp;</th>
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>
                            
                            <th class="head1" >Nome</th>
                            <th class="head0" >Codice</th>
                            <th class="head1" >Categoria</th>
                            <th class="head0" >&nbsp;</th>
                        </tr>

                    </tfoot>

              <tbody>

            <?php     
            
                 $db->query( "SELECT prodotti.*,categorie.*  
                              FROM prodotti,categorie
                              WHERE prodotti.id_categoria=categorie.id_categoria
                              ORDER BY prodotti.nome_prodotto_it" );
            
                $records = $db->resultset();
                
            
                 if ($db->rowCount() == 0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ foreach ($records as $list) {    ?> 

                 <tr class="gradeX">    
                        <td><?=$list['nome_prodotto_it'];?></td>
                        <td><?=$list['cod_prodotto'];?></td>
                        <td><?=  ucfirst($list['categoria_it']);?></td>    
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id_prodotto'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§id_prodotto§<?=$list['id_prodotto'];?>§elimina§prodotti">Elimina</a></td>
                        <form id="edit<?=$list['id_prodotto'];?>" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                        <input type="hidden" name="opt" id="opt" value="edit" />
                        <input type="hidden" value="<?=$list['id_prodotto'];?>" id="id" name="id" />
                        </form> 
                 </tr>

          <?php }  ?>

            </tbody>

           </table>

     </div> 

  </div>             

           <br /><br />

                 <?php   }  ?>


   <?php   }   //FINE VISUALIZZAZIONE  

else if($todo=='new') {  //INIZIO INSERIMENTO NUOVO PRODOTTO

     $db->query("SELECT max(id_prodotto) AS idmax FROM prodotti");
     $maxprod = $db->single();
     $nextid= $maxprod['idmax']+1;      
     
     ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="insprodotto" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVO PRODOTTO</h3></div><!--contenttitle--><br />
                       
                      
                       <p>
			<b>Codice</b><br />
                        <input type="text" name="cod_prodotto" id="cod_prodotto" class="smallinput"  required />
                       </p>
                       
                       <p>
			<b>Nome italiano</b><br />
                            <input type="text" name="nome_prodotto_it" id="nome_prodotto_it" class="smallinput"  required  />
                       </p>
                       
                        <p>
			<b>Nome inglese</b><br />
                            <input type="text" name="nome_prodotto_eng" id="nome_prodotto_eng" class="smallinput"  />
                       </p>
                       <p>
                        	<b>Descrizione italiano</b><br />
                            <span class="field"><input type="text" name="descrizione_it" id="descrizione_breve_it" class="smallinput"/></span>
                        </p>
                        <p>
                        	<b>Descrizione  inglese</b><br />
                            <span class="field"><input type="text" name="descrizione_eng" id="descrizione_breve_eng" class="smallinput"/></span>
                        </p>
                        <p>
                        <p>
                            <b>Categoria</b><br />
                            <span class="field">
                            <select name="id_categoria" class="uniformselect"  required >
                            <?php 
                             $db->query("SELECT * FROM categorie order by categoria_it");
                             $recordm=$db->resultset();
                             foreach ($recordm AS $listm) { ?>
                             <option value="<?=$listm['id_categoria'];?>"><?=$listm['categoria_it'];?></option>
                             <?php } ?>                        
                             </select>
                             </span>
                         </p>     
                            
                       <b>Categoria Commerciale</b><br />
                            <input type="text" name="categoria_commerciale" id="categoria_commerciale" class="smallinput"  />
                       </p>
                       <p>
                       <b>Peso</b><br />
                            <input type="text" name="peso" id="peso" class="smallinput"  />
                       </p>
                       <p>
                       <b>Peso Confezione</b><br />
                            <input type="text" name="peso_confezione" id="peso_confezione" class="smallinput"  />
                       </p>
                       <p>
                       <b>Banner</b><br />
                            <input type="text" name="banner" id="banner" class="smallinput"  />
                       </p>
                       <p>
                       <b>Dimensioni</b><br />
                            <input type="text" name="dimensioni" id="dimensioni" class="smallinput"  />
                       </p>
                       <p>
                       <b>Pezzi</b><br />
                            <input type="text" name="pezzi" id="pezzi" class="smallinput"  />
                       </p>
                       <p>
                       <b>Metatag Title</b><br />
                            <input type="text" name="title" id="title" class="smallinput"  />
                       </p>
                       <p>
                       <b>Metatag keywords</b><br />
                            <input type="text" name="keywords" id="keywords" class="smallinput"  />
                       </p>
                       <p>
                       <b>Metatag Description</b><br />
                            <input type="text" name="description" id="description" class="smallinput"  />
                       </p>
                       <p>
                       <b>Url</b><br />
                            <input type="text" name="url" id="url" class="smallinput"  />
                       </p>

                       

                        <p>
                        <b>Immagine</b><br />
                                <input type="hidden" class="smallinput" value="" name="immagine" id="immagine" />
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
                                    'formData' : { 'num' : '<?=$nextid;?>','action':'ins' } ,
                                    'onUploadSuccess' : function(file, data, response) {
                                       //alert('The file was saved to: ' + data);
                                       jQuery('#immagine').val(data); 
                                        jQuery('#image1').attr('src','<?=$phpThumbBase;?>?src=../images/prodotti/'+data+'&iar=1&w=50&h=50&aoe=1');
                                        jQuery('#box1').fadeIn();
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

     $db->query("SELECT * FROM prodotti WHERE id_prodotto='".$_REQUEST['id']."' ");
     $list = $db->single();
          
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editprodotto" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>PRODOTTO</h3></div><!--contenttitle--><br />
                       


                     <p>
			<b>Codice</b><br />
                        <input type="text" name="cod_prodotto" id="cod_prodotto" class="smallinput" value="<?=$list['cod_prodotto'];?>"  required />
                       </p>
                       
                       <p>
			<b>Nome italiano</b><br />
                            <input type="text" name="nome_prodotto_it" id="nome_prodotto_it" class="smallinput" value="<?=$list['nome_prodotto_it'];?>"   required  />
                       </p>
                       
                        <p>
			<b>Nome inglese</b><br />
                            <input type="text" name="nome_prodotto_eng" id="nome_prodotto_eng" class="smallinput" value="<?=$list['nome_prodotto_eng'];?>"  />
                       </p>
                       <p>
                        	<b>Descrizione italiano</b><br />
                            <span class="field"><input type="text" name="descrizione_it" id="descrizione_it" class="smallinput" value="<?=$list['descrizione_it'];?>" /></span>
                        </p>
                        <p>
                        	<b>Descrizione  inglese</b><br />
                            <span class="field"><input type="text" name="descrizione_eng" id="descrizione_eng" class="smallinput" value="<?=$list['descrizione_eng'];?>" /></span>
                        </p>
                        <p>
                        <p>
                            <b>Categoria</b><br />
                            <span class="field">
                            <select name="id_categoria" class="uniformselect"  required >
                            <?php 
                             $db->query("SELECT * FROM categorie order by categoria_it");
                             $recordm=$db->resultset();
                             foreach ($recordm AS $listm) { ?>m
                             <option value="<?=$listm['id_categoria'];?>" <?php if($listm['id_categoria'] == $list['id_categoria']) echo "selected='selected'";  ?> ><?=$listm['categoria_it'];?></option>
                             <?php } ?>                        
                             </select>
                             </span>
                         </p>     
                            
                       <b>Categoria Commerciale</b><br />
                            <input type="text" name="categoria_commerciale" id="categoria_commerciale" class="smallinput" value="<?=$list['categoria_commerciale'];?>" />
                       </p>
                       <p>
                       <b>Peso</b><br />
                            <input type="text" name="peso" id="peso" class="smallinput" value="<?=$list['peso'];?>" />
                       </p>
                       <p>
                       <b>Peso Confezione</b><br />
                            <input type="text" name="peso_confezione" id="peso_confezione" class="smallinput" value="<?=$list['peso_confezione'];?>" />
                       </p>
                       <p>
                       <b>Banner</b><br />
                            <input type="text" name="banner" id="banner" class="smallinput" value="<?=$list['banner'];?>" />
                       </p>
                       <p>
                       <b>Dimensioni</b><br />
                            <input type="text" name="dimensioni" id="dimensioni" class="smallinput" value="<?=$list['dimensioni'];?>" />
                       </p>
                       <p>
                       <b>Pezzi</b><br />
                            <input type="text" name="pezzi" id="pezzi" class="smallinput" value="<?=$list['pezzi'];?>" />
                       </p>
                       <p>
                       <b>Metatag Title</b><br />
                            <input type="text" name="title" id="title" class="smallinput" value="<?=$list['title'];?>" />
                       </p>
                       <p>
                       <b>Metatag keywords</b><br />
                            <input type="text" name="keywords" id="keywords" class="smallinput" value="<?=$list['keywords'];?>" />
                       </p>
                       <p>
                       <b>Metatag Description</b><br />
                            <input type="text" name="description" id="description" class="smallinput" value="<?=$list['description'];?>" />
                       </p>
                       <p>
                       <b>Url</b><br />
                            <input type="text" name="url" id="url" class="smallinput" value="<?=$list['url'];?>" />
                       </p>
                      
                        <p>
                        <b>Immagine</b><br />
                         <?php 
                            
                            //if($list['immagine']!='') $immagine=$list['immagine'];  else  $immagine=$list['cod_prodotto'];
                            
                              //PRENDO IMMAGINE PRODOTTO
                              if($list['immagine']!=''){
                                  $immagine=$list['immagine']; 
                                  $ext="";
                              }else  {
                                  $immagine=$list['cod_prodotto'];
                                  $ext=".jpg";
                              }
                            ?>
                                <input type="hidden" class="smallinput" value="<?=$immagine.$ext;?>" name="immagine" id="immagine" />
                        </p><br />

                            <div style="float:left;width:150px;">       
                                <span class="field">
                                    <input  name="img1_upload" id="img1_upload" />
                                    </span>

                            </div> 
                           
                        
                            <div id="box1" style="<?php if($immagine =='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                            <img id="image1" src="<?=$phpThumbBase;?>?src=../images/prodotti/<?=$immagine.$ext;?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                            <span style="cursor: pointer;" onclick="jQuery('#immagine').val('');jQuery('#box1').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoprod',image:'<?=$immagine;?>',idprod:'<?=$list['id_prodotto'];?>'});" >
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
                                    'formData' : { 'num' : '<?=$_REQUEST['id'];?>','action':'edit' } ,
                                    'onUploadSuccess' : function(file, data, response) {
                                       //alert('The file was saved to: ' + data);
                                       jQuery('#immagine').val(data); 
                                        jQuery('#image1').attr('src','<?=$phpThumbBase;?>?src=../images/prodotti/'+data+'&iar=1&w=50&h=50&aoe=1');
                                        jQuery('#box1').fadeIn();
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
                                               
                                            setTimeout(function(){window.location.href = "index.php";},1500); 
                                               }     
                                                                                           
                                             } ,        
                              "json"
                              );
                 
                           } 
                          );

</script>  



</body>

</html>
      