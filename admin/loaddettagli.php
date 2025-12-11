<?php
    require ("config.php");
    require ("inc_header.php");    
?>
    

<div id="data">
<script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/general.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/custom/tables.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>js/plugins/jquery.uniform.min.js"></script>
    
     <style>
    .stdform label{width: 100px; text-align:right;padding:0px 0px 0px 0px;}
    .stdform span.field, .stdform div.field { margin-left: 0px;}
    </style>


    <div class="centercontent tables" style="margin-left:10px;">

        <div id="contentwrapper" class="contentwrapper">

                 <div class="contenttitle2">

                	<h3>Dettaglio Ordine</h3>

                </div><!--contenttitle-->

<!--               <a href="<?=BASE_URL;?>ordini.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>-->
                <?php
                    $db->query(" SELECT bag_ordini.* 
                                 FROM 
                                 bag_ordini
                                 WHERE id= '".$_POST['idordine']."' ");
                    $records = $db->single();  
                ?>
                <div style="clear:both"></div>

                <div style="float:left;width:32%;margin-right:15px;">
                    
                <h5>Dati Ordine</h5>
                -<b>Numero:</b> SK<?=$records['id'];?> <br />
                -<b>Data:</b>   <?=date('d/m/Y',strtotime($records['data']));?> <br />
                -<b>Tipo pagamento:</b> <?=$records['tipo_pagam'];?> <br />
                -<b>Tipo spedizione:</b> <?=$records['tipo_spedi'];?> <br />
                -<b>Note:</b> <?=$records['note'];?> <br /><br /><br />
                    
                    
                </div>
                 <div style="float:left;width:32%;margin-right:15px;">
                 <?php
                    $db->query(" SELECT bag_utenti.* ,comuni.nome AS nomecomune
                                 FROM 
                                 bag_utenti
                                 LEFT JOIN comuni ON comuni.id=bag_utenti.id_comune
                                 WHERE bag_utenti.id= '".$records['id_utente']."' ");
                    $daticli = $db->single();  
                ?>   
                <h5>Dettaglio Cliente</h5>
                -<b>Nome cliente:</b> <?=$daticli['nome']." ".$daticli['cognome'];?> <br />
                -<b>Ragione Sociale:</b>   <?=$daticli['ragione'];?> <br />
                -<b>P.iva:</b> <?=$daticli['p_iva'];?> <br />
                -<b>Codice Fiscale:</b> <?=$daticli['cod_fiscale'];?> <br />
                -<b>Indirizzo:</b> <?=$daticli['indirizzo'];?> <br />
                -<b>Città:</b> <?=$daticli['nomecomune'];?> <br />
                -<b>Cap:</b> <?=$daticli['cap'];?> <br />
                -<b>Telefono:</b> <?=$daticli['telefono'];?> <br />
                -<b>Email:</b> <?=$daticli['email'];?> <br /><br /><br />
                    
                    
                </div>
                 <div style="float:left;width:32%;">
                    
                <h5>Indirizzo di Spedizione</h5>
                <?php if($records['indirizzo']==''){ ?>
                -<b>Nome cliente:</b> <?=$daticli['nome']." ".$daticli['cognome'];?> <br />
                -<b>Indirizzo:</b> <?=$daticli['indirizzo'];?> <br />
                -<b>Città:</b> <?=$daticli['citta'];?> <br />
                -<b>Provincia:</b> <?=$daticli['provincia'];?> <br />
                -<b>Cap:</b> <?=$daticli['cap'];?> <br />
                <?php }  else { ?>  
                -<b>Nome cliente:</b> <?=$daticli['nome']." ".$daticli['cognome'];?> <br />
                -<b>Indirizzo:</b> <?=$records['indirizzo'];?> <br />
                -<b>Città:</b> <?=$records['citta'];?> <br />
                -<b>Provincia:</b> <?=$records['provincia'];?> <br />
                -<b>Cap:</b> <?=$records['cap'];?> <br />
                
                <?php }  ?>  
                    
                </div>
       <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

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
                             <th class="head1" style="width:330px;">Nome</th>
                            <th class="head0" style="width:150px;">Codice</th>
                            <th class="head1" style="width:150px;">Codice mepa</th>
                            <th class="head0" style="width:100px;"> Prezzo</th>
                            <th class="head1" >Quantità</th>
                            <th class="head0" style="width:100px;text-align:center;">Totale</th>
                           
                        </tr>
                   </thead>


              <tbody>

            <?php     
            
                    $db->query( "SELECT * 
                                 FROM 
                                 bag_det_ord
                                 WHERE id_ordine='".$_POST['idordine']."'  ");
            
                    $dettord = $db->resultset();
                
                    $totalearticoli=0;
                    
                              foreach ($dettord as $value)  {   $totalearticoli=$totalearticoli+($value['qta']*$value['prezzo']);    

                                  $db->query( "SELECT bag_prodotti.* 
                                               FROM 
                                               bag_prodotti
                                               WHERE id='".$value['id_articolo']."' ");

                                  $list = $db->single();

                                  ?> 

                                 <tr class="gradeX">
                                        <td><?=$list['nome_it'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td><?=$value['prezzo'];?></td> 
                                        <td><?=$value['qta'];?></td>
                                        <td style="text-align:center;"><?=number_format($value['qta']*$value['prezzo'],2,',','.');?></td>
                                 </tr>

                          <?php }  
                          
                          $iva=($totalearticoli/100)*22;
                          ?>
                                 <tr>
                                 <td> </td>
                                 <td> </td> 
                                 <td> </td> 
                                 <td style="border-right:0px solid;text-align:right;font-weight:bolder;"> TOTALE  </td> 
                                 <td style="border-left:0px solid;font-weight:bolder;"> ARTICOLI</td> 
                                 <td style="text-align:center;font-weight:bolder;"><?=number_format($totalearticoli,2,',','.');?> &euro; </td>       
                                 </tr>
                                  <tr>
                                 <td> </td>
                                 <td> </td> 
                                 <td> </td> 
                                 <td style="border-right:0px solid;text-align:right;font-weight:bolder;"> TOTALE </td> 
                                 <td  style="font-weight:bolder;"> IVA</td> 
                                 <td style="text-align:center;font-weight:bolder;"><?=number_format($iva,2,',','.');?> &euro; </td>       
                                 </tr>
                                 <tr>
                                 <td> </td>
                                 <td> </td> 
                                 <td> </td> 
                                 <td style="border-right:0px solid;text-align:right;font-weight:bolder;"> TOTALE </td> 
                                 <td  style="font-weight:bolder;"> SPEDIZIONE</td> 
                                 <td style="text-align:center;font-weight:bolder;"><?=number_format($records['spese_spe'],2,',','.');?> &euro; </td>       
                                 </tr>
                                 <tr>
                                 <td> </td>
                                 <td> </td> 
                                 <td> </td> 
                                 <td style="border-right:0px solid;text-align:right;font-weight:bolder;"> TOTALE </td> 
                                 <td  style="font-weight:bolder;"> PAGAMENTO</td> 
                                 <td style="text-align:center;font-weight:bolder;"><?=number_format($records['spese_pag'],2,',','.');?> &euro; </td>       
                                 </tr>
                                 <tr>
                                 <td> </td>
                                 <td> </td> 
                                 <td> </td> 
                                 <td style="border-right:0px solid;text-align:right;font-weight:bolder;"> TOTALE </td> 
                                 <td style="font-weight:bolder;">  ORDINE</td> 
                                 <td style="text-align:center;font-weight:bolder;"><?=number_format($totalearticoli+$iva+$records['spese_pag']+$records['spese_spe'],2,',','.');?> &euro; </td>       
                                 </tr>

            </tbody>

           </table>

     </div> 

  </div>  
     
</div>