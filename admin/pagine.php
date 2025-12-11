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

                	<h3>Pagine</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>pagine.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuova</button>
               </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>

                   <thead>
                        <tr>
                            <th class="head1" style="width:50px;">Attiva</th>
                            <th class="head0" style="width:330px;">Nome</th>
                            <th class="head1" style="width:230px;">&nbsp;</th>
                        </tr>

                   </thead>

                    <tfoot>
                        <tr>
                            <th class="head1" style="width:50px;">Attiva</th>
                            <th class="head0" style="width:330px;">Nome</th>
                            <th class="head1" style="width:230px;">&nbsp;</th>
                        </tr>

                    </tfoot>

              <tbody>

            <?php     
            
                    $query = "SELECT bag_pagine.* 
                              FROM 
                              bag_pagine
                              ORDER BY bag_pagine.titolo_it";
            
                    $result = mysql_query($query);
            
                    if (mysql_num_rows($result)==0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ while ($list = mysql_fetch_array($result)) {    ?> 

                 <tr class="gradeX">
                        <td><center><img src="./images/<?=$list['attivo'];?>.jpg" border="0"/></center></td>
                        <td><?=$list['titolo_it'];?></td>            
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§<?=$list['id'];?>§elimina§bag_pagine">Elimina</a></td>
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


   <?php   }   //FINE VISUALIZZAZIONE  

else if($todo=='new') {  //INIZIO INSERIMENTO NUOVO PRODOTTO

     ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="inspagina" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVA PAGINA</h3></div><!--contenttitle--><br />
                       
                      
                       <p>
							<b>Titolo italiano</b><br />
                            <input type="text" name="titolo_it" id="titolo_it" class="smallinput"  />
                       </p>
                       
                        <p>
							<b>Titolo inglese</b><br />
                            <input type="text" name="titolo_eng" id="titolo_eng" class="smallinput"  />
                       </p>
                        <p>
                        	<b>Testo  italiano</b><br />
                          <textarea  name="testo_it" id="testo_it" class="tinymce"></textarea>
                        </p>
                        <p>
                        	<b>Testo  inglese</b><br />
                            <textarea  name="testo_eng" id="testo_eng" class="tinymce"></textarea>
                        </p>
                       
                          <p>
                        	<label>Attiva</label>
                            <span class="field">
                            <select name="attivo" class="uniformselect">
                            <option value="s">Si</option>
                            <option value="n">No</option>
                            </select>
                            </span>
                        </p>

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

     $query = "SELECT * FROM bag_pagine WHERE id='".$_REQUEST['id']."' ";
     $result = mysql_query($query)or die(mysql_error());
     $list=mysql_fetch_array($result);
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editpagina" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>MODIFICA PAGINA </h3></div><!--contenttitle--><br />
                       

  <p>
							<b>Titolo italiano</b><br />
                            <input type="text" name="titolo_it" id="titolo_it" class="smallinput" value="<?=$list['titolo_it'];?>"  />
                       </p>
                       
                        <p>
							<b>Titolo inglese</b><br />
                            <input type="text" name="titolo_eng" id="titolo_eng" class="smallinput" value="<?=$list['titolo_eng'];?>" />
                       </p>
                        <p>
                        	<b>Testo  italiano</b><br />
                          <textarea  name="testo_it" id="testo_it" class="tinymce" ><?=$list['testo_it'];?></textarea>
                        </p>
                        <p>
                        	<b>Testo  inglese</b><br />
                            <textarea  name="testo_eng" id="testo_eng" class="tinymce"><?=$list['testo_eng'];?></textarea>
                        </p>
                       
                          <p>
                        	<label>Attiva</label>
                            <span class="field">
                            <select name="attivo" class="uniformselect">
                            <option value="s" <?php if($list['attivo']=='s') echo "selected='selected'";  ?> >Si</option>
                            <option value="n" <?php if($list['attivo']=='n') echo "selected='selected'";  ?>>No</option>
                            </select>
                            </span>
                        </p>
                    
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

        jQuery("#submit").click(  
        
                function () { 
                         jQuery.post("<?=BASE_URL;?>functionload.php",jQuery("#form_prodotti").serialize(),
                              function(data) {  
                           
                                            //Se ci sono errori in fase di registrazione 
                                            if(data.errore!='no'){
                                                
                                            jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                                            }  
                                             else { 
                                                
                                             jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                                            // if(jQuery('#function').val()=='editprodotto'){  setTimeout(function(){window.location.href = "pagine.php?opt=edit&id=<?=$_REQUEST['id'];?>";},1000);            }
                                            setTimeout(function(){window.location.href = "pagine.php";},1500); 
                                                    
                                                   }                                         
                                             },          
                              "json"
                              );
                 
                           } 
                          );

</script>  

</body>

</html>
      