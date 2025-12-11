<?php

require("config.php");
if (!isset($_SESSION['admin_account']['login'])) {
    header("Location: login.php");
}
require("inc_header.php");

?>


<div id="data">
    <div id="post<?= $_POST['idutente']; ?>">
        <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?= BASE_URL; ?>js/custom/general.js"></script>
        <script type="text/javascript" src="<?= BASE_URL; ?>js/custom/tables.js"></script>
        <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.uniform.min.js"></script>

        <style>
            .stdform label {
                width: 100px;
                text-align: right;
                padding: 0px 0px 0px 0px;
            }

            .stdform span.field,
            .stdform div.field {
                margin-left: 0px;
            }
        </style>



        <div style="display:none">
            <div id="data2" style="width:1000px;"></div>
        </div>

        <div class="centercontent tables" style="margin-left:10px;">

            <div id="contentwrapper" class="contentwrapper" style="padding:0px 20px 20px 20px">
                <?php
                $db->query(" SELECT bag_utenti.* 
                                 FROM 
                                 bag_utenti
                                 WHERE id= '" . $_POST['idutente'] . "' ");
                $records = $db->single();

                $db->query("SELECT
                                r.id AS id_regione, r.nome AS nome_regione,
                                p.id AS id_provincia, p.nome AS nome_provincia,
                                c.id AS id_comune, c.nome AS nome_comune
                            FROM regioni r
                            INNER JOIN province p ON p.id_regione = r.id
                            INNER JOIN comuni c ON c.id_provincia = p.id
                            WHERE c.id=" . $records['id_comune'] . " ");
                $listIndirizzo = $db->single();
                ?>
                <div class="contenttitle2" style="margin-top:0px;">

                    <h3>Dettaglio Utente: &nbsp; <b style="color:blue;"><?= $records['nome'] . " " . $records['cognome']; ?> </b></h3>



                </div><!--contenttitle-->

                <!--            <div style="float:right;">
                
                
                <a href="javascript:void(null)" title="Nascondi dettagli" onclick=" jQuery('#post<?= $_POST['idutente']; ?>').remove(); ">
                    <img src="images/close2.png" width="30" />
                </a>
               
                
                 </div>-->

                <!--               <a href="<?= BASE_URL; ?>ordini.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>-->

                <div style="clear:both"></div>
                <div style="float:left;width:32%;margin-right:15px;">

                    -<b>Nome cliente:</b> <?= $records['nome'] . " " . $records['cognome']; ?> <br />
                    -<b>Tipologia:</b> <?= $records['tipologia']; ?> <br />
                    -<b>Data di registrazione:</b><?= date('d/m/Y', strtotime($records['data_regis'])); ?><br />
                    -<b>Ragione Sociale:</b> <?= $records['ragione']; ?> <br />
                    -<b>P.iva:</b> <?= $records['p_iva']; ?> <br />
                    <!--                -<b>Codice Fiscale:</b> <?= $records['cod_fiscale']; ?> <br />
                -<b>Indirizzo:</b> <?= $records['indirizzo']; ?> <br />
                -<b>Città:</b> <?= $records['citta']; ?> <br />
                -<b>Provincia:</b> <?= $records['provincia']; ?> <br />
                -<b>Cap:</b> <?= $records['cap']; ?> <br />
                -<b>Telefono:</b> <?= $records['telefono']; ?> <br />
                -<b>Cellulare:</b> <?= $records['cellulare']; ?> <br />
                -<b>Email:</b> <?= $records['email']; ?> <br /><br /><br />-->


                </div>

                <div style="float:left;width:32%;margin-right:15px;">

                    -<b>Codice Fiscale:</b> <?= $records['cod_fiscale']; ?> <br />
                    -<b>Indirizzo:</b> <?= $records['indirizzo']; ?> <br />
                    -<b>Città:</b> <?= $listIndirizzo['nome_comune']; ?> <br />
                    -<b>Provincia:</b> <?= $listIndirizzo['nome_provincia']; ?> <br />
                </div>

                <div style="float:left;width:32%;">

                    -<b>Cap:</b> <?= $records['cap']; ?> <br />
                    -<b>Telefono:</b> <?= $records['telefono']; ?> <br />
                    -<b>Cellulare:</b> <?= $records['cellulare']; ?> <br />
                    -<b>Email:</b> <?= $records['email']; ?> <br /><br /><br />

                </div>

                <div style="clear:both"></div>

                <div style="float:left;width:32%;margin-right:15px;">

                    -<b>Codice personale:</b> <?php
                                                if ($records['codice_personale_attivo'] == 's') {
                                                    echo $records['id'];
                                                } ?> <br />
                    -<b>Codice Madre:</b> <?= $records['codice_madre']; ?> <br />
                    -<b>Utente Madre:</b>
                    <?php if ($records['codice_madre'] != 0) {

                        $db->query(" SELECT bag_utenti.* 
                                     FROM 
                                     bag_utenti
                                     WHERE id= '" . $records['codice_madre'] . "' ");
                        $recordm = $db->single();

                        echo $recordm['nome'] . " " . $recordm['cognome']; ?>


                        <a title="Vedi dettagli" id="dett3<?= $records['codice_madre']; ?>" style="margin:2px 0px 0px 5px;"
                            onclick="jQuery('#data').append(jQuery('<div>').load('<?= BASE_URL; ?>loaddettagliutente2.php #data',{idutente:'<?= $records['codice_madre']; ?>'},function(){}));
                       jQuery('#closedett3<?= $records['codice_madre']; ?>').show();jQuery('#dett3<?= $records['codice_madre']; ?>').hide();
                       jQuery('html, body').animate({ scrollTop: jQuery(document).height() }, 1000);"
                            href="javascript:void(null)">
                            <img src="images/dettagli.png" />
                        </a> &nbsp;

                        <a title="Nascondi dettagli" id="closedett3<?= $records['codice_madre']; ?>" style="margin:2px 0px 0px 5px;display:none;"
                            onclick="jQuery('#post<?= $records['codice_madre']; ?>').slideUp('slow', function() {jQuery('#post<?= $records['codice_madre']; ?>').remove();});jQuery('#closedett3<?= $records['codice_madre']; ?>').hide();jQuery('#dett3<?= $records['codice_madre']; ?>').show();"
                            href="javascript:void(null)">
                            <img src="images/hide.png" width="20" />
                        </a> &nbsp;

                    <?php } ?>



                    <!--             -<b>Num. Utenti Figli:</b>  <?= calcola_num_figli($records['id']); ?>    <br />
                -<b>Punti personali da acquisti:</b> 
                0 + 
                <?= ($records['totale_ordini'] * 2) / 100 * 40; ?> 
                <br />-->



                </div>

                <div style="float:left;width:32%;margin-right:15px;">

                    -<b>Primo acquisto:</b>
                    <!--                Qui bisogna calcolare il primo rodine-->
                    <?= $records['primo_acquisto']; ?> &euro;
                    <br />
                    -<b>Altri acquisti:</b>
                    <!--                Qui bisogna calcolare il totale dagli ordini-->
                    <?= $records['totale_ordini']; ?> &euro;
                    <br />

                    -<b>Punti totali:</b> <?= $records['punti_totali']; ?> <br />


                </div>

                <div style="float:left;width:32%;">


                    -<b>Punti totali:</b> <?= $records['punti_totali']; ?> <br />
                    <!--                     -<b>Punti totali da acquisti:</b>
                         <?php if ($records['codice_madre'] != 0) {
                                echo ($records['primo_acquisto'] * 2) . " +";
                            } else echo "0 + "; ?>
                         <?= $records['totale_ordini'] * 2; ?> <br />-->
                    -<b>Punti pagati</b> 0 = <?= $records['credito_ricevuto']; ?> &euro;<br />
                    -<b>Punti attuali:</b> <?= $records['punti_attuali']; ?> <br />


                </div>

                <div style="clear:both"></div><br />
                <h4> Albero Utenti di <?= $records['nome'] . " " . $records['cognome']; ?></h4><br />
                <div style="clear:both"></div>

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
                            <th class="head1" style="width:220px;background-color:#e8e47c;">Ut. secondo livello</th>
                            <th class="head0" style="width:220px;background-color:#d8f3ff;">Ut. terzo livello</th>
                            <th class="head1" style="width:220px;background-color:#bddc96;">Ut. quarto livello</th>
                            <th class="head0" style="width:100px;">Primo acquisto</th>
                            <th class="head1" style="width:150px;">Successivi acquisti</th>
                            <th class="head0" style="width:60px;">Punti da acquisti</th>
                            <th class="head1" style="width:170px;">Punti generati </th>
                            <th class="head0" style="width:70px;">Credito generato </th>
                        </tr>
                    </thead>


                    <tbody>

                        <?php
                        $totalepuntigen = 0;

                        $db->query("SELECT bag_utenti.* 
                                     FROM 
                                     bag_utenti
                                     WHERE codice_madre='" . $_POST['idutente'] . "'");
                        $record1 = $db->resultset();
                        $cont1 = 0;
                        foreach ($record1 as $list) {

                            $cont1++;
                            $totalepuntiprimo = ($list['primo_acquisto']) * 2;
                            $totalepuntialtro = ($list['totale_ordini']) * 2;
                            $totalepunti_generati_primoacquisto = (($list['primo_acquisto'] * 2) / 100) * 40;
                            $totalepunti_generati_altriacquisti = (($list['totale_ordini'] * 2) / 100) * 30;
                            $totalepuntigen = $totalepuntigen + $totalepunti_generati_primoacquisto + $totalepunti_generati_altriacquisti;
                        ?>

                            <tr class="gradeX">
                                <td style="background-color:#e8e47c;"><?= $list['nome'] . " " . $list['cognome']; ?>

                                    <a title="Vedi dettagli" id="dett<?= $list['id']; ?>" style="float:right;margin:2px 0px 0px 5px;"
                                        onclick="jQuery('#data').append(jQuery('<div>').load('<?= BASE_URL; ?>loaddettagliutente2.php #data',{idutente:'<?= $list['id']; ?>'},function(){}));
                                       jQuery('#closedett<?= $list['id']; ?>').show();jQuery('#dett<?= $list['id']; ?>').hide();
                                       jQuery('html, body').animate({ scrollTop: jQuery(document).height() }, 1000);"
                                        href="javascript:void(null)">
                                        <img src="images/dettagli.png" />
                                    </a> &nbsp;

                                    <a title="Nascondi dettagli" id="closedett<?= $list['id']; ?>" style="float:right;margin:2px 0px 0px 5px;display:none;"
                                        onclick="jQuery('#post<?= $list['id']; ?>').slideUp('slow', function() {jQuery('#post<?= $list['id']; ?>').remove();});jQuery('#closedett<?= $list['id']; ?>').hide();jQuery('#dett<?= $list['id']; ?>').show();"
                                        href="javascript:void(null)">
                                        <img src="images/hide.png" width="20" />
                                    </a> &nbsp;
                                </td>
                                <td></td>
                                <td></td>
                                <td><?= $list['primo_acquisto']; ?> &euro;</td>
                                <td><?= $list['totale_ordini']; ?> &euro;</td>
                                <td><?= $totalepuntiprimo; ?> + <?= $totalepuntialtro; ?></td>
                                <td>
                                    <b style="color:#eb6362;"><?= $totalepunti_generati_primoacquisto; ?> </b> &nbsp;<i style="font-size:10px;">(40%) </i>
                                    + <b style="color:#eb6362;"><?= $totalepunti_generati_altriacquisti; ?> </b>&nbsp;<i style="font-size:10px;">(30%) </i>
                                </td>
                                <td> <?= ($totalepunti_generati_primoacquisto + $totalepunti_generati_altriacquisti) * 0.05; ?> &euro;</td>

                            </tr>

                            <?php

                            $db->query("SELECT bag_utenti.* 
                                                       FROM 
                                                       bag_utenti
                                                       WHERE codice_madre='" . $list['id'] . "'");
                            $record2 = $db->resultset();


                            foreach ($record2 as $list2) {

                                $cont2++;
                                $cont2 = 0;
                                $totalepuntiprimo2 = ($list2['primo_acquisto']) * 2;
                                $totalepuntialtro2 = ($list2['totale_ordini']) * 2;
                                $totalepunti_generati_primoacquisto2 = (($list2['primo_acquisto'] * 2) / 100) * 30;
                                $totalepunti_generati_altriacquisti2 = (($list2['totale_ordini'] * 2) / 100) * 20;
                                $totalepuntigen = $totalepuntigen + $totalepunti_generati_primoacquisto2 + $totalepunti_generati_altriacquisti2;

                            ?>

                                <tr class="gradeX">
                                    <td></td>
                                    <td style="background-color:#d8f3ff;">
                                        <?= $list2['nome'] . " " . $list2['cognome']; ?>

                                        <a title="Vedi dettagli" id="dett2<?= $list2['id']; ?>" style="float:right;margin:2px 0px 0px 5px;"
                                            onclick="jQuery('#data').append(jQuery('<div>').load('<?= BASE_URL; ?>loaddettagliutente2.php #data',{idutente:'<?= $list2['id']; ?>'},function(){}));
                                                   jQuery('#closedett2<?= $list2['id']; ?>').show();jQuery('#dett2<?= $list2['id']; ?>').hide();
                                                   jQuery('html, body').animate({ scrollTop: jQuery(document).height() }, 1000);"
                                            href="javascript:void(null)">
                                            <img src="images/dettagli.png" />
                                        </a> &nbsp;

                                        <a title="Nascondi dettagli" id="closedett2<?= $list2['id']; ?>" style="float:right;margin:2px 0px 0px 5px;display:none;"
                                            onclick="jQuery('#post<?= $list2['id']; ?>').slideUp('slow', function() {jQuery('#post<?= $list2['id']; ?>').remove();});jQuery('#closedett2<?= $list2['id']; ?>').hide();jQuery('#dett2<?= $list2['id']; ?>').show();"
                                            href="javascript:void(null)">
                                            <img src="images/hide.png" width="20" />
                                        </a> &nbsp;

                                    </td>
                                    <td></td>
                                    <td><?= $list2['primo_acquisto']; ?> &euro;</td>
                                    <td><?= $list2['totale_ordini']; ?> &euro;</td>
                                    <td><?= $totalepuntiprimo2; ?> + <?= $totalepuntialtro2; ?></td>
                                    <td>
                                        <b style="color:#eb6362;"><?= $totalepunti_generati_primoacquisto2; ?> </b> &nbsp;<i style="font-size:10px;">(30%) </i>
                                        + <b style="color:#eb6362;"><?= $totalepunti_generati_altriacquisti2; ?> </b>&nbsp;<i style="font-size:10px;">(20%) </i>

                                    </td>
                                    <td> <?= ($totalepunti_generati_primoacquisto2 + $totalepunti_generati_altriacquisti2) * 0.05; ?> &euro;</td>
                                </tr>


                                <?php

                                $db->query("SELECT bag_utenti.* 
                                                           FROM 
                                                           bag_utenti
                                                           WHERE codice_madre='" . $list2['id'] . "'");
                                $record3 = $db->resultset();
                                $cont3 = 0;


                                foreach ($record3 as $list3) {

                                    $cont3++;

                                    $totalepuntiprimo3 = $list3['primo_acquisto'] * 2;
                                    $totalepuntialtro3 = $list3['totale_ordini'] * 2;
                                    $totalepunti_generati_primoacquisto3 = (($list3['primo_acquisto'] * 2) / 100) * 20;
                                    $totalepunti_generati_altriacquisti3 = (($list3['totale_ordini'] * 2) / 100) * 10;
                                    $totalepuntigen = $totalepuntigen + $totalepunti_generati_primoacquisto3 + $totalepunti_generati_altriacquisti3;
                                ?>


                                    <tr class="gradeX">
                                        <td></td>
                                        <td></td>
                                        <td style="background-color:#bddc96;"><?= $list3['nome'] . " " . $list3['cognome']; ?>


                                            <a title="Vedi dettagli" id="dett3<?= $list3['id']; ?>" style="float:right;margin:2px 0px 0px 5px;"
                                                onclick="jQuery('#data').append(jQuery('<div>').load('<?= BASE_URL; ?>loaddettagliutente2.php #data',{idutente:'<?= $list3['id']; ?>'},function(){}));
                                                   jQuery('#closedett3<?= $list3['id']; ?>').show();jQuery('#dett3<?= $list3['id']; ?>').hide();
                                                   jQuery('html, body').animate({ scrollTop: jQuery(document).height() }, 1000);"
                                                href="javascript:void(null)">
                                                <img src="images/dettagli.png" />
                                            </a> &nbsp;

                                            <a title="Nascondi dettagli" id="closedett3<?= $list3['id']; ?>" style="float:right;margin:2px 0px 0px 5px;display:none;"
                                                onclick="jQuery('#post<?= $list3['id']; ?>').slideUp('slow', function() {jQuery('#post<?= $list3['id']; ?>').remove();});jQuery('#closedett3<?= $list3['id']; ?>').hide();jQuery('#dett3<?= $list3['id']; ?>').show();"
                                                href="javascript:void(null)">
                                                <img src="images/hide.png" width="20" />
                                            </a> &nbsp;



                                        </td>
                                        <td><?= $list3['primo_acquisto']; ?> &euro;</td>
                                        <td><?= $list3['totale_ordini']; ?> &euro;</td>
                                        <td><?= $totalepuntiprimo3; ?> + <?= $totalepuntialtro3; ?></td>
                                        <td>
                                            <b style="color:#eb6362;"><?= $totalepunti_generati_primoacquisto3; ?> </b> &nbsp;<i style="font-size:10px;">(20%) </i>
                                            + <b style="color:#eb6362;"><?= $totalepunti_generati_altriacquisti3; ?> </b>&nbsp;<i style="font-size:10px;">(10%) </i>
                                        </td>

                                        <td> <?= ($totalepunti_generati_primoacquisto3 + $totalepunti_generati_altriacquisti3) * 0.05; ?> &euro;</td>
                                    </tr>



                        <?php
                                }
                            }
                        }  ?>



                        <tr class="gradeX">
                            <td></td>
                            <td></td>
                            <td style="font-size:16px;background-color: #ffe5ff;"> <b>Dati personali</b></td>

                            <td style="background-color: #ffe5ff;"> <?= $records['primo_acquisto']; ?> &euro;</td>
                            <td style="background-color: #ffe5ff;"><?= $records['totale_ordini']; ?> &euro;</td>
                            <td style="background-color: #ffe5ff;">
                                <?php if ($records['codice_madre'] != 0) {
                                    echo ($records['primo_acquisto'] * 2) . " +";
                                } else echo "0 + "; ?>
                                <?= $records['totale_ordini'] * 2; ?>
                            </td>
                            <td style="background-color: #ffe5ff;">
                                <b style="color:#eb6362;"> 0 + <?= (($records['totale_ordini'] * 2) / 100) * 40; ?> </b><i>&nbsp; &nbsp;(40%) </i>
                            </td>
                            <?php $totalepuntigen = $totalepuntigen + ((($records['totale_ordini'] * 2) / 100) * 40) ?>
                            <td style="background-color: #ffe5ff;"> <?= (($records['totale_ordini'] * 2) / 100) * 40 * 0.05; ?> &euro;</td>
                        </tr>
                        <tr class="gradeX">
                            <td style="text-align:center;font-size:17px;"><?= $cont1; ?></td>
                            <td style="text-align:center;font-size:17px;"><?= $cont2; ?></td>
                            <td style="text-align:center;font-size:17px;"><?= $cont3; ?></td>
                            <td></td>
                            <td style="font-size:16px;color:red; text-align: center"><b>&#8592; TOTALI &#8594;</b></td>
                            <td></td>
                            <td style="font-size:17px;">
                                <b style="color:#eb6362;"><?= $totalepuntigen; ?> </b>
                            </td>
                            <td style="font-size:17px;"> <?= $totalepuntigen * 0.05; ?> &euro;</td>
                        </tr>


                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>