<?php
require("config.php");
require("inc_header.php");
if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt'];
else   $todo = 'view';
$lng = "it";
?>

<!-- Add fancyBox -->
<link rel="stylesheet" href="<?= BASE_URL; ?>js/fancybox-2.1.7/source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL; ?>js/fancybox-2.1.7/source/jquery.fancybox.js"></script>
<!--    <script type="text/javascript" src="<?= BASE_URL; ?>js/uploadify/jquery.uploadify.js"></script>-->
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/custom/general.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/custom/tables.js"></script>
<!--    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.uniform.min.js"></script>-->
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/charCount.js"></script>
<!--    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/ui.spinner.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/tooltip.jquery.js"></script>-->
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/custom/editor.js"></script>
<!--     <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>js/uploadify/uploadify.css" />-->

<!-- Add mousewheel plugin (this is optional) -->
<!--    <script type="text/javascript" src="<?= BASE_URL; ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>-->

<!--  
    <script>
    jQuery(document).ready(function(){ jQuery('input:checkbox, input:radio, select.uniformselect, input:file').uniform();});
    </script>-->

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

    .select2,
    .uniformselect {
        width: 40.7%;
        padding: 10px;
    }
</style>

</head>

<body>
    <?php

    require("inc_menu.php");
    require("inc_leftside.php");

    if ($todo == 'view') {  ?>

        <div style="display:none;">
            <div id="data" style="width:1100px;">-</div>
        </div>

        <!-- DIV per i dettagli utente -->

        <div class="centercontent tables">

            <div id="contentwrapper" class="contentwrapper">

                <div class="contenttitle2">

                    <h3>Gestione Utenti</h3>

                </div><!--contenttitle-->

                <a href="<?= BASE_URL; ?>utenti.php?opt=new">
                    <button class="stdbtn btn_blue" style="float:right;margin:20px;">Inserisci nuovo</button>
                </a>
                <a href="uteexc.php" target="_blank" title="Esporta in excel per mailup" style="float:right;margin:20px 40px 0px 0px;">
                    <img src="<?= BASE_URL; ?>images/excel.png" />
                </a>

                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">

                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>

                    <thead>
                        <tr>
                            <th class="head1">Nome</th>
                            <th class="head0">Cognome</th>
                            <th class="head1">Email</th>
                            <th class="head0">Cellulare</th>
                            <th class="head1">Tipologia</th>
                            <th class="head1" style="width:130px;">Attivo</th>
                            <th class="head0" style="width:130px;text-align:center;">Dettagli</th>
                            <th class="head1" style="width:130px;">&nbsp;</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th class="head1">Nome</th>
                            <th class="head0">Cognome</th>
                            <th class="head1">Email</th>
                            <th class="head0">Cellulare</th>
                            <th class="head1">Tipologia</th>
                            <th class="head1" style="width:130px;">Attivo</th>
                            <th class="head0" style="width:130px;text-align:center;">Dettagli</th>
                            <th class="head1" style="width:130px;">&nbsp;</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php

                        $db->query("SELECT bag_utenti.* 
                                 FROM 
                                 bag_utenti
                                 ORDER BY bag_utenti.nome");

                        $records = $db->resultset();

                        if ($db->rowCount() == 0) {

                        ?>
                            <center>
                                <p style="font-size:11px;"><b>Nessun record presente</b></p>
                            </center>

                            <?php } else {
                            foreach ($records as $list) {    ?>

                                <tr class="gradeX">
                                    <td><?= $list['nome']; ?></td>
                                    <td><?= $list['cognome']; ?></td>
                                    <td><?= $list['email']; ?></td>
                                    <td><?= $list['cellulare']; ?></td>
                                    <td><?= $list['tipologia']; ?></td>
                                    <td>
                                        <center><img src="./images/<?= $list['attivo']; ?>.jpg" border="0" /></center>
                                    </td>
                                    <td class="center" style="text-align:center;"><a class="inline" id="<?= $list['id']; ?>" href="#data" title="Vedi dettagli utente"> <img src="images/detail.png" /></a> &nbsp;
                                    <td class="center"><a href="javascript:void(null);" onclick="jQuery('#edit<?= $list['id']; ?>').submit();">Modifica</a> &nbsp;
                                        <a href="" class="delete" for="<?= BASE_URL; ?>§<?= $list['id']; ?>§elimina§bag_utenti">Elimina</a>
                                        <form id="edit<?= $list['id']; ?>" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <input type="hidden" name="opt" id="opt" value="edit" />
                                            <input type="hidden" value="<?= $list['id']; ?>" id="id" name="id" />
                                        </form>
                                    </td>
                                </tr>

                            <?php }  ?>

                    </tbody>

                </table>

            </div>

        </div>

        <br /><br />

        <!-- Script per vedere i dettagli -->
        <script>
            jQuery("a.inline").fancybox({

                'beforeLoad': function() {
                    jQuery('#data').load('<?= BASE_URL; ?>loaddettagliutente.php #data', {
                        idutente: jQuery(this.element).attr('id')
                    }, function() {});
                }

            });
        </script>

    <?php   }
                    }   //FINE VISUALIZZAZIONE  

                    else if ($todo == 'new') {  //INIZIO INSERIMENTO NUOVO UTENTE
                        $db->query("SELECT max(id) AS idmax FROM bag_utenti ");
                        $listm = $db->single();
                        $nextid = $listm['idmax'] + 1;
    ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">

            <div id="formbasic" class="subcontent">

                <form id="form_utenti" class="stdform" action="javascript:void(null)" method="post">
                    <input name="function" id="function" value="insutente" type="hidden" />
                    <div class="contenttitle2">
                        <h3>NUOVO UTENTE</h3>
                    </div><!--contenttitle--><br />

                    <p>
                        <b>Attivo</b><br />
                        <span class="field">
                            <select name="attivo" class="uniformselect">
                                <option value="s">Si</option>
                                <option value="n" selected="selected">No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Tipologia</b><br />
                        <span class="field">
                            <select name="tipologia" class="uniformselect">
                                <option value="privato">Privato</option>
                                <option value="installatore">Installatore</option>
                                <option value="rivenditore">Rivenditore</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Nome</b><br />
                        <input type="text" name="nome" id="nome" class="smallinput" required />
                    </p>
                    <p>
                        <b>Cognome </b><br />
                        <input type="text" name="cognome" id="cognome" class="smallinput" />
                    </p>
                    <p>
                        <b>Email </b><br />
                        <input type="email" name="email" id="email" class="smallinput" required />
                    </p>

                    <p>
                        <b>Password</b><br />
                        <span class="field"><input type="text" name="password" id="password" class="smallinput" /></span>
                    </p>
                    <p>
                        <b>Ragione Sociale</b><br />
                        <span class="field"><input type="text" name="ragione" id="ragione" class="smallinput" /></span>
                    </p>
                    <p>
                        <b>P. Iva</b><br />
                        <span class="field"><input type="text" name="p_iva" id="p_iva" class="smallinput" /></span>
                    </p>
                    <p>
                        <b>Codice Fiscale</b><br />
                        <span class="field"><input type="text" name="cod_fiscale" id="cod_fiscale" class="smallinput" /></span>
                    </p>
                    <p>
                        <b>Indirizzo</b><br />
                        <span class="field"><input type="text" name="indirizzo" id="indirizzo" class="smallinput" /></span>
                    </p>

                    <p>
                        <span class="field">
                            <b>Nazione</b><br />
                            <select name="id_nazione" required id="id_nazione" class="select2">
                                <option value="">Seleziona</option>
                                <?php

                                $db->query("SELECT *
                                            FROM  
                                            nazioni
                                            ORDER by id
                                           ");
                                $recordr = $db->resultset();
                                foreach ($recordr as $list) {
                                ?>
                                    <option value="<?= $list['id']; ?>" <?php if ($list['id'] == '106') echo "selected='selected'"; ?>><?= $list['nome_' . $lng]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                    </p>
                    </span>
                    <p>
                        <span class="field">
                            <div id="regione">
                                <b>Regione</b><br />
                                <select name="id_regione" required class="select2" id="id_regione"
                                    onchange="jQuery('#provincia').load('functionload.php #data',{function:'provincereg',id_regione:jQuery(this).val()},
                                                  function(){jQuery('#id_provincia .select2').select2({
                                                        theme: 'classic',
                                                        dropdownAutoWidth: true,
                                                        width: '40.7%',
                                                        padding: '10px'
                                             });});">
                                    <option value="">Regione</option>
                                    <?php
                                    $db->query("SELECT *
                                            FROM  
                                            regioni
                                            ORDER by nome
                                           ");
                                    $recordr = $db->resultset();
                                    foreach ($recordr as $list) {
                                    ?>
                                        <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </span>
                    </p>
                    <p>
                        <span class="field">
                            <div id="provincia"></div>
                        </span>
                    </p>
                    <p>
                        <span class="field">
                            <div id="comune"></div>
                            <!-- <select name="comune" class="uniformselect" disabled>
                                <option value="">Seleziona</option>
                            </select> -->
                        </span>
                    </p>
                    <p>
                        <span class="field">
                            <div id="cap"></div>
                        </span>
                    </p>

                    <p>
                        <b>Telefono</b><br />
                        <span class="field"><input type="text" name="telefono" id="telefono" class="smallinput" /></span>
                    </p>

                    <p>
                        <b>Cellulare</b><br />
                        <span class="field"><input type="text" name="cellulare" id="cellulare" class="smallinput" /></span>
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

<?php }  //FINE INSERIMENTO UTENTE

                    else if ($todo == 'edit') { //INIZIO MODIFICA UTENTE

                        $db->query("SELECT * FROM bag_utenti WHERE id='" . $_REQUEST['id'] . "' ");
                        $list = $db->single();


                        $db->query("SELECT
                                            r.id AS id_regione,
                                            p.id AS id_provincia
                                        FROM regioni r
                                        INNER JOIN province p ON p.id_regione = r.id
                                        INNER JOIN comuni c ON c.id_provincia = p.id
                                        WHERE c.id=" . $list['id_comune'] . " ");
                        $listIndirizzo = $db->single();
                        // echo '<pre>SELECT
                        //                     r.id AS id_regione,
                        //                     p.id AS id_provincia
                        //                 FROM regioni r
                        //                 INNER JOIN province p ON p.id_regione = r.id
                        //                 INNER JOIN comuni c ON c.id_provincia = p.id
                        //                 WHERE c.id=' . $list['id_comune'] . ' </pre>';
?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
            <div id="formbasic" class="subcontent">

                <form id="form_utenti" class="stdform" action="javascript:void(null)" method="post">

                    <input name="function" id="function" value="editutente" type="hidden" />
                    <input name="id" value="<?= $_REQUEST['id']; ?>" type="hidden" />
                    <div class="contenttitle2">
                        <h3>UTENTE</h3>
                    </div>
                    <br />
                    <p>
                        <b>Attivo</b><br />
                        <span class="field">
                            <select name="attivo" class="uniformselect">
                                <option value="s" <?php if ($list['attivo'] == 's') echo "selected='selected'";  ?>>Si</option>
                                <option value="n" <?php if ($list['attivo'] == 'n') echo "selected='selected'";  ?>>No</option>
                            </select>
                        </span>
                    </p>
                    <p>
                        <b style="color:forestgreen;">Note</b><br />
                        <span class="field"><input style="color:forestgreen;" type="text" name="note_regis" id="note_regis" class="smallinput" value="<?= str_replace("'", "", str_replace('"', '', $list['note_regis'])); ?>" /></span>
                    </p>


                    <!--                         <p>
                            <b>Codice Personale Attivo</b><br />
                            <span class="field">
                            <select name="codice_personale_attivo" class="uniformselect">
                            <option value="s" <?php if ($list['codice_personale_attivo'] == 's') echo "selected='selected'";  ?>>Si</option>
                            <option value="n" <?php if ($list['codice_personale_attivo'] == 'n') echo "selected='selected'";  ?>>No</option>
                            </select>
                            </span>
                        </p>
                        
                          <p>
			<b>Codice Madre</b><br />
                            <input type="text" name="codice_madre" id="nome" class="smallinput" value="<?= $list['codice_madre']; ?>"  />
                        </p>
                        -->
                    <!--                        
                        <p>
			<b>Punti Totali</b><br />
                            <input type="text" name="punti_totali" id="nome" class="smallinput" value="<?= $list['punti_totali']; ?>" />
                        </p>
                        
                        <p>
			<b>Punti Attuali</b><br />
                            <input type="text" name="punti_attuali" id="nome" class="smallinput" value="<?= $list['punti_attuali']; ?>" />
                        </p>
                        
                        <p>
			<b>Credito Ricevuto</b><br />
                            <input type="text" name="credito_ricevuto" id="nome" class="smallinput" value="<?= $list['credito_ricevuto']; ?>"/>
                        </p>
                        -->


                    <p>
                        <b>Tipologia</b><br />
                        <span class="field">
                            <select name="tipologia" class="uniformselect">
                                <option value="privato" <?php if ($list['tipologia'] == 'privato') echo "selected='selected'"; ?>>Privato</option>
                                <option value="installatore" <?php if ($list['tipologia'] == 'installatore') echo "selected='selected'"; ?>>Installatore</option>
                                <option value="rivenditore" <?php if ($list['tipologia'] == 'rivenditore') echo "selected='selected'"; ?>>Rivenditore</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Nome</b><br />
                        <input type="text" name="nome" id="nome" class="smallinput" required value="<?= $list['nome']; ?>" />
                    </p>
                    <p>
                        <b>Cognome </b><br />
                        <input type="text" name="cognome" id="cognome" class="smallinput" value="<?= $list['cognome']; ?>" />
                    </p>
                    <p>
                        <b>Email </b><br />
                        <input type="email" name="email" id="email" class="smallinput" required value="<?= $list['email']; ?>" />
                    </p>

                    <p>
                        <b>Password</b><br />
                        <span class="field"><input type="text" name="password" id="password" class="smallinput" value="<?= $list['password']; ?>" /></span>
                    </p>
                    <p>
                        <b>Ragione Sociale</b><br />
                        <span class="field"><input type="text" name="ragione" id="ragione" class="smallinput" value="<?= $list['ragione']; ?>" /></span>
                    </p>
                    <p>
                        <b>P. Iva</b><br />
                        <span class="field"><input type="text" name="p_iva" id="p_iva" class="smallinput" value="<?= $list['p_iva']; ?>" /></span>
                    </p>
                    <p>
                        <b>Codice Fiscale</b><br />
                        <span class="field"><input type="text" name="cod_fiscale" id="cod_fiscale" class="smallinput" value="<?= $list['cod_fiscale']; ?>" /></span>
                    </p>
                    <p>
                        <b>Indirizzo</b><br />
                        <span class="field"><input type="text" name="indirizzo" id="indirizzo" class="smallinput" value="<?= $list['indirizzo']; ?>" /></span>
                    </p>
                    <?php
                        /*
                    <p>
                        <b>Cap</b><br />
                        <span class="field"><input type="text" name="cap" id="cap" class="smallinput" /></span>
                    </p>

                    <p>
                        <b>Città</b><br />
                        <span class="field"><input type="text" name="citta" id="citta" class="smallinput" /></span>
                    </p>

                    <p>
                        <b>Provincia</b><br />
                        <span class="field"><input type="text" name="provincia" id="provincia" class="smallinput" /></span>
                    </p>
                    */
                    ?>
                    <p>
                        <b>Nazione</b><br />
                        <span class="field">
                            <select name="id_nazione" required id="id_nazione" class="select2">
                                <option value="">Seleziona</option>
                                <?php
                                $db->query("SELECT *
                                            FROM  
                                            nazioni
                                            ORDER by id
                                           ");
                                $recordr = $db->resultset();
                                foreach ($recordr as $listN) {
                                ?>
                                    <option value="<?= $listN['id']; ?>" <?php if ($listN['id'] == $list['id_nazione']) echo "selected='selected'"; ?>><?= $listN['nome_' . $lng]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </span>
                    </p>
                    <p>
                    <div id="regione">
                        <b>Regione</b><br />
                        <span class="field">
                            <select name="id_regione" required class="select2" id="id_regione">
                                <option value="">Regione</option>
                                <?php
                                $db->query("SELECT *
                                            FROM  
                                            regioni
                                            ORDER by nome
                                           ");
                                $recordr = $db->resultset();
                                foreach ($recordr as $listR) {
                                ?>
                                    <option value="<?= $listR['id']; ?>" <?php if ($listR['id'] == $listIndirizzo['id_regione']) echo "selected='selected'"; ?>><?= $listR['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                    </p>
                    <p>
                    <div id="provincia">
                        <b>Provincia</b><br />
                        <span class="field">
                            <select name="id_provincia" required class="select2" id="id_provincia">
                                <option value="">Provincia</option>
                                <?php
                                $db->query("SELECT *
                                                FROM  
                                                province
                                                WHERE id_regione = " . mysql_escape_string($listIndirizzo['id_regione']) . "
                                                ORDER by nome
                                                ");
                                $recordr = $db->resultset();
                                foreach ($recordr as $listP) {
                                ?>
                                    <option value="<?= $listP['id']; ?>" <?php if ($listP['id'] == $listIndirizzo['id_provincia']) echo "selected='selected'"; ?>><?= $listP['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                    </p>
                    <p>
                    <div id="comune">
                        <b>Comune</b><br />
                        <span class="field">
                            <select name="id_comune" required class="select2" id="id_comune">
                                <option value="">Comune</option>
                                <?php
                                $db->query("SELECT *
                                            FROM  
                                            comuni
                                            WHERE id_provincia = " . mysql_escape_string($listIndirizzo['id_provincia']) . "
                                            ORDER by nome
                                            ");
                                $recordr = $db->resultset();
                                foreach ($recordr as $listC) {
                                ?>
                                    <option value="<?= $listC['id']; ?>" <?php if ($listC['id'] == $list['id_comune']) echo "selected='selected'"; ?>><?= $listC['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                    </p>
                    <p>
                    <div id="cap">
                        <span class="field">
                            <b>CAP</b><br />
                            <span class="field"><input type="text" name="cap" id="cap" class="smallinput" value="<?= $list['cap']; ?>" /></span>
                        </span>
                    </div>
                    </p>

                    <p>
                        <b>Telefono</b><br />
                        <span class="field"><input type="text" name="telefono" id="telefono" class="smallinput" value="<?= $list['telefono']; ?>" /></span>
                    </p>

                    <p>
                        <b>Cellulare</b><br />
                        <span class="field"><input type="text" name="cellulare" id="cellulare" class="smallinput" value="<?= $list['cellulare']; ?>" /></span>
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


<?php }  //FINE EDIT UTENTE

?>

<!-- Select2 Js -->
<script src="<?= BASE_URL; ?>js/select2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>funzionijs/utenti.js"></script>

<script>
    // jQuery('.select2').select2({
    //     theme: 'classic',
    //     dropdownAutoWidth: true,
    //     width: '40.7%',
    //     padding: '10px'
    // });
</script>


<script>
    jQuery(document).ready(function($) {
        //     jQuery('.select2').select2({
        //         theme: 'classic',
        //         dropdownAutoWidth: true,
        //         width: '40.7%',
        //         padding: '10px'
        //     });

        jQuery('#id_nazione').on('change', function() {
            if (jQuery(this).val() != 106) {
                jQuery('#regione').empty();
                jQuery('#provincia').empty();
                jQuery('#comune').empty();
                jQuery('#cap').empty();
            } else {
                jQuery('#regione').empty();
                jQuery('#regione').load('functionload.php #data', {
                        function: 'regionireg'
                    },
                    function() {
                        jQuery('#id_regione .select2').select2({
                            theme: 'classic',
                            dropdownAutoWidth: true,
                            width: '40.7%',
                            padding: '10px'
                        });
                    });
            }
        });

        jQuery('#id_regione').on('change', function() {
            // svuota completamente il div
            jQuery('#provincia').empty();
            jQuery('#provincia').load('functionload.php #data', {
                    function: 'provincereg',
                    id_regione: jQuery(this).val()
                },
                function() {
                    jQuery('#id_provincia .select2').select2({
                        theme: 'classic',
                        dropdownAutoWidth: true,
                        width: '40.7%',
                        padding: '10px'
                    });
                });
        });

        jQuery('#id_provincia').on('change', function() {
            // svuota completamente il div
            jQuery('#comune').empty();
            jQuery('#comune').load('functionload.php #data', {
                    function: 'comunireg',
                    id_provincia: jQuery(this).val()
                },
                function() {
                    jQuery('#id_comune .select2').select2({
                        theme: 'classic',
                        dropdownAutoWidth: true,
                        width: '40.7%',
                        padding: '10px'
                    });
                });
            jQuery('#cap').empty();
        });
    });
</script>

</body>

</html>