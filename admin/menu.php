<?php

require ("config.php");
require ("inc_header.php");


if (isset($_REQUEST['opt'])) {$todo = $_REQUEST['opt']; }
else   $todo = 'view';


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
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tooltip.jquery.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?=BASE_URL;?>js/custom/editor.js"></script>
<link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>js/uploadify/uploadify.css" />

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=BASE_URL;?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	



<style>
.stdform label{width: 100px; text-align:right;padding:0px 10px 0px 0px;}
.stdform span.field, .stdform div.field { margin-left: 20px;}
</style>


</head>

<body>



<?php  



require("inc_menu.php"); 

require("inc_leftside.php"); 



if ($todo=='view') {  ?>

   <!-- DIV per associare il prodotto ai tag -->
 
 <div style="display:none">
 <div id="data" style="width:550px;height:350px;">
 </div>
 </div> 
 
<!-- -->       

  <div class="centercontent tables">

        <div id="contentwrapper" class="contentwrapper">


                 <div class="contenttitle2">

                	<h3>Gestione Menu</h3>

                </div><!--contenttitle-->

          
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" onclick="window.location.href='<?=BASE_URL;?>menu.php?opt=new'">Aggiungi</button>
          

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablequick" id="dyntable">

                    <colgroup>

                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
       </colgroup>

                   <thead>

                        <tr>
                            <th class="head0" style="width:130px;">Macro</th>
                            <th class="head1" style="width:130px;">Ordine</th>
                            <th class="head0" style="width:130px;">Nome</th>
                            <th class="head1" style="width:130px;">Associa tag</th>
                            <th class="head0">&nbsp;</th>
                            <th class="head1">&nbsp;</th>
                        </tr>

                    </thead>

                    <tfoot>

                        <tr>
                            <th class="head0" style="width:130px;">Macro</th>
                            <th class="head1" style="width:130px;">Ordine</th>
                            <th class="head0" style="width:130px;">Nome</th>
                            <th class="head1" style="width:130px;">Associa tag</th>
                            <th class="head0">&nbsp;</th>
                            <th class="head1">&nbsp;</th>
                        </tr>

                    </tfoot>

              <tbody>

<?php        



        $query = "SELECT menu.* 
                  FROM 
                  menu 
                  ORDER BY id_macro,ordine";

        $result = mysql_query($query);

        if (mysql_num_rows($result)==0) {

        ?>
        <?php

        }else{ while ($list = mysql_fetch_array($result)) {

        ?> 
    

                        <tr class="gradeX">
                          <?php
                              $querym= " SELECT tag.*
                                            FROM 
                                            tag
                                            WHERE id='".$list['id_macro']."' 
                                            ORDER BY singolare
                                         ";
                            $resultm = mysql_query($querym);
                            $listm=mysql_fetch_array($resultm);
                        ?>
                        <td><?=$listm['singolare'];?></td>
                        <td><?=$list['ordine'];?></td>
                        <td><?=$list['nome'];?></td>
                      
                        <td> 
                            <a class="inline" id="<?=$list['id'];?>" href="#data">Associa tag</a>
                            </td> 
                        <td class="center"><a href="<?=BASE_URL;?>editmenu.php?idmenu=<?=$list['id'];?>" class="toggle">Quick View</a></td>
                             
                             <td class="center">                                            
                             &nbsp; <a href="" class="delete" for="<?=BASE_URL;?>§<?=$list['id'];?>§eliminamenu" >Elimina</a></td>
                         </tr>
     <!-- Script per associare tag a prodotto -->
        <script>
         
        jQuery("a.inline").fancybox({
           'onStart': function(links, index) {
                             jQuery('#data').load('<?=BASE_URL;?>loadpmenudett.php #data',{idmenu:jQuery(links[index]).attr('id')},function(){
                             jQuery('input:checkbox, input:radio, select.uniformselect,select.uniformselect2, input:file').uniform();                                                                                                                                        }); 
                                               }
        	                       });
        </script>   


<?php }  ?>



     </tbody>
                </table>

   </div> 

      </div>             

          <br /><br />

     <?php    } }

else if($todo=='new') { 

     ?>



    <div class="centercontent">

        <div class="pageheader">
           <h1 class="pagetitle">Inserisci men&ugrave;</h1>
        </div>

        <div id="contentwrapper" class="contentwrapper">
                	
        <div id="formbasic" class="subcontent">
          

                <form id="form_tag" class="stdform" action="javascript:void(null)" method="post" >
                      
                      <input name="function" value="insmenu" type="hidden" />
                        
                        <p>
                        	<label>Nome</label>
                            <span class="field"><input type="text" name="nome" id="nome" class="smallinput" /></span>

                        </p>

                        <p>
                        	<label>Macro</label>
                            <span class="field">
                            <select name="macro" class="uniformselect">
                            <?php 
                            $querytag = " SELECT tag.*
                                          FROM 
                                          tag
                                          WHERE macro='s'
                                          ORDER BY singolare
                                         ";
                            
                            $resulttag = mysql_query($querytag);
                            while ($listtag = mysql_fetch_array($resulttag)) { ?>
                            <option value="<?=$listtag['id'];?>"><?=$listtag['singolare'];?></option>
                            
                            <?php } ?>
                              </select>
                            </span>
                        </p>
                    
                     <p>
                        	<label>Ordine</label>
                            <span class="field">
                            <select name="ordine" class="uniformselect">
                            <?php
                            for($x=1;$x<=10;$x++){ echo '<option value="'.$x.'">'.$x.'</option>'; }
                            ?>
                            
                            </select>
                            </span>
                        </p>
                   <p>
                   <label>Preventivo</label>
                   <span class="field">

                            <select name="prev" class="uniformselect">

                            	<option value="s">Si</option>

                                <option value="n">No</option>

                            </select>

                   </span>
                   </p>
                   
                        <p class="stdformbutton" style="margin-left:470px;">
                        	<button id="submit" class="submit radius2" >Submit Button</button>
                        </p>
                        <p>
                        <div id="err_mess"></div>
                        </p>
                     </form>
                     </div> 

           

        </div> 

      

    </div>



<?php }?>


<script>

jQuery("#submit").click(  

function () {
   
  
 jQuery.post("<?=BASE_URL;?>execute.php",jQuery("#form_tag").serialize(),
      function(data) {  
   
                    //Se ci sono errori in fase di registrazione 
                    if(data.errore!='no'){
                        
                    jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                    }  
                     else { 
                        
                     jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                     setTimeout(function(){window.location.href = "menu.php";},1500); 
                            
                           }
                                      
                     }, 
      
      "json"
      );
 
           } 
                  );
 


</script>      