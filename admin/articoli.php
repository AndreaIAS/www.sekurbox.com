<?php
    require ("config.php");
    require ("inc_header.php");    
    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt']; else   $todo = 'view';
?>


    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/charCount.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/ui.spinner.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tooltip.jquery.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tinymce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/editor.js"></script> 


    <style>
        .stdform label{width: 100px; text-align:right;padding:0px 0px 0px 0px;}
        .stdform span.field, .stdform div.field { margin-left: 0px;}
        .input-group-btn a.btn{
            background-image:inherit;
            margin-left: 0px;

        }
        .input-group-btn a.btn span{
            padding: 0px 5px;
            margin-left: 0px;
            display: inherit;
        }
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

                	<h3>Gestione Articoli</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>articoli.php?opt=new">
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
                            <th class="head0" >Visibile</th>
                            <th class="head1" >Titolo</th>
                            <th class="head0" >Autore</th>
                            <th class="head1" >Categoria</th>
                            <th class="head0" >&nbsp;</th>
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>
                            <th class="head1" >Visibile</th>
                            <th class="head1" >Titolo</th>
                            <th class="head0" >Autore</th>
                            <th class="head1" >Categoria</th>
                            <th class="head0" >&nbsp;</th>
                        </tr>

                    </tfoot>

              <tbody>

            <?php     
            
                 $db->query( "SELECT articoli.*,categorie_articoli.*  
                              FROM articoli,categorie_articoli
                              WHERE articoli.categoria=categorie_articoli.id_categoria_articolo
                              ORDER BY articoli.titolo_it" );
            
                $records = $db->resultset();
                
            
                 if ($db->rowCount() == 0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ foreach ($records as $list) {    ?> 

                 <tr class="gradeX">
                         <td><center><img src="./images/<?=$list['visible'];?>.jpg" border="0"/></center></td>
                        <td><?=$list['titolo_it'];?></td>
                        <td><?=$list['autore'];?></td>
                        <td><?=  ucfirst($list['categoria_articolo_it']);?></td>    
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id_articolo'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§id_articolo§<?=$list['id_articolo'];?>§elimina§articoli">Elimina</a>
                        <form id="edit<?=$list['id_articolo'];?>" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                        <input type="hidden" name="opt" id="opt" value="edit" />
                        <input type="hidden" value="<?=$list['id_articolo'];?>" id="id" name="id" />
                        </form>
                        </td>
                         
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

     $db->query("SELECT max(id_articolo) AS idmax FROM articoli");
     $maxprod = $db->single();
     $nextid= $maxprod['idmax']+1;      
     
     ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="insarticolo" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVO ARTICOLO</h3></div><!--contenttitle--><br />
                       
                         <p>
                           <label>Visibile</label>
                            <span class="field">
                            <select name="visible" class="uniformselect">
                            <option value="s">Si</option>
                            <option value="n">No</option>
                            </select>
                            </span>
                        </p>
                       <p>
			<b>Autore</b><br />
                        <input type="text" name="autore" id="autore" class="smallinput"  required />
                       </p>
                       
                       <p>
			<b>Titolo</b><br />
                            <input type="text" name="titolo_it" id="titolo_it" class="smallinput"  required  />
                       </p>

                        <p>
                        	<b>Articolo</b><br />
                        <textarea id="articolo_it" name="articolo_it" rows="15" cols="80" style="width: 80%" class="tinymce">
                         
                        </textarea>
                        </p> 
                        
                        
                        
                        
                        <p>
                            <b>Categoria</b><br />
                            <span class="field">
                            <select name="categoria" class="uniformselect"  required >
                            <?php 
                             $db->query("SELECT * FROM categorie_articoli");
                             $recordm=$db->resultset();
                             foreach ($recordm AS $listm) { ?>
                             <option value="<?=$listm['id_categoria_articolo'];?>"><?=$listm['categoria_articolo_it'];?></option>
                             <?php } ?>                        
                             </select>
                             </span>
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
                                    'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyart.php',
                                    'method'   : 'post',
                                    'formData' : { 'action':'ins' } ,
                                    'onUploadSuccess' : function(file, data, response) {
                                       //alert('The file was saved to: ' + data);
                                       jQuery('#immagine').val(data); 
                                        jQuery('#image1').attr('src','<?=$phpThumbBase;?>?src=../galleria/'+data+'&iar=1&w=50&h=50&aoe=1');
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

     $db->query("SELECT * FROM articoli WHERE id_articolo='".$_REQUEST['id']."' ");
     $list = $db->single();
          
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editarticolo" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>ARTICOLO</h3></div><!--contenttitle--><br />
                       <p>
                        	<label>Visibile</label>
                            <span class="field">
                            <select name="visible" class="uniformselect">
                            	<option value="s" <?php if($list['visible']=='s') echo "selected='selected'";  ?> >Si</option>
                                <option value="n" <?php if($list['visible']=='n') echo "selected='selected'";  ?> >No</option>
                            </select>
                            </span>
                        </p>

                       <p>
			<b>Autore</b><br />
                        <input type="text" name="autore" id="autore" class="smallinput"  value="<?=$list['autore'];?>" required />
                       </p>
                       
                       <p>
			<b>Titolo</b><br />
                            <input type="text" name="titolo_it" id="titolo_it" class="smallinput" value="<?=$list['titolo_it'];?>" required  />
                       </p>
                       
                        
                        <p>
                        	<b>Articolo</b><br />
                        <textarea id="articolo_it" name="articolo_it" rows="15" cols="80" style="width: 80%"  class="tinymce">
                         <?=$list['articolo_it'];?>
                        </textarea>
                        </p> 

                        <p>
                            <b>Categoria</b><br />
                            <span class="field">
                            <select name="categoria" class="uniformselect"  required >
                            <?php 
                             $db->query("SELECT * FROM categorie_articoli");
                             $recordm=$db->resultset();
                             foreach ($recordm AS $listm) { ?>
                             <option value="<?=$listm['id_categoria_articolo'];?>" <?php if($listm['id_categoria_articolo'] == $list['categoria']) echo "selected='selected'";  ?>><?=$listm['categoria_articolo_it'];?></option>
                             <?php } ?>                        
                             </select>
                             </span>
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
                             
                                  $immagine=$list['immagine']; 
                           
                            ?>
                                <input type="hidden" class="smallinput" value="<?=$immagine;?>" name="immagine" id="immagine" />
                        </p><br />

                            <div style="float:left;width:150px;">       
                                <span class="field">
                                    <input  name="img1_upload" id="img1_upload" />
                                    </span>

                            </div> 
                           
                        
                            <div id="box1" style="<?php if($immagine =='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                            <img id="image1" src="<?=$phpThumbBase;?>?src=../galleria/<?=$immagine;?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                            <span style="cursor: pointer;" onclick="jQuery('#immagine').val('');jQuery('#box1').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotoart',image:'<?=$immagine;?>',idprod:'<?=$list['id_articolo'];?>'});" >
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
                                    'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyart.php',
                                    'method'   : 'post',
                                    'formData' : { 'num' : '<?=$_REQUEST['id'];?>','action':'ins' } ,
                                    'onUploadSuccess' : function(file, data, response) {
                                       //alert('The file was saved to: ' + data);
                                       jQuery('#immagine').val(data); 
                                        jQuery('#image1').attr('src','<?=$phpThumbBase;?>?src=../galleria/'+data+'&iar=1&w=50&h=50&aoe=1');
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
                                               
                                            setTimeout(function(){window.location.href = "articoli.php";},1500); 
                                               }     
                                                                                           
                                             } ,        
                              "json"
                              );
                 
                           } 
                          );

</script>  



</body>

</html>
      