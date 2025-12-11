<?php

require("config.php");
require("inc_header.php");

?>

<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/custom/general.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/charCount.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/ui.spinner.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?= BASE_URL; ?>js/custom/editor.js"></script>

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

    $query = "SELECT * FROM carrello";
    $result = mysql_query($query) or die(mysql_error());
    $list = mysql_fetch_array($result);


    ?>

    <div class="centercontent">

        <div id="contentwrapper" class="contentwrapper">
            <div id="formbasic" class="subcontent">

                <form id="form_carrello" class="stdform" action="javascript:void(null)" method="post">

                    <input name="function" id="function" value="editcarrello" type="hidden" />
                    <div class="contenttitle2">
                        <h3>CARRELLO</h3>
                    </div><!--contenttitle--><br />

                    <p>
                        <b>Titolo 1</b><br />
                        <span class="field"><input type="text" name="tit_1" id="tit_1" class="smallinput" value="<?= $list['tit_1']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sottotitolo 1</b><br />
                        <span class="field"><input type="text" name="sottotit_1" id="sottotit_1" class="smallinput" value="<?= $list['sottotit_1']; ?>" /></span>
                    </p>
                    <p>
                        <b>Titolo 2</b><br />
                        <span class="field"><input type="text" name="tit_2" id="tit_2" class="smallinput" value="<?= $list['tit_2']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sottotitolo 2</b><br />
                        <span class="field"><input type="text" name="sottotit_2" id="sottotit_2" class="smallinput" value="<?= $list['sottotit_2']; ?>" /></span>
                    </p>
                    <p>
                        <b>Titolo 3</b><br />
                        <span class="field"><input type="text" name="tit_3" id="tit_3" class="smallinput" value="<?= $list['tit_3']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sottotitolo 3</b><br />
                        <span class="field"><input type="text" name="sottotit_3" id="sottotit_3" class="smallinput" value="<?= $list['sottotit_3']; ?>" /></span>
                    </p>
                    <p>
                        <b>Titolo 4</b><br />
                        <span class="field"><input type="text" name="tit_4" id="tit_4" class="smallinput" value="<?= $list['tit_4']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sottotitolo 4</b><br />
                        <span class="field"><input type="text" name="sottotit_4" id="sottotit_4" class="smallinput" value="<?= $list['sottotit_4']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 1</b><br />
                        <textarea id="sped_1" name="sped_1" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['sped_1']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Sped 1 costo</b><br />
                        <span class="field"><input type="text" name="sped_1_costo" id="sped_1_costo" class="smallinput" value="<?= number_format($list['sped_1_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 1 link</b><br />
                        <span class="field"><input type="text" name="sped_1_link" id="sped_1_link" class="smallinput" value="<?= $list['sped_1_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 2</b><br />
                        <textarea id="sped_2" name="sped_2" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['sped_2']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Sped 2 costo</b><br />
                        <span class="field"><input type="text" name="sped_2_costo" id="sped_2_costo" class="smallinput" value="<?= number_format($list['sped_2_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 2 link</b><br />
                        <span class="field"><input type="text" name="sped_2_link" id="sped_2_link" class="smallinput" value="<?= $list['sped_2_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 3</b><br />
                        <textarea id="sped_3" name="sped_3" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['sped_3']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Sped 3 costo</b><br />
                        <span class="field"><input type="text" name="sped_3_costo" id="sped_3_costo" class="smallinput" value="<?= number_format($list['sped_3_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 3 link</b><br />
                        <span class="field"><input type="text" name="sped_3_link" id="sped_3_link" class="smallinput" value="<?= $list['sped_3_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 4</b><br />
                        <textarea id="sped_4" name="sped_4" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['sped_4']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Sped 4 costo</b><br />
                        <span class="field"><input type="text" name="sped_4_costo" id="sped_4_costo" class="smallinput" value="<?= number_format($list['sped_4_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 4 link</b><br />
                        <span class="field"><input type="text" name="sped_4_link" id="sped_4_link" class="smallinput" value="<?= $list['sped_4_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 5</b><br />
                        <textarea id="sped_5" name="sped_5" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['sped_5']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Sped 5 costo</b><br />
                        <span class="field"><input type="text" name="sped_5_costo" id="sped_5_costo" class="smallinput" value="<?= number_format($list['sped_5_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Sped 5 link</b><br />
                        <span class="field"><input type="text" name="sped_5_link" id="sped_5_link" class="smallinput" value="<?= $list['sped_5_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 1</b><br />
                        <textarea id="pag_1" name="pag_1" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_1']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 1 costo</b><br />
                        <span class="field"><input type="text" name="pag_1_costo" id="pag_1_costo" class="smallinput" value="<?= number_format($list['pag_1_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 1 link</b><br />
                        <span class="field"><input type="text" name="pag_1_link" id="pag_1_link" class="smallinput" value="<?= $list['pag_1_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 2</b><br />
                        <textarea id="pag_2" name="pag_2" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_2']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 2 costo</b><br />
                        <span class="field"><input type="text" name="pag_2_costo" id="pag_2_costo" class="smallinput" value="<?= number_format($list['pag_2_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 2 link</b><br />
                        <span class="field"><input type="text" name="pag_2_link" id="pag_2_link" class="smallinput" value="<?= $list['pag_2_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 3</b><br />
                        <textarea id="pag_3" name="pag_3" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_3']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 3 costo</b><br />
                        <span class="field"><input type="text" name="pag_3_costo" id="pag_3_costo" class="smallinput" value="<?= number_format($list['pag_3_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 3 link</b><br />
                        <span class="field"><input type="text" name="pag_3_link" id="pag_3_link" class="smallinput" value="<?= $list['pag_3_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 4</b><br />
                        <textarea id="pag_4" name="pag_4" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_4']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 4 costo</b><br />
                        <span class="field"><input type="text" name="pag_4_costo" id="pag_4_costo" class="smallinput" value="<?= number_format($list['pag_4_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 4 link</b><br />
                        <span class="field"><input type="text" name="pag_4_link" id="pag_4_link" class="smallinput" value="<?= $list['pag_4_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 5</b><br />
                        <textarea id="pag_5" name="pag_5" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_5']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 5 costo</b><br />
                        <span class="field"><input type="text" name="pag_5_costo" id="pag_5_costo" class="smallinput" value="<?= number_format($list['pag_5_costo'], 2, ',', '.'); ?>" /></span>
                    </p>

                    <p>
                        <b>Pag 5 link</b><br />
                        <span class="field"><input type="text" name="pag_5_link" id="pag_5_link" class="smallinput" value="<?= $list['pag_5_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 6</b><br />
                        <textarea id="pag_6" name="pag_6" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_6']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 6 costo</b><br />
                        <span class="field"><input type="text" name="pag_6_costo" id="pag_6_costo" class="smallinput" value="<?= number_format($list['pag_6_costo'], 2, ',', '.'); ?>" /></span>
                    </p>

                    <p>
                        <b>Pag 6 link</b><br />
                        <span class="field"><input type="text" name="pag_6_link" id="pag_6_link" class="smallinput" value="<?= $list['pag_6_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 7</b><br />
                        <textarea id="pag_7" name="pag_7" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_7']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 7 costo</b><br />
                        <span class="field"><input type="text" name="pag_7_costo" id="pag_7_costo" class="smallinput" value="<?= number_format($list['pag_7_costo'], 2, ',', '.'); ?>" /></span>
                    </p>

                    <p>
                        <b>Pag 7 link</b><br />
                        <span class="field"><input type="text" name="pag_7_link" id="pag_7_link" class="smallinput" value="<?= $list['pag_7_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 8</b><br />
                        <textarea id="pag_8" name="pag_8" rows="15" cols="20" style="width:100px;" class="tinymce">
                             <?= $list['pag_8']; ?>
                        </textarea>
                    </p>
                    <p>
                        <b>Pag 8 costo</b><br />
                        <span class="field"><input type="text" name="pag_8_costo" id="pag_8_costo" class="smallinput" value="<?= number_format($list['pag_8_costo'], 2, ',', '.'); ?>" /></span>
                    </p>
                    <p>
                        <b>Pag 8 link</b><br />
                        <span class="field"><input type="text" name="pag_8_link" id="pag_8_link" class="smallinput" value="<?= $list['pag_8_link']; ?>" /></span>
                    </p>
                    <p>
                        <b>Costo fisso di spedizione</b><br />
                        <span class="field"><input type="text" name="costo_fisso_spedizione" id="costo_fisso_spedizione" class="smallinput" value="<?= $list['costo_fisso_spedizione']; ?>" /></span>
                    </p>
                    <p>
                        <b>Importo fino a</b><br />
                        <span class="field"><input type="text" name="importi_fino_a" id="importi_fino_a" class="smallinput" value="<?= $list['importi_fino_a']; ?>" /></span>
                    </p>
                    <p>
                        <b>Precarrello</b><br />
                        <span class="field">
                            <select name="precarrello" class="uniformselect">
                                <option value="s" <?php if ($list['precarrello'] == 's') echo "selected='selected'; "; ?>>Si</option>
                                <option value="n" <?php if ($list['precarrello'] == 'n') echo "selected='selected'; "; ?>>No</option>
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


    <script>
        jQuery("#submit").click(

            function() {
                jQuery.post("<?= BASE_URL; ?>execute.php", jQuery("#form_carrello").serialize(),
                    function(data) {

                        //Se ci sono errori in fase di registrazione 
                        if (data.errore != 'no') {

                            jQuery('#err_mess').html('<div style="color:red;">' + data.errore + '</div>').fadeIn(1000);
                        } else {

                            jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);
                            if (jQuery('#function').val() == 'editprodotto') {
                                setTimeout(function() {
                                    window.location.href = "prodotti.php?opt=edit&id=<?= $_REQUEST['id']; ?>";
                                }, 1000);
                            } else setTimeout(function() {
                                window.location.href = "carrello.php";
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