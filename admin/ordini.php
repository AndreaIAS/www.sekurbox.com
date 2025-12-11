<?php
require("config.php");
?>
<?php

if (!isset($_SESSION['admin_account']['login']) and $pagename != "login.php") {
    header("Location: login.php");
}

function ieversion()
{
    $match = preg_match('/MSIE ([0-9].[0-9])/', $_SERVER['HTTP_USER_AGENT'], $reg);
    if ($match == 0)
        return -1;
    else
        return floatval($reg[1]);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multivel Admin</title>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery-1.7.2.js"></script>
    <!--<script src="<?= BASE_URL; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>fileinput/js/fileinput_orig.js"></script>
<script src="<?= BASE_URL; ?>fileinput/js/locales/it.js"></script>
<link href="<?= BASE_URL; ?>fileinput/css/fileinput_orig.css" media="all" rel="stylesheet" type="text/css" /> -->
    <script type="text/javascript" src="<?= BASE_URL; ?>js/jquery-ui-1.11.4/jquery-ui1.11.4.min.js"></script>

    <link href="<?= BASE_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" media="screen" href="<?= BASE_URL; ?>js/jquery-ui-1.11.4/jquery-ui.css" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>css/style.default.css" type="text/css" />

    <!--<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery-1.7.2.js"></script>-->

    <!--<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>-->
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.cookie.js"></script>
    <?php if (ieversion() == 9) { ?>
        <link rel="stylesheet" media="screen" href="<?= BASE_URL; ?>css/style.ie9.css" />
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <?php } else if (ieversion() == 8) { ?>
        <link rel="stylesheet" media="screen" href="<?= BASE_URL; ?>css/style.ie8.css" />
    <?php } ?>
    <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="<?= BASE_URL_HOME; ?>css/font-awesome.min.css">
    <?php
    if (isset($_REQUEST['opt'])) $todo = $_REQUEST['opt'];
    else   $todo = 'view';
    ?>

    <!--<script src="https://code.jquery.com/jquery-migrate-1.4.1.js"></script>-->
    <script type="text/javascript" src="<?= BASE_URL; ?>js/uploadify/jquery.uploadify.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/custom/general.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/custom/tables.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/charCount.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/ui.spinner.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/tooltip.jquery.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/tinymce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/custom/editor.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>js/uploadify/uploadify.css" />

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?= BASE_URL; ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?= BASE_URL; ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <script>
        jQuery(document).ready(function() {
            jQuery('input:checkbox, input:radio, select.uniformselect, input:file').uniform();
        });
    </script>

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


</head>

<body>


    <?php

    require("inc_menu.php");
    require("inc_leftside.php");


    if ($todo == 'view') {  ?>




        <!-- DIV per associare il prodotto ai tag -->

        <div style="display:none">
            <div id="data" style="width:1000px;"></div>
        </div>

        <div class="centercontent tables">

            <div id="contentwrapper" class="contentwrapper">

                <div class="contenttitle2">

                    <h3>Gestione Ordini</h3>

                </div><!--contenttitle-->

                <!--               <a href="<?= BASE_URL; ?>ordini.php?opt=new">
               <button class="stdbtn btn_blue" style="float:right;margin:20px;" >Inserisci nuovo</button>
               </a>-->

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
                            <th class="head1">Numero</th>
                            <th class="head0">Data</th>
                            <th class="head1">Utente</th>
                            <th class="head0"> Totale Ordine</th>
                            <th class="head1">Costo spedizione</th>
                            <th class="head1">Costo pagamento</th>
                            <th class="head0">Pagato</th>
                            <th class="head1">Spedito</th>
                            <th class="head0">&nbsp;</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th class="head1">Numero</th>
                            <th class="head0">Data</th>
                            <th class="head1">Utente</th>
                            <th class="head0"> Totale Ordine</th>
                            <th class="head1">Costo spedizione</th>
                            <th class="head1">Costo pagamento</th>
                            <th class="head0">Pagato</th>
                            <th class="head1">Spedito</th>
                            <th class="head0">&nbsp;</th>
                        </tr>

                    </tfoot>

                    <tbody>

                        <?php

                        $db->query("SELECT bag_ordini.* 
                                 FROM 
                                 bag_ordini
                                 ORDER BY bag_ordini.id DESC");

                        $records = $db->resultset();


                        if ($db->rowCount() == 0) {

                        ?>

                            <center>
                                <p style="font-size:11px;"><b>Nessun record presente</b></p>
                            </center>

                            <?php } else {
                            foreach ($records as $list) {    ?>

                                <tr class="gradeX" id="$list['id']">
                                    <td><?= $list['id']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($list['data'])); ?></td>
                                    <td>
                                        <?php
                                        $db->query("SELECT * FROM bag_utenti WHERE id='" . $list['id_utente'] . "' ");
                                        $listm = $db->single();
                                        echo $listm['nome'] . " " . $listm['cognome'];
                                        ?>
                                    </td>
                                    <td><?= $list['totale']; ?></td>
                                    <td><?= $list['spese_spe']; ?></td>
                                    <td><?= $list['spese_pag']; ?></td>
                                    <td>
                                        <center><img class="imgpagato" id="<?= $list['id']; ?>" for="<?= $list['pagato']; ?>" src="./images/<?= $list['pagato']; ?>.jpg" border="0" style="cursor:pointer" /></center>
                                    </td>
                                    <td>
                                        <center><img class="imgspedito" id="<?= $list['id']; ?>" for="<?= $list['spedito']; ?>" src="./images/<?= $list['spedito']; ?>.jpg" border="0" style="cursor:pointer" /></center>
                                    </td>
                                    <td class="center"><a class="inline" id="<?= $list['id']; ?>" href="#data">Vedi dettagli</a> &nbsp;
                                    </td>


                                </tr>

                            <?php }  ?>

                    </tbody>

                </table>

            </div>

        </div>

        <br /><br />

    <?php   }    ?>


    <!-- Script per vedere i dettagli -->
    <script>
        jQuery("a.inline").fancybox({
            'onStart': function(links, index) {
                jQuery('#data').load('<?= BASE_URL; ?>loaddettagli.php #data', {
                    idordine: jQuery(links[index]).attr('id')
                }, function() {});
            }
        });
    </script>



<?php       }   //FINE VISUALIZZAZIONE  

    else if ($todo == 'new') {  //INIZIO INSERIMENTO NUOVO PRODOTTO

        $db->query("SELECT max(id) AS idmax FROM bag_ordini ");
        $listm = $db->single();
        $nextid = $listm['idmax'] + 1;

?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">

            <div id="formbasic" class="subcontent">

                <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">
                    <input name="function" id="function" value="insprodotto" type="hidden" />
                    <div class="contenttitle2">
                        <h3>NUOVO PRODOTTO</h3>
                    </div><!--contenttitle--><br />


                    <p>
                        <b>Nome</b><br />
                        <input type="text" name="nome" id="nome" class="smallinput" required />
                    </p>
                    <p>
                        <b>Descrizione </b><br />
                        <textarea name="descrizione" id="descrizione" class="tinymce"></textarea>
                    </p>
                    <p>
                        <b>Prezzo</b><br />
                        <span class="field"><input type="text" name="prezzo" id="prezzo" class="smallinput" /></span>
                    </p>
                    <p>
                        <b>Prezzo Scontato</b><br />
                        <span class="field"><input type="text" name="prezzo_scontato" id="prezzo_scontato" class="smallinput" /></span>
                    </p>

                    <p>
                        <b>Sottocategoria</b><br />
                        <span class="field">
                            <select name="id_sottocategoria" class="uniformselect">
                                <?php
                                $db->query("SELECT * FROM bag_scat order by nome");
                                $resultm = $db->resultset();
                                foreach ($resultm as $listm) { ?>
                                    <option value="<?= $listm['id']; ?>"><?= $listm['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </p>
                    <p>
                        <b>Prodotto disponibile</b><br />
                        <span class="field">
                            <select name="disponibile" class="uniformselect">
                                <option value="s">Si</option>
                                <option value="n">No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Prezzo Disponibile</b><br />
                        <span class="field">
                            <select name="prezzo_disponibile" class="uniformselect">
                                <option value="s">Si</option>
                                <option value="n">No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Testo Offerta</b> <br />
                        <textarea name="testo_offerta" id="testo_offerta" class="tinymce"></textarea>
                    </p>

                    <p>
                        <b>Metti nello slider della home</b><br />
                        <span class="field">
                            <select name="slide" class="uniformselect">
                                <option value="s">Si</option>
                                <option value="n">No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Codice</b><br />
                        <span class="field"><input type="text" name="codice" id="codice" class="smallinput" /></span>
                    </p>

                    <p>
                        <b>Codice mepa</b><br />
                        <span class="field"><input type="text" name="codice_mepa" id="codice_mepa" class="smallinput" /></span>
                    </p>

                    <p>
                        <b>Immagine principale</b><br />
                        <input type="text" class="smallinput" value="" name="img1" id="img1" />
                    </p><br />

                    <div style="float:left;width:150px;"> <span class="field">
                            <input name="img1_upload" id="img1_upload" />
                        </span>

                    </div>
                    <div id="box1" style="float:left;width:150px;display:none;margin-top:-8px;">
                        <img id="image1" src="" border="0" />
                    </div>
                    </p>
                    <div class="clearall"></div>

                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('#img1_upload').uploadify({
                                height: 30,
                                width: 120,
                                'swf': '<?= BASE_URL; ?>js/uploadify/uploadify.swf',
                                'uploader': '<?= BASE_URL; ?>js/uploadify/uploadifyprod.php',
                                'method': 'post',
                                'formData': {
                                    'num': '<?= $nextid; ?>',
                                    'titolo': 'img1',
                                    'action': 'ins'
                                },
                                'onUploadSuccess': function(file, data, response) {
                                    //alert('The file was saved to: ' + data);
                                    jQuery('#img1').val(data);
                                    jQuery('#image1').attr('src', '<?= $phpThumbBase; ?>?src=../images/img_prod/' + data + '&iar=1&w=50&h=50&aoe=1');
                                    jQuery('#box1').fadeIn();
                                }
                            });
                        });
                    </script>

                    <p>
                        <b>Immagine 2</b><br />
                        <input type="text" class="smallinput" value="" name="img2" id="img2" />
                    </p><br />

                    <div style="float:left;width:150px;"> <span class="field">
                            <input name="img2_upload" id="img2_upload" />
                        </span>
                    </div>
                    <div id="box2" style="float:left;width:150px;display:none;margin-top:-8px;">
                        <img id="image2" src="" border="0" />
                    </div>
                    </p>
                    <div class="clearall"></div>

                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('#img2_upload').uploadify({
                                height: 30,
                                width: 120,
                                'swf': '<?= BASE_URL; ?>js/uploadify/uploadify.swf',
                                'uploader': '<?= BASE_URL; ?>js/uploadify/uploadifyprod.php',
                                'method': 'post',
                                'formData': {
                                    'num': '<?= $nextid; ?>',
                                    'titolo': 'img2',
                                    'action': 'ins'
                                },
                                'onUploadSuccess': function(file, data, response) {
                                    //alert('The file was saved to: ' + data);
                                    jQuery('#img2').val(data);
                                    jQuery('#image2').attr('src', '<?= $phpThumbBase; ?>?src=../images/img_prod/' + data + '&iar=1&w=50&h=50&aoe=1');
                                    jQuery('#box2').fadeIn();
                                }
                            });
                        });
                    </script>


                    <p>
                        <b>Immagine 3</b><br />
                        <input type="text" class="smallinput" value="" name="img3" id="img3" />
                    </p><br />

                    <div style="float:left;width:150px;"> <span class="field">
                            <input name="img3_upload" id="img3_upload" />
                        </span>

                    </div>
                    <div id="box3" style="float:left;width:150px;display:none;margin-top:-8px;">
                        <img id="image3" src="" border="0" />
                    </div>
                    </p>
                    <div class="clearall"></div>

                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('#img3_upload').uploadify({
                                height: 30,
                                width: 120,
                                'swf': '<?= BASE_URL; ?>js/uploadify/uploadify.swf',
                                'uploader': '<?= BASE_URL; ?>js/uploadify/uploadifyprod.php',
                                'method': 'post',
                                'formData': {
                                    'num': '<?= $nextid; ?>',
                                    'titolo': 'img3',
                                    'action': 'ins'
                                },
                                'onUploadSuccess': function(file, data, response) {
                                    //alert('The file was saved to: ' + data);
                                    jQuery('#img3').val(data);
                                    jQuery('#image3').attr('src', '<?= $phpThumbBase; ?>?src=../images/img_prod/' + data + '&iar=1&w=50&h=50&aoe=1');
                                    jQuery('#box3').fadeIn();
                                }
                            });
                        });
                    </script>


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

    else if ($todo == 'edit') { //INIZIO MODIFICA PRODOTTO

        $db->query("SELECT * FROM bag_ordini WHERE id='" . $_REQUEST['id'] . "' ");
        $list = $db->single();

?>

    <div class="centercontent">


        <div id="contentwrapper" class="contentwrapper">
            <div id="formbasic" class="subcontent">


                <form id="form_prodotti" class="stdform" action="javascript:void(null)" method="post">

                    <input name="function" id="function" value="editprodotto" type="hidden" />
                    <input name="id" value="<?= $_REQUEST['id']; ?>" type="hidden" />
                    <div class="contenttitle2">
                        <h3>PRODOTTO</h3>
                    </div><!--contenttitle--><br />

                    <p>
                        <b>Nome</b><br />
                        <input type="text" name="nome" id="nome" class="smallinput" value="<?= $list['nome']; ?>" required />
                    </p>
                    <p>
                        <b>Descrizione </b><br />
                        <textarea name="descrizione" id="descrizione" class="tinymce"><?= $list['descrizione']; ?></textarea>
                    </p>
                    <p>
                        <b>Prezzo</b><br />
                        <span class="field"><input type="text" name="prezzo" id="prezzo" class="smallinput" value="<?= $list['prezzo']; ?>" /></span>
                    </p>
                    <p>
                        <b>Prezzo Scontato</b><br />
                        <span class="field"><input type="text" name="prezzo_scontato" id="prezzo_scontato" class="smallinput" value="<?= $list['prezzo_scontato']; ?>" /></span>
                    </p>

                    <p>
                        <b>Sottocategoria</b><br />
                        <span class="field">
                            <select name="id_sottocategoria" class="uniformselect">
                                <?php
                                $db->query("SELECT * FROM bag_scat order by nome");
                                $resultm = $db->resultset();
                                foreach ($resultm as $listm) { ?>
                                    <option value="<?= $listm['id']; ?>" <?php if ($list['id_sottocategoria'] == $listm['id']) echo "selected='selected'";  ?>><?= $listm['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </p>
                    <p>
                        <b>Prodotto disponibile</b><br />
                        <span class="field">
                            <select name="disponibile" class="uniformselect">
                                <option value="s" <?php if ($list['disponibile'] == 's') echo "selected='selected'";  ?>>Si</option>
                                <option value="n" <?php if ($list['disponibile'] == 'n') echo "selected='selected'";  ?>>No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Prezzo Disponibile</b><br />
                        <span class="field">
                            <select name="prezzo_disponibile" class="uniformselect">
                                <option value="s" <?php if ($list['prezzo_disponibile'] == 's') echo "selected='selected'";  ?>>Si</option>
                                <option value="n" <?php if ($list['prezzo_disponibile'] == 'n') echo "selected='selected'";  ?>>No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Testo Offerta</b> <br />
                        <textarea name="testo_offerta" id="testo_offerta" class="tinymce"><?= $list['testo_offerta']; ?></textarea>
                    </p>

                    <p>
                        <b>Metti nello slider della home</b><br />
                        <span class="field">
                            <select name="slide" class="uniformselect">
                                <option value="s" <?php if ($list['slide'] == 's') echo "selected='selected'";  ?>>Si</option>
                                <option value="n" <?php if ($list['slide'] == 'n') echo "selected='selected'";  ?>>No</option>
                            </select>
                        </span>
                    </p>

                    <p>
                        <b>Codice</b><br />
                        <span class="field"><input type="text" name="codice" id="codice" class="smallinput" value="<?= $list['codice']; ?>" /></span>
                    </p>

                    <p>
                        <b>Codice mepa</b><br />
                        <span class="field"><input type="text" name="codice_mepa" id="codice_mepa" class="smallinput" value="<?= $list['codice_mepa']; ?>" /></span>
                    </p>


                    <p>
                        <b>Immagine principale</b><br />
                        <input type="text" class="smallinput" name="img1" id="img1" value="<?= $list['img1']; ?>" />
                    </p><br />

                    <div style="float:left;width:150px;">
                        <span class="field">
                            <input name="img1_upload" id="img1_upload" value="<?= $list['img1']; ?>" />
                        </span>

                    </div>
                    <div id="box1" style=" <?php if ($list['img1'] == '') {
                                                echo "display:none;";
                                            } ?>float:left;width:150px;margin-top:-8px;">
                        <img id="image1" src="<?= $phpThumbBase; ?>?src=../images/img_prod/<?= $list['img1']; ?>&iar=1&w=50&h=50&aoe=1" border="0" />
                        <span style="cursor: pointer;" onclick="jQuery('#img1').val('');jQuery('#box1').fadeOut('');jQuery.post('<?= BASE_URL; ?>functionload.php',{function:'eliminafotoprod',image:'<?= $list['img1']; ?>',idprod:'<?= $list['id']; ?>',titolo:'img1'});">
                            <img src="<?= BASE_URL; ?>images/delete.png" border="0" title="elimina" />
                        </span>
                    </div>
                    </p>
                    <div class="clearall"></div>

                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('#img1_upload').uploadify({
                                height: 30,
                                width: 120,
                                'swf': '<?= BASE_URL; ?>js/uploadify/uploadify.swf',
                                'uploader': '<?= BASE_URL; ?>js/uploadify/uploadifyprod.php',
                                'method': 'post',
                                'formData': {
                                    'num': '<?= $_REQUEST['id']; ?>',
                                    'titolo': 'img1',
                                    'action': 'edit'
                                },
                                'onUploadSuccess': function(file, data, response) {
                                    //alert('The file was saved to: ' + data);
                                    jQuery('#img1').val(data);
                                    jQuery('#image1').attr('src', '<?= $phpThumbBase; ?>?src=../images/img_prod/' + data + '&iar=1&w=50&h=50&aoe=1');
                                    jQuery('#box1').fadeIn();
                                }
                            });
                        });
                    </script>


                    <p>
                        <b>Immagine 2</b><br />
                        <input type="text" class="smallinput" name="img2" id="img2" value="<?= $list['img2']; ?>" />
                    </p><br />

                    <div style="float:left;width:150px;">
                        <span class="field">
                            <input name="img2_upload" id="img2_upload" value="<?= $list['img2']; ?>" />
                        </span>

                    </div>
                    <div id="box2" style=" <?php if ($list['img2'] == '') {
                                                echo "display:none;";
                                            } ?>float:left;width:150px;margin-top:-8px;">
                        <img id="image2" src="<?= $phpThumbBase; ?>?src=../images/img_prod/<?= $list['img2']; ?>&iar=1&w=50&h=50&aoe=1" border="0" />
                        <span style="cursor: pointer;" onclick="jQuery('#img2').val('');jQuery('#box2').fadeOut('');jQuery.post('<?= BASE_URL; ?>functionload.php',{function:'eliminafotoprod',image:'<?= $list['img2']; ?>',idprod:'<?= $list['id']; ?>',titolo:'img2'});">
                            <img src="<?= BASE_URL; ?>images/delete.png" border="0" title="elimina" />
                        </span>
                    </div>
                    </p>
                    <div class="clearall"></div>

                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('#img2_upload').uploadify({
                                height: 30,
                                width: 120,
                                'swf': '<?= BASE_URL; ?>js/uploadify/uploadify.swf',
                                'uploader': '<?= BASE_URL; ?>js/uploadify/uploadifyprod.php',
                                'method': 'post',
                                'formData': {
                                    'num': '<?= $_REQUEST['id']; ?>',
                                    'titolo': 'img2',
                                    'action': 'edit'
                                },
                                'onUploadSuccess': function(file, data, response) {
                                    //alert('The file was saved to: ' + data);
                                    jQuery('#img2').val(data);
                                    jQuery('#image2').attr('src', '<?= $phpThumbBase; ?>?src=../images/img_prod/' + data + '&iar=1&w=50&h=50&aoe=1');
                                    jQuery('#box2').fadeIn();
                                }
                            });
                        });
                    </script>

                    <p>
                        <b>Immagine 3</b><br />
                        <input type="text" class="smallinput" name="img3" id="img3" value="<?= $list['img3']; ?>" />
                    </p><br />

                    <div style="float:left;width:150px;"> <span class="field">
                            <input name="img3_upload" id="img3_upload" />
                        </span>

                    </div>
                    <div id="box3" style=" <?php if ($list['img3'] == '') {
                                                echo "display:none;";
                                            } ?>float:left;width:150px;margin-top:-8px;">
                        <img id="image3" src="<?= $phpThumbBase; ?>?src=../images/img_prod/<?= $list['img3']; ?>&iar=1&w=50&h=50&aoe=1" border="0" />
                        <span style="cursor: pointer;" onclick="jQuery('#img3').val('');jQuery('#box3').fadeOut('');jQuery.post('<?= BASE_URL; ?>functionload.php',{function:'eliminafotoprod',image:'<?= $list['img3']; ?>',idprod:'<?= $list['id']; ?>',titolo:'img3'});">
                            <img src="<?= BASE_URL; ?>images/delete.png" border="0" title="elimina" />
                        </span>
                    </div>
                    </p>
                    <div class="clearall"></div>

                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('#img3_upload').uploadify({
                                height: 30,
                                width: 120,
                                'swf': '<?= BASE_URL; ?>js/uploadify/uploadify.swf',
                                'uploader': '<?= BASE_URL; ?>js/uploadify/uploadifyprod.php',
                                'method': 'post',
                                'formData': {
                                    'num': '<?= $_REQUEST['id']; ?>',
                                    'titolo': 'img3',
                                    'action': 'edit'
                                },
                                'onUploadSuccess': function(file, data, response) {
                                    //alert('The file was saved to: ' + data);
                                    jQuery('#img3').val(data);
                                    jQuery('#image3').attr('src', '<?= $phpThumbBase; ?>?src=../images/img_prod/' + data + '&iar=1&w=50&h=50&aoe=1');
                                    jQuery('#box3').fadeIn();
                                }
                            });
                        });
                    </script>


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
    jQuery(".imgpagato").click(function() {
        var questo = jQuery(this);
        jQuery.post("<?= BASE_URL; ?>functionload.php", {
                function: 'aggiornastatopag',
                id: questo.attr('id'),
                statoattuale: questo.attr('for')
            },
            function(data) {
                questo.attr('src', './images/' + data.valore + '.jpg');
                questo.attr('for', data.valore);
            },
            "json");
    });

    jQuery(".imgspedito").click(function() {
        var questo = jQuery(this);
        jQuery.post("<?= BASE_URL; ?>functionload.php", {
                function: 'aggiornastatosped',
                id: questo.attr('id'),
                statoattuale: questo.attr('for')
            },
            function(data) {
                questo.attr('src', './images/' + data.valore + '.jpg');
                questo.attr('for', data.valore);
            },
            "json");
    });

    jQuery("#form_prodotti").submit(

        function() {
            jQuery.post("<?= BASE_URL; ?>functionload.php", jQuery("#form_prodotti").serialize(),
                function(data) {

                    //Se ci sono errori in fase di registrazione 
                    if (data.errore != 'no') {

                        jQuery('#err_mess').html('<div style="color:red;">' + data.errore + '</div>').fadeIn(1000);
                    } else {

                        jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);
                        setTimeout(function() {
                            window.location.href = "ordini.php";
                        }, 1500);

                    }
                },
                "json"
            );

        }
    );
</script>

</body>

</html>