<?php

    require ("config.php");
    require ("inc_header.php");
    
    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt']; else   $todo = 'view';

    if($todo=="slider") {
?>
     <script type="text/javascript" src="<?=BASE_URL;?>js/uploadify/swfobject.js"></script>
     <script type="text/javascript" src="<?=BASE_URL;?>js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
     <link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>js/uploadify/uploadifyslider.css" />
     <?php } ?> 

    
    <?php if($todo!="slider") { ?> 

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
     
     <?php } ?>

    <?php if($todo=="crop" OR $todo=="cropslider"){ ?>     
        <link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>js/cropimages/css/imgareaselect-default.css" />
        <script type="text/javascript" src="<?=BASE_URL;?>js/cropimages/scripts/jquery.imgareaselect.pack.js"></script>
    <?php } ?> 

    <?php if($todo!="slider") { ?> 
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    
   
    <script>
    jQuery(document).ready(function(){ jQuery('input:checkbox, input:radio, select.uniformselect, input:file').uniform();});
    </script>
    
    <?php } ?>
    
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

                	<h3>Gestione Categorie</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>categorie_articoli.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuova</button>
               </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                   <thead>
                        <tr>
                            <th class="head0" style="width:150px;">Nome</th>
                            <th class="head1" style="width:230px;">&nbsp;</th>
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>
                            <th class="head0" style="width:150px;">Nome Ita</th>
                            <th class="head1" style="width:230px;">&nbsp;</th>          
                        </tr>

                    </tfoot>

              <tbody>

            <?php                 
                  $db->query("SELECT categorie_articoli.* 
                              FROM 
                              categorie_articoli 
                              ORDER BY categorie_articoli.categoria_articolo_it");          
                    $records = $db->resultset();
            
                    if ($db->rowCount()==0) {           
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ foreach ($records as $list) {    ?> 

                 <tr class="gradeX">
                        <td><?=$list['categoria_articolo_it'];?></td>
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id_categoria_articolo'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§id_categoria_articolo§<?=$list['id_categoria_articolo'];?>§elimina§categorie_articoli">Elimina</a>
                        <form id="edit<?=$list['id_categoria_articolo'];?>" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                        <input type="hidden" name="opt" id="opt" value="edit" />
                        <input type="hidden" value="<?=$list['id_categoria_articolo'];?>" id="id" name="id" />
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
          
                     <form id="form_bag_categorie" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="inscateart" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVA CATEGORIA</h3></div><!--contenttitle--><br />

                    
                       <p>
		      <b>Nome</b><br />
                            <input type="text" name="categoria_it" id="categoria_it" class="smallinput" required />
                       </p>
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

     $db->query("SELECT * FROM categorie_articoli WHERE id_categoria_articolo='".$_REQUEST['id']."' ");
     $list =$db->single();
     
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_bag_categorie" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="editcateart" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>MODIFICA CATEGORIA</h3></div><!--contenttitle--><br />
                        <p>
		      <b>Nome</b><br />
                            <input type="text" name="categoria_it" id="categoria_it" class="smallinput"  value="<?=$list['categoria_articolo_it'];?>" required/>
                       </p>
                  
			
 
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
                         jQuery.post("<?=BASE_URL;?>functionload.php",jQuery("#form_bag_categorie").serialize(),
                              function(data) {  
                           
                                            //Se ci sono errori in fase di registrazione 
                                            if(data.errore!='no'){
                                                
                                            jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                                            }  
                                             else { 
                                                
                                             jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                                           setTimeout(function(){window.location.href = "categorie_articoli.php";},900); 
                                                    
                                                   }                                         
                                             },          
                              "json"
                              );
                 
                           } 
                          );

</script>  

</body>

</html>
      