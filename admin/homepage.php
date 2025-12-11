<?php

    require ("config.php");
    require ("inc_header.php");

?>

    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/charCount.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/ui.spinner.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tinymce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/editor.js"></script>    
 
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

     $query = "SELECT * FROM homepage";
     $result = mysql_query($query)or die(mysql_error());
     $list=mysql_fetch_array($result);
    
     
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_homepage" class="stdform" action="javascript:void(null)" method="post">
                      
                      <input name="function" id="function" value="edithomepage" type="hidden" />
                       <div class="contenttitle2"><h3>HOME PAGE</h3></div><!--contenttitle--><br />
                       
                       <p>
                        	<b>Title</b><br />
                            <span class="field"><input type="text" name="title" id="pag_title" class="smallinput" value="<?=$list['title'];?>"/></span>
                        </p>
                        <p>
                        	<b>Description</b><br />
                            <span class="field"><input type="text" name="description" id="description" class="smallinput" value="<?=$list['description'];?>"/></span>
                        </p>
                        <p>
                        	<b>Keywords</b><br />
                            <span class="field"><input type="text" name="keywords" id="keywords" class="smallinput" value="<?=$list['keywords'];?>"/></span>
                        </p>
                        <p>
                        	<b>Canonical</b><br />
                            <span class="field"><input type="text" name="canonical" id="canonical" class="smallinput" value="<?=$list['canonical'];?>"/></span>
                        </p>    
                       
                       <p>
							<b>Titolo Claim Principale</b><br />
                        <textarea id="titolo" name="titolo" rows="15" cols="20" style="width:100px;" class="tinymce">
                            <?=$list['titolo'];?>
                        </textarea>
                       </p>
                       <p>
                        	<b>Servizi Acquisti</b><br />
                            <span class="field"><input type="text" name="tit_ser" id="tit_ser" class="smallinput" value="<?=$list['tit_ser'];?>" /></span>
                       </p>
                       
                       
                          <p>
                        	<b>Servizi Cliente</b><br />
                            <span class="field"><input type="text" name="tit_disp" id="tit_disp" class="smallinput" value="<?=$list['tit_disp'];?>" /></span>
                       </p>
                       
										<div class="contenttitle2"><h3>MINI CLAIM 1</h3></div><!--contenttitle--><br />
                       <p>
                        	<b>Titolo</b><br />
                            <span class="field"><input type="text" name="tit_em" id="tit_em" class="smallinput" value="<?=$list['tit_em'];?>" /></span>
                       </p>                        <p>
                        	<b>Sottotitolo</b><br />
                            <span class="field"><input type="text" name="sottotit_em" id="sottotit_em" class="smallinput" value="<?=$list['sottotit_em'];?>" /></span>
                       </p>
  					   <div class="contenttitle2"><h3>MINI CLAIM 2</h3></div><!--contenttitle--><br />                        <p>                        	<b>Titolo comprensione</b><br />                            <span class="field"><input type="text" name="tit_com" id="tit_com" class="smallinput" value="<?=$list['tit_com'];?>" /></span>                       </p>                        <p>                        	<b>Sottotitolo comprensione</b><br />                            <span class="field"><input type="text" name="sottotit_com" id="sottotit_com" class="smallinput" value="<?=$list['sottotit_com'];?>" /></span>                       </p>					   <div class="contenttitle2"><h3>MINI CLAIM 3</h3></div><!--contenttitle--><br />					   <p>						   	<b>Titolo</b><br />
                            <span class="field"><input type="text" name="tit_sce" id="tit_sce" class="smallinput" value="<?=$list['tit_sce'];?>" /></span>
                       </p>                        <p>                        	<b>Sottotitolo</b><br />                            <span class="field"><input type="text" name="sottotit_sce" id="sottotit_sce" class="smallinput" value="<?=$list['sottotit_sce'];?>" /></span>                       </p>

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


<script>

        jQuery("#submit").click(  
        
                function () { 
                         jQuery.post("<?=BASE_URL;?>execute.php",jQuery("#form_homepage").serialize(),
                              function(data) {  
                           
                                            //Se ci sono errori in fase di registrazione 
                                            if(data.errore!='no'){
                                                
                                            jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                                            }  
                                             else { 
                                                
                                             jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                                             if(jQuery('#function').val()=='editprodotto'){  setTimeout(function(){window.location.href = "prodotti.php?opt=edit&id=<?=$_REQUEST['id'];?>";},1000);            }
                                             else setTimeout(function(){window.location.href = "homepage.php";},1500); 
                                                    
                                                   }                                         
                                             },          
                              "json"
                              );
                 
                           } 
                          );

</script>  

</body>

</html>