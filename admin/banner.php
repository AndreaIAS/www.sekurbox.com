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

                	<h3>Gestione Banner</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>banner.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>

                   <thead>
                        <tr>
                            <th class="head0" style="width:90px;">Attivo</th>
                            <th class="head1" style="width:50px;">Immagine</th>
                            <th class="head0" style="width:380px;">Link</th>
                            <th class="head1" style="width:230px;">&nbsp;</th>
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>
                             <th class="head0" style="width:90px;">Attivo</th>
                            <th class="head1" style="width:50px;">Immagine</th>
                            <th class="head0" style="width:380px;">Link</th>
                            <th class="head1" style="width:230px;">&nbsp;</th>         
                        </tr>

                    </tfoot>

              <tbody>

            <?php     
            
                    $query = "SELECT bag_banner.* 
                              FROM 
                              bag_banner 
                              ORDER BY bag_banner.id";
            
                    $result = mysql_query($query);
            
                    if (mysql_num_rows($result)==0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ while ($list = mysql_fetch_array($result)) {    ?> 

                 <tr class="gradeX">
                        <td><center><img src="./images/<?=$list['attivo'];?>.jpg" border="0"/></center></td> 
                        <td><img src="../images/img_banner/<?=$list['immagine'];?>" border="0" height="40" width="80"/></td>
                        <td><?=$list['link'];?></td>
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§<?=$list['id'];?>§elimina§bag_banner">Elimina</a></td>
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

                 <?php   }  ?>
     
     <!-- Script per associare tag a prodotto -->
<!--
        <script>
         
        jQuery("a.inline").fancybox({
           'onStart': function(links, index) {
                             jQuery('#data').load('<?=BASE_URL;?>loadservizi.php #data',{idprod:jQuery(links[index]).attr('id')},function(){
                             jQuery('input:checkbox, input:radio, select.uniformselect,select.uniformselect2, input:file').uniform();
                                                                                                                                           }); 
                                               }
        	                       });
         
        </script>
-->

   <?php   }   //FINE VISUALIZZAZIONE  

else if($todo=='new') {  //INIZIO INSERIMENTO NUOVO PRODOTTO     
     
     ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_bag_banner" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="insbanner" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVO BANNER</h3></div><!--contenttitle--><br />
                       <p>
                        	<label>Attivo</label>
                                 <span class="field">

                            <select name="attivo" class="uniformselect">

                            	<option value="s">Si</option>

                                <option value="n">No</option>

                            </select>

                   </span>
                        </p>
                         <p>
							<b>Link</b><br />
                            <input type="text" name="link" id="link" class="smallinput" />
                         </p> 
                   <p>
							<b>Alt</b><br />
                            <input type="text" name="alt" id="alt" class="smallinput" />
                         </p>     

                    <p>
						<b>Immagine</b><br />
                        <input type="text" class="smallinput" value="" name="immagine" id="immagine" />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img_upload" id="img_upload" />
                            </span>
                            
                    </div> 
                    <div id="box" style="float:left;width:150px;display:none;margin-top:-8px;"> 
                    <img id="image" src=""  border="0" />        
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyslide.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$nextid;?>','titolo':'immagine','action':'ins' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#immagine').val(data);
                                jQuery('#image').attr('src','<?=$phpThumbBase;?>?src=../images/img_banner/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box').fadeIn();
                                                                               } 
                        });
                    });
                    </script>  
                             
                       

                   <div class="clearall"></div>
                       
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

     $query = "SELECT * FROM bag_banner WHERE id='".$_REQUEST['id']."' ";
     $result = mysql_query($query)or die(mysql_error());
     $list=mysql_fetch_array($result);
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_bag_banner" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editbanner" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>MODIFICA BANNER</h3></div><!--contenttitle--><br />
                               <p>
                        	<label>Attivo</label>
                            <span class="field">
                            <select name="attivo" class="uniformselect">
                            	<option value="s" <?php if($list['attivo']=='s') echo "selected='selected'";  ?> >Si</option>
                                <option value="n" <?php if($list['attivo']=='n') echo "selected='selected'";  ?> >No</option>
                            </select>
                            </span>
                        </p>
                         <p>
							<b>Link</b><br />
                            <input type="text" name="link" id="link" class="smallinput" value="<?=$list['link'];?>"/>
                         </p>     
                         <p>
							<b>Alt</b><br />
                            <input type="text" name="alt" id="alt" class="smallinput" value="<?=$list['alt'];?>"/>
                         </p>
                    				<p>
						<b>Immagine </b><br />
                        <input type="text" class="smallinput" value="" name="immagine" id="immagine" value="<?=$list['immagine'];?>"  />
                    </p><br />
                    
                    <div style="float:left;width:150px;">       <span class="field">
                            <input  name="img_upload" id="img_upload" />
                            </span>
                            
                    </div> 
                    <div id="box" style=" <?php if($list['immagine']=='') { echo "display:none;"; } ?>float:left;width:150px;margin-top:-8px;"> 
                    <img id="image" src="<?=$phpThumbBase;?>?src=../images/img_banner/<?=$list['immagine'];?>&iar=1&w=50&h=50&aoe=1"  border="0" />        
                    <span style="cursor: pointer;" onclick="jQuery('#box').fadeOut('');jQuery.post('<?=BASE_URL;?>functionload.php',{function:'eliminafotobanner',image:'<?=$list['immagine'];?>',idprod:'<?=$list['id'];?>',titolo:'immagine'});" >
                    <img src="<?=BASE_URL;?>images/delete.png" border="0" title="elimina" />
                    </span>
                    </div>
                   </p>
                   <div class="clearall"></div>
                   
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#img_upload').uploadify({
                            height        : 30,
                            width         : 120,
                            'swf'      : '<?=BASE_URL;?>js/uploadify/uploadify.swf',
                            'uploader' : '<?=BASE_URL;?>js/uploadify/uploadifyslide.php',
                            'method'   : 'post',
                            'formData' : { 'num' : '<?=$_REQUEST['id'];?>','titolo':'immagine','action':'edit' } ,
                            'onUploadSuccess' : function(file, data, response) {
                               //alert('The file was saved to: ' + data);
                               jQuery('#immagine').val(data);
                                jQuery('#image').attr('src','<?=$phpThumbBase;?>?src=../images/img_banner/'+data+'&iar=1&w=50&h=50&aoe=1');
                                jQuery('#box').fadeIn();
                                                                               } 
                        });
                    });
                    </script> 
  <br />

 
 
                   <div class="clearall"></div>

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


<?php }  ?>


<script>

        jQuery("#submit").click(  
        
                function () { 
                         jQuery.post("<?=BASE_URL;?>functionload.php",jQuery("#form_bag_banner").serialize(),
                              function(data) {  
                           
                                            //Se ci sono errori in fase di registrazione 
                                            if(data.errore!='no'){
                                                
                                            jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                                            }  
                                             else { 
                                                
                                             jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                                             setTimeout(function(){window.location.href = "banner.php";},900); 
                                                    
                                                   }                                         
                                             },          
                              "json"
                              );
                 
                           } 
                          );

</script>  

</body>

</html>
      