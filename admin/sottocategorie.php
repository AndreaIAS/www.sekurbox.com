<?php

    require ("config.php");
    require ("inc_header.php");

    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt']; else   $todo = 'view';
?>

    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>
<!--    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>-->
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
    .dataTables_wrapper .invia{width:48px;border:solid 0px;}
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

       

  <div class="centercontent tables">

        <div id="contentwrapper" class="contentwrapper">

                 <div class="contenttitle2">

                	<h3>Gestione Sottocategorie</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>sottocategorie.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuova</button>
               </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con0" />
                         <col class="con1" />
                    </colgroup>

                   <thead>
                        <tr>
                            <th class="head1">Categoria</th> 
                            <th class="head0" >Nome Italiano</th>
                            <th class="head1" >Nome Inglese</th>
                            <th class="head0" >Posizione</th>
                            <th class="head1" >Img</th>
                            <th class="head0" >&nbsp;</th> 
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>
                            <th class="head1">Categoria</th> 
                            <th class="head0" >Nome Italiano</th>
                            <th class="head1" >Nome Inglese</th>
                            <th class="head0" >Posizione</th>
                            <th class="head1" style="width:110px;" >Img</th>
                            <th class="head0" >&nbsp;</th>      
                        </tr>

                    </tfoot>

              <tbody>

            <?php     
            
                  
                 $db->query( "SELECT bag_scat.* 
                              FROM 
                              bag_scat " );
            
                $records = $db->resultset();
            
            
                    if ($db->rowCount()==0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ foreach ($records as $list) {    ?> 

                 <tr class="gradeX">
                         <td>
                         <?php 
                             $db->query( "SELECT * FROM bag_categorie WHERE id='".$list['id_categoria']."' ");
                             $listm=$db->single();
                             echo $listm['nome_it'];   
                            ?>
                
                        </td> 
                        <td><?=$list['nome_it'];?></td>
                        <td><?=$list['nome_en'];?></td>
                        <td>
                             <input class="invia" id="<?=$list['id'];?>" name="posizione" for="edit_posizione" type="text" value="<?=$list['posizione'];?>" />
                             <img id="edit_posizione<?=$list['id'];?>"  src="<?=BASE_URL;?>images/loaders/loader4.gif" style="display:none;float:right;margin-top:5px;" />
                        </td>
                        <td>
                          <?php  if($list['immagine']!=''){ ?>
                          <a href="../upload/scate/<?=$list['immagine'];?>" data-lightbox="<?=$list['nome_it'];?>" >     
                             <img src="../upload/scate/<?=$list['immagine'];?>" style='width:100px;'/>  
                          </a>    
                          <?php  } ?>  
                        </td>
                        
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§<?=$list['id'];?>§elimina§bag_scat">Elimina</a>
                        <form id="edit<?=$list['id'];?>" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                        <input type="hidden" name="opt" id="opt" value="edit" />
                        <input type="hidden" value="<?=$list['id'];?>" id="id" name="id" />
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
     
     ?>
  
    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_bag_scat" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="insscat" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVA SOTTOCATEGORIA</h3></div><!--contenttitle--><br />
                       
                        <p>
                           <b>Categoria</b><br />
                            <span class="field">
                            <select name="id_categoria" class="uniformselect">
                            <?php 
                             $db->query("SELECT * FROM bag_categorie order by nome_it");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                            	<option value="<?=$listm['id'];?>"><?=$listm['nome_it'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                       </p>
                       
                       <p>
		            <b>Nome Italiano</b><br />
                            <input type="text" name="nome_it" id="nome_it" class="smallinput" required />
                       </p>
                       <p>
		            <b>Nome Inglese</b><br />
                            <input type="text" name="nome_en" id="nome_en" class="smallinput" required />
                       </p>
                       <p>
		            <b>Posizione</b><br />
                            <input type="number" name="posizione" id="posizione" class="smallinput" required />
                       </p>
                     
                    <p style="width:40%">
                        <b>Immagine Sottocategoria</b><br />    
                            
                        <input  id="img_file" accept="*" name="img_file"  type="file"   >
                    
                     </p>
                    
                 
                   <div class="clearall"></div>

                       
                     <br />
                         <p style="width:40%">
                         <button id="submit" class="submit radius2" style="padding: 7px 32px;">Inserisci</button>
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

     $db->query("SELECT * FROM bag_scat WHERE id='".$_REQUEST['id']."' ");
     $list = $db->single();
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                       <form id="form_bag_scat" class="stdform" action="javascript:void(null)" method="post">
                      
                       <input name="function" id="function" value="editscat" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       <div class="contenttitle2"><h3>MODIFICA SOTTOCATEGORIA</h3></div><!--contenttitle--><br />
                        
                        <p>
                             <b>Categoria</b><br />  
                            <select name="id_categoria" class="uniformselect">
                            <?php 
                             $db->query("SELECT * FROM bag_categorie order by nome_it");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) { ?>
                            	<option value="<?=$listm['id'];?>" <?php if($list['id_categoria']==$listm['id']) echo "selected='selected'";  ?>><?=$listm['nome_it'];?></option>
                               <?php } ?>   
                            </select>
                        </p> 
                       
                       <p>
		            <b>Nome Italiano</b><br />
                            <input type="text" name="nome_it" id="nome_it" class="smallinput" required value="<?=$list['nome_it'];?>" />
                       </p>
                       <p>
		            <b>Nome Inglese</b><br />
                            <input type="text" name="nome_en" id="nome_en" class="smallinput" required value="<?=$list['nome_en'];?>" />
                       </p>
                       
                       <p>
		            <b>Posizione</b><br />
                            <input type="number" name="posizione" id="posizione" class="smallinput" required value="<?=$list['posizione'];?>" />
                       </p>
                       <p style="width:40%">
		        <b>Immagine Sottocategoria</b><br />        
                         <?php  if($list['immagine']!=''){ ?>
                        <a href="../upload/scate/<?=$list['immagine'];?>" data-lightbox="immagini" >
                            <img src="../upload/scate/<?=$list['immagine'];?>" style='width:100px;'/>  
                          </a>
                         <?php } ?>
                        <input  id="img_file" accept="*" name="img_file"  type="file"   >
                         
                       </p>
                      <div class="clearall"></div>

                     <p style="width:40%">
                         <button id="submit" class="submit radius2" style="padding: 7px 32px;">Salva</button>
                     </p>
                     <br /><br />
                     <p>
                     <div id="err_mess"></div>
                     </p>

                     </form>


        </div> 
        </div> 

  </div> 


<?php }  ?>

<script type="text/javascript" src="<?=BASE_URL;?>funzionijs/sottocategorie.js"></script>
 <script src="<?=BASE_URL;?>lightbox/js/lightbox.js" type="text/javascript"></script>  
 <link href="<?=BASE_URL;?>lightbox/css/lightbox.css" rel="stylesheet"> 

</body>

</html>
      