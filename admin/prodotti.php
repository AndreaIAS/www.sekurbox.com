<?php
    require ("config.php");
    require ("inc_header.php");    
    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt']; else   $todo = 'view';	$idCategoria = -1;	$idSubCategoria = -1;	$querySottocategorie = "SELECT bag_scat.* FROM bag_scat";	$queryStandard = "SELECT bag_prodotti.* FROM bag_prodotti ORDER BY bag_prodotti.nome_it";		if(isset($_GET['idcategoria']))	{		$idCategoria = $_GET['idcategoria'];				if(isset($_GET['idsubcategoria']))		{			$idSubCategoria = $_GET['idsubcategoria'];            $queryStandard = "SELECT prod.* FROM bag_prodotti AS prod                                INNER JOIN bag_scat AS scat ON scat.id_categoria = '".$idCategoria."'                                WHERE prod.id_sottocategoria = '".$idSubCategoria."'                                GROUP BY id                                ORDER BY prod.nome_it";			/*            //$querySottocategorie = "SELECT bag_scat.* FROM bag_scat";*/            $querySottocategorie = "SELECT bag_scat.* FROM bag_scat WHERE id_categoria = '".$idCategoria."'";		}		else		{			$queryStandard = "SELECT prod.* FROM bag_prodotti AS prod INNER JOIN bag_scat AS scat ON scat.id = prod.id_sottocategoria AND scat.id_categoria = '".$_GET['idcategoria']."' ORDER BY prod.nome_it";            $querySottocategorie = "SELECT bag_scat.* FROM bag_scat WHERE id_categoria = '".$idCategoria."'";            $db ->query($querySottocategorie);            $records = $db->resultset();            if($db->rowCount() == 0){                $idSubCategoria = -1;            }            else            {                $idSubCategoria = $records[0]['id'];                header("location: https://www.sekurbox.com/admin/prodotti.php?idcategoria=".$idCategoria."&idsubcategoria=".$idSubCategoria."");            }		}	}	else if(isset($_GET['idsubcategoria']))	{		$idSubCategoria = $_GET['idsubcategoria'];        $queryStandard = "SELECT bag_prodotti.* FROM bag_prodotti WHERE id_sottocategoria = '".$_GET['idsubcategoria']."'";        $querySottocategorie = "SELECT bag_scat.* FROM bag_scat";	}	else	{		$idCategoria = -1;        $idSubCategoria = -1;        $queryStandard = "SELECT bag_prodotti.* FROM bag_prodotti ORDER BY bag_prodotti.nome_it";        $querySottocategorie = "SELECT bag_scat.* FROM bag_scat";	}	
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

                	<h3>Gestione Prodotti</h3>

                </div><!--contenttitle-->

               <a href="<?=BASE_URL;?>prodotti.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>				<span class="field">					<select id="selCategoria" class="uniformselect" style="border-radius: 8px; height: 35px;min-width: 200px;margin-left: 30px">                        <?php                            $db ->query("SELECT * FROM bag_categorie");                            $records = $db->resultset();                            if($db->rowCount() == 0){ ?>                                <option>Nessuna categoria</option>                            <?php                            }                            else                            {								echo "<option data-subtext='-1'></option>";                                foreach ($records as $list)                                {                                    if($idCategoria != -1 && $idCategoria == $list['id'])                                        echo "<option data-subtext='".$list['id']."' selected='selected'>".$list['nome_it']."</option>";                                    else echo "<option data-subtext='".$list['id']."'>".$list['nome_it']."</option>";                                }                            }?>                    </select>                </span>                <span class="field">                    <select id="selSottoCategoria" class="uniformselect" style="border-radius: 8px; height: 35px;min-width: 200px;margin-left: 30px">                        <?php                        echo $querySottocategorie."<br/>";                        $db ->query($querySottocategorie);                        $records = $db->resultset();                        if($db->rowCount() == 0){ ?>                            <option>Nessuna sotto categoria</option>                            <?php                        }                        else                        {							echo "<option data-subtext='-1'></option>";                            foreach ($records as $list)                            {                                if($idSubCategoria != -1 && $idSubCategoria == $list['id'])                                    echo "<option data-subtext='".$list['id']."' selected='selected'>".$list['nome_it']."</option>";                                else echo "<option data-subtext='".$list['id']."'>".$list['nome_it']."</option>";                            }                        }?>                    </select>                </span>                <span class="field">                    <a href="<?=BASE_URL;?>prodotti.php" style="margin-bottom: 35px; margin-left: 40px">Resetta Filtri</a>                </span>

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
                            <th class="head1" style="width:100px;">Codice</th>
                            <th class="head0" style="width:330px;">Nome</th>
                            <th class="head1" style="width:120px;">Prezzo</th>
                            <th class="head0" style="width:120px;">Sconto Inst.</th>
                            <th class="head0" style="width:120px;">Sconto Riv.</th>
                            <th class="head1" style="width:120px;">Posizione</th>
                            <th class="head0" style="width:250px;">Sottocategoria</th>
                            <th class="head1" style="width:130px;">Quantità</th>
                            <th class="head0" style="width:110px;" >Img</th>
                            <th class="head1" style="width:180px;">&nbsp;</th>
                        </tr>
                   </thead>

                    <tfoot>
                        <tr>  
                            <th class="head1" style="width:100px;">Codice</th>
                            <th class="head0" style="width:330px;">Nome</th>
                            <th class="head1" style="width:120px;">Prezzo</th>
                            <th class="head0" style="width:120px;">Sconto %</th>
                            <th class="head1" style="width:120px;">Posizione</th>
                            <th class="head0" style="width:250px;">Sottocategoria</th>
                            <th class="head1" style="width:130px;">Quantità</th>
                            <th class="head0" style="width:110px;" >Img</th>
                            <th class="head1" style="width:180px;">&nbsp;</th>
                        </tr>

                    </tfoot>
 
              <tbody>

            <?php     
            
                    $db->query($queryStandard);
            
                    $records = $db->resultset();
                
            
                 if ($db->rowCount() == 0) {
            
            ?>

              <center><p style="font-size:11px;"><b>Nessun record presente</b></p></center>

            <?php }else{ foreach ($records as $list)  {    ?> 

                 <tr class="gradeX">
                        <td><?=$list['codice'];?></td>
                        <td><?=$list['nome_it'];?></td>
                        <td>
                            <input class="invia" id="<?=$list['id'];?>" name="prezzo" for="edit_prezzo" type="text" value="<?=number_format($list['prezzo'],2,',','.');?>" />
                            <img id="edit_prezzo<?=$list['id'];?>"  src="<?=BASE_URL;?>images/loaders/loader4.gif" style="display:none;float:right;margin-top:5px;" />

                        </td>
                        <td>
                            <input class="invia" id="<?=$list['id'];?>" name="sconto" for="edit_sconto_inst" type="text" value="<?=$list['sconto_installatore'];?>" />
                            <img id="edit_sconto<?=$list['id'];?>"  src="<?=BASE_URL;?>images/loaders/loader4.gif" style="display:none;float:right;margin-top:5px;" />

                        </td> 
                         <td>
                            <input class="invia" id="<?=$list['id'];?>" name="sconto" for="edit_sconto_riv" type="text" value="<?=$list['sconto_rivenditore'];?>" />
                            <img id="edit_sconto<?=$list['id'];?>"  src="<?=BASE_URL;?>images/loaders/loader4.gif" style="display:none;float:right;margin-top:5px;" />

                        </td> 
                        <td>
                             <input class="invia" id="<?=$list['id'];?>" name="posizione" for="edit_posizione" type="text" value="<?=$list['posizione'];?>" />
                            <img id="edit_posizione<?=$list['id'];?>"  src="<?=BASE_URL;?>images/loaders/loader4.gif" style="display:none;float:right;margin-top:5px;" />

                        </td>
                        <td>
                         <?php 
                             $db->query("SELECT * FROM bag_scat WHERE id='".$list['id_sottocategoria']."' ");
                             $listm=$db->single();
                             echo $listm['nome_it'];   
                            ?>
                
                        </td> 
                         
                        <td>                            <input class="invia" id="<?=$list['id'];?>" name="quantita" for="edit_quantita" type="text" value="<?=$list['quantita'];?>" />                            <img id="edit_quantita<?=$list['id'];?>"  src="<?=BASE_URL;?>images/loaders/loader4.gif" style="display:none;float:right;margin-top:5px;" />						</td>    
                        <td>
                          <?php  if($list['immagine']!=''){ ?>
                          <a href="../upload/prodotti/<?=$list['immagine'];?>" data-lightbox="<?=$list['id'];?>" >     
                             <img src="../upload/prodotti/<?=$list['immagine'];?>" style='width:100px;'/>  
                          </a>    
                          <?php  } ?>  
                        </td>
                        <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?=$list['id'];?>').submit();">Modifica</a> &nbsp; 
                        <a href="" class="delete" for="<?=BASE_URL;?>§<?=$list['id'];?>§elimina§bag_prodotti">Elimina</a>
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

                 <?php   }    }   //FINE VISUALIZZAZIONE  

else if($todo=='new') {  //INIZIO INSERIMENTO NUOVO PRODOTTO


     ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
       	
        <div id="formbasic" class="subcontent">
          
                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                      <input name="function" id="function" value="insprodotto" type="hidden" />
                       <div class="contenttitle2"><h3>NUOVO PRODOTTO</h3></div><!--contenttitle--><br />
                       
                       <p>
		       <b>Codice </b><br />
                       <span class="field"><input type="text" name="codice" id="codice" class="smallinput"/></span>
                       </p>
                        
                        <p>
			<b>Nome Italiano</b><br />
                        <input type="text" name="nome_it" id="nome_it" class="smallinput" required />
                        </p>
                        
                        <p>
			<b>Nome Inglese</b><br />
                            <input type="text" name="nome_en" id="nome_en" class="smallinput" required />
                        </p>
                        
                         <p style="width:40%">
                        <b>Descrizione Italiano </b><br />
                          <textarea  name="descrizione_it" id="descrizione_it" class="tinymce"></textarea>
                        </p>
                        
                        <p style="width:40%">
                        <b>Descrizione Inglese </b><br />
                          <textarea  name="descrizione_en" id="descrizione_en" class="tinymce"></textarea>
                        </p>
                        
                         <p>
                        <b>Description tag Italiano </b><br />
                          <input type="text" name="description_it" id="description_it" class="smallinput"  />
                        </p>
                        
                        <p>
                        <b>Description tag Inglese </b><br />
                         <input type="text" name="description_en" id="description_en" class="smallinput"  />
                        </p>
                         
                        <p>
                        <b>Posizione</b><br />
                        <span class="field"><input type="number" name="posizione" id="posizione" class="smallinput" /></span>
                        </p>                        
                        
                        <p>
                        <b>Prezzo</b><br />
                        <span class="field"><input type="text" name="prezzo" id="prezzo" class="smallinput" /></span>
                        </p>
                        
                        <p>
                        <b>Sconto Installatore %</b><br />
                        <span class="field"><input type="number" name="sconto_installatore" id="sconto_installatore" class="smallinput" /></span>
                        </p>
                        <p>
                        <b>Sconto Rivenditore %</b><br />
                        <span class="field"><input type="number" name="sconto_rivenditore" id="sconto_rivenditore" class="smallinput" /></span>
                        </p>

                            <p>
                            <b>Categoria</b><br />
                            <span class="field">
                            <select name="id_categoria" class="uniformselect" onchange="jQuery('#ajax2').show();jQuery('#sottocategorie').load('<?=BASE_URL;?>loadcategorie.php #dati2',{idcat:jQuery(this).val()},function() {jQuery('#ajax2').hide();}); ">
                                <option value="0">Scegli categoria</option>
                            <?php 
                             $db->query("SELECT * FROM bag_categorie order by nome_it");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                                <option value="<?=$listm['id'];?>"><?=$listm['nome_it'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                            <img src="<?=BASE_URL;?>images/ajax-loader1.gif" style="display:none;" id="ajax2" />
                            </p>
                        
                        <div id="sottocategorie"></div>

                        
                        
                           <p>
                            <b>Marca</b><br />
                            <span class="field">
                            <select name="id_marca" class="uniformselect" required >
                                <option value="">Scegli marca</option>
                            <?php 
                             $db->query("SELECT * FROM bag_marche order by nome_it");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                                <option value="<?=$listm['id'];?>"><?=$listm['nome_it'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                            <img src="<?=BASE_URL;?>images/ajax-loader1.gif" style="display:none;" id="ajax2" />
                            </p>
                        
                         <p>
			<b>Quantità</b><br />
                            <input type="number" name="quantita" id="quantita" class="smallinput" required />
                        </p>
                        
                        <p>
			
                        Offerta   &nbsp; <input type="checkbox" name="offerta" id="offerta" class="smallinput" />&nbsp;&nbsp;&nbsp;
                        Ultimo Arrivo   &nbsp; <input type="checkbox" name="ultimo_arrivo" id="ultimo_arrivo" class="smallinput" />&nbsp;&nbsp;&nbsp;
                        Più Venduto   &nbsp;<input type="checkbox" name="piu_venduto" id="piu_venduto" class="smallinput"  />&nbsp;&nbsp;&nbsp;
                        </p>

        	       

                 <p style="width:40%">
                        <b>Scheda Tecnica</b><br />     
                        <input  id="scheda_t" accept="*" name="scheda_t"  type="file"   >
                    </p>   
                    
           
                         
                    <p style="width:40%">
                        <b>Immagine principale</b><br />     
                        <input  id="img_file" accept="*" name="img_file"  type="file"   >
                    </p>   
                    
                     <p style="width:40%">
                        <b>Altre immmagini </b><br />     
                        <input  id="img_file_m" accept="*" name="img_file_m"  type="file"  multiple >
                    </p>  

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

     $db->query("SELECT * FROM bag_prodotti WHERE id='".$_REQUEST['id']."' ");
     $list=$db->single();
        
     ?>

    <div class="centercontent">   


        <div id="contentwrapper" class="contentwrapper">           	
        <div id="formbasic" class="subcontent">
          

                     <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                         
                      <input name="function" id="function" value="editprodotto" type="hidden" />
                       <input name="id" value="<?=$_REQUEST['id'];?>" type="hidden" />
                       
                       <div class="contenttitle2" >
                           <h3>PRODOTTO</h3>  
                       </div><!--contenttitle--><br />
                       <div style="width:500px;">
                        <button id="submit" class="submit radius2" style="float:right;">Salva</button>
                       </div>
                        <p>
			<b>Codice </b><br />
                       <span class="field"><input type="text" name="codice" id="codice" class="smallinput" value="<?=$list['codice'];?>"/></span>
                       </p>
                       
			<p>
			<b>Nome Italiano</b><br />
                        <input type="text" name="nome_it" id="nome_it" class="smallinput" value="<?=$list['nome_it'];?>" required />
                        </p>
                        
                        <p>
			<b>Nome Inglese</b><br />
                            <input type="text" name="nome_en" id="nome_en" class="smallinput"  value="<?=$list['nome_en'];?>" required />
                        </p>
                        
                        <p style="width:40%">
                        <b>Descrizione Italiano </b><br />
                        <textarea  name="descrizione_it" id="descrizione_it" class="tinymce" ><?=$list['descrizione_it'];?></textarea>
                        </p>
                        
                        <p style="width:40%">
                        <b>Descrizione Inglese </b><br />
                          <textarea  name="descrizione_en" id="descrizione_en" class="tinymce" ><?=$list['descrizione_en'];?></textarea>
                        </p>
                        
                   
                         <p>
                        <b>Description tag Italiano </b><br />
                        <input type="text" name="description_it" id="description_it" class="smallinput"  value="<?=$list['description_it'];?>" />
                        </p>
                        
                        <p>
                        <b>Description tag Inglese </b><br />
                         <input type="text" name="description_en" id="description_en" class="smallinput" value="<?=$list['description_en'];?>" />
                        </p>
                        
                        <p>
                        <b>Posizione</b><br />
                        <span class="field"><input type="numeber" name="posizione" id="posizione" class="smallinput" value="<?=$list['posizione'];?>" /></span>
                        </p> 
                        
                        <p>
                          <b>Prezzo</b><br />
                          <span class="field"><input type="text" name="prezzo" id="prezzo" class="smallinput" value="<?=$list['prezzo'];?>" /></span>
                        </p>
                        
                        <p>
                          <b>Sconto installatore %</b><br />
                          <span class="field"><input type="number" name="sconto_installatore" id="sconto_installatore" class="smallinput" value="<?=$list['sconto_installatore'];?>"/></span>
                        </p>
                        
                        <p>
                          <b>Sconto rivenditore %</b><br />
                          <span class="field"><input type="number" name="sconto_rivenditore" id="sconto_rivenditore" class="smallinput" value="<?=$list['sconto_rivenditore'];?>"/></span>
                        </p>
                                 
                         <p>
			  <b>Quantità</b><br />
                          <input type="number" name="quantita" id="quantita" class="smallinput" value="<?=$list['quantita'];?>" required />
                         </p>

                         <p>
                           <?php 
                           $db->query("SELECT * FROM bag_scat WHERE id='".$list['id_sottocategoria']."' ");
                           $resultm=$db->single();
                           $db->query("SELECT * FROM bag_categorie WHERE id='".$resultm['id_categoria']."' ");
                           $resultcat=$db->single();
                           ?>
                            <b>Categoria - Sottocategoria</b><br />
                            <span class="field">
                             <input type="text" name="nulla"  class="smallinput" value=" <?=$resultcat['nome_it'];?> - <?=$resultm['nome_it'];?>" disabled="disabled" />    
                            </span>
                          </p>
                           
                              <p> 
                             <br />
                             <b style="font-size:17px;"> Modifica categorie </b> <br />  <br />  
                            <b>Categoria</b><br />
                            <span class="field">
                            <select name="id_categoria" class="uniformselect" onchange="jQuery('#ajax2').show();jQuery('#sottocategorie').load('<?=BASE_URL;?>loadcategorie.php #dati2',{idcat:jQuery(this).val()},function() {jQuery('#ajax2').hide();}); ">
                                <option value="0">Scegli categoria</option>
                            <?php 
                             $db->query("SELECT * FROM bag_categorie order by nome_it");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                                <option value="<?=$listm['id'];?>"><?=$listm['nome_it'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                            <img src="<?=BASE_URL;?>images/ajax-loader1.gif" style="display:none;" id="ajax2" />
                            </p>
                      
                        <div id="sottocategorie"></div>
                        
                         <div style="clear:both"></div>
                        <hr style="border:1px solid #dedede; width:50%;float: left;">
                         <div style="clear:both"></div><br />
                        
                           <p>
                            <b>Marca</b><br />
                            <span class="field">
                            <select name="id_marca" class="uniformselect" required >
                                <option value="">Scegli marca</option>
                            <?php 
                             $db->query("SELECT * FROM bag_marche order by nome_it");
                             $resultm=$db->resultset();
                             foreach ($resultm as $listm) {?>
                                <option value="<?=$listm['id'];?>" <?php if($listm['id']==$list['id_marca']) echo "selected='selected'"; ?>><?=$listm['nome_it'];?></option>
                               <?php } ?>                        
                            </select>
                            </span>
                            <img src="<?=BASE_URL;?>images/ajax-loader1.gif" style="display:none;" id="ajax2" />
                            </p>
                            
                              <p>
			
                        Offerta   &nbsp; <input type="checkbox" name="offerta" id="offerta" class="smallinput" <?php if($list['offerta']=='s') echo "checked"; ?>/>&nbsp;&nbsp;&nbsp;
                        Ultimo Arrivo   &nbsp; <input type="checkbox" name="ultimo_arrivo" id="ultimo_arrivo" class="smallinput" <?php if($list['ultimo_arrivo']=='s') echo "checked"; ?>/>&nbsp;&nbsp;&nbsp;
                        Più Venduto   &nbsp;<input type="checkbox" name="piu_venduto" id="piu_venduto" class="smallinput" <?php if($list['piu_venduto']=='s') echo "checked"; ?>  />&nbsp;&nbsp;&nbsp;
                        </p>
                            
                                 <br /> <hr class="smallinput"> <br />  

                     <p style="width:40%">
		        <b>Scheda tecnica</b><br />        
                         <?php  if($list['scheda_tecnica']!=''){ ?>
                         <a href="../upload/schede/<?=$list['scheda_tecnica'];?>" target="_blank" >
                            <img src="./images/filetype/pdf_32.png" style='width:32px;'/>  
                          </a>
                         <?php } ?>
                        <input  id="scheda_t" accept="*" name="scheda_t"  type="file"   >
                         
                       </p>
                       
                       
                       <p style="width:40%">
		        <b>Immagine Principale</b><br />        
                         <?php  if($list['immagine']!=''){ ?>
                        <a href="../upload/prodotti/<?=$list['immagine'];?>" data-lightbox="immagine<?=$list['id'];?>" >
                            <img src="../upload/prodotti/<?=$list['immagine'];?>" style='width:100px;'/>  
                          </a>
                         <?php } ?>
                        <input  id="img_file" accept="*" name="img_file"  type="file"   >
                         
                       </p>


                            <p>
                            <b>Immagini già caricate</b><br /><br />      


                            <?php
                            $db->query("SELECT *
                                        FROM 
                                        bag_image
                                        WHERE id_prodotto='".$list['id']."'  
                                        AND immagine!='".$list['immagine']."'    
                                      ");
                            $recordfile = $db->resultset();
                            if ($db->rowCount() > 0) {

                                foreach ($recordfile AS $file) {
                                    ?>

                                    <div class='col-xxs col-xs-2 col-md-2 h82' id="div_file<?=$file['id'];?>">

                                        <div style="width:100%;padding:5px;border: 1px solid grey; border-radius: 10px;float:left;">
                                            <div style="width:77%;float:left;text-align:left;">
                                                <a href="../upload/prodotti/<?= $file['immagine']; ?>" data-lightbox="immagini-altre" >
                                                    <img src="../upload/prodotti/<?= $file['immagine']; ?>" style='width:100px;'/>  
                                                </a> 
                                            </div>
                                            <div style="width:20%;float:left;color:#000000;text-align:left;margin-left:2%;" id="div_elimina_file<?=$file['id'];?>">
                                                <a href="javascript:void(null);" class="eliminafile"     data-id_file="<?= $file['id']; ?>" >
                                                    <img src="images/del2.png" style="width:70%;margin-top:35%;" title="Elimina questo file" /> 
                                                </a>
                                            </div>
                                        </div>    
                                    </div>    

                                    <?php
                                }
                            }
                            ?>

                         <p>

                        <div style="clear:both"></div><br />
                        <p>
                            <b>Carica nuove immagini</b><br />    
                            <input  id="img_file_m" accept="*" name="img_file_m"  type="file" multiple="multiple"  >
                        </p>

                        <div style="clear:both"></div>
                        <br /><br />

                    
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
  
<script type="text/javascript" src="<?=BASE_URL;?>funzionijs/prodotti.js"></script>
 <script src="<?=BASE_URL;?>lightbox/js/lightbox.js" type="text/javascript"></script>  
 <link href="<?=BASE_URL;?>lightbox/css/lightbox.css" rel="stylesheet"> 
</body>
<script type="text/javascript">    jQuery(document).ready(function ()    {        jQuery("#selCategoria").on('change', function() {            var nome_Categoria = this.value;            var id_Categoria = jQuery('#selCategoria option:selected').attr('data-subtext');            var url = "https://www.sekurbox.com/admin/prodotti.php";            if(id_Categoria != null) {                url = url + "?idcategoria=" + id_Categoria + "";                setTimeout(window.location.href = url, 200);            }            else setTimeout(window.location.href = url,200);        });        jQuery("#selSottoCategoria").on('change', function() {            var id_SubCategoria = jQuery('#selSottoCategoria option:selected').attr('data-subtext');            var url = "https://www.sekurbox.com/admin/prodotti.php";            <?php if($idCategoria != -1) {?>                url = url + "?idcategoria=<?= $idCategoria?>&idsubcategoria="+id_SubCategoria+"";            setTimeout(window.location.href = url,200);            <?php }else{?>                url = url + "?idsubcategoria="+id_SubCategoria+"";                setTimeout(window.location.href = url,200);            <?php }?>        });    });</script>
</html>
      