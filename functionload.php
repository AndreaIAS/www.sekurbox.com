<?php

//Include config
include('inc_config.php');

//*******************************ELIMINA PRODOTTO CARRELLO ****************************

if ($_POST['function'] == "elimina_prodotto_carrello") {
    echo "ok";
}

//*******************************AGGIORNA TOTALE CARRELLO IN MENU FISSO****************************

if ($_POST['function'] == "aggiorna_totcarr_menu") {

?>

    <a href="<?= BASE_URL; ?>/carts"><?= $lang['carrello']; ?>
        <i class="fa fa-shopping-cart" style="color: #009392;font-size: 24px;" aria-hidden="true"></i>
        <span>
            (<?= $cart->itemcount; ?>)
        </span>
    </a>

<?php }

//*****************************FINE AGGIORNA TOTALE CARRELLO IN MENU FISSO****************************

//*******************************AGGIORNA TOTALE CARRELLO IN MENU MOBILE VISIBILE TOP****************************

if ($_POST['function'] == "aggiorna_totcarr_menu_mobile_vis") { ?>

    <a href="<?= BASE_URL; ?>carts" rel="nofollow" style="position: fixed;top:16px;left:70%;z-index:99999">
        <i class="fa fa-shopping-cart" style="color: #727272;font-size: 30px;" aria-hidden="true"></i>
        <span>
            (<?= $cart->itemcount; ?>)
        </span>
    </a>

<?php }

//*****************************FINE AGGIORNA TOTALE CARRELLO IN MENU MOBILE VISIBILE TOP****************************

//*******************************AGGIORNA TOTALE CARRELLO IN MENU MOBILE****************************

if ($_POST['function'] == "aggiorna_totcarr_menu_mobile") { ?>

    <a href="<?= BASE_URL; ?>carts" rel="nofollow"><?= $lang['carrello']; ?>

        <i class="fa fa-shopping-cart" style="color: #727272;font-size: 24px;" aria-hidden="true"></i>
        <span>
            (<?= $cart->itemcount; ?>)
        </span>
    </a>

<?php }

//*****************************FINE AGGIORNA TOTALE CARRELLO IN MENU MOBILE****************************

//*******************************AGGIORNA CARRELLO IN ALTO****************************

if ($_POST['function'] == "aggiorna_carrello_inalto") {

    if ($_POST['metodo'] == 'aggiungi') {

        $db->query("SELECT * FROM bag_prodotti WHERE id='" . $_POST['id'] . "' ");
        $list = $db->single();

        if (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'installatore') {
            $prezzo = $list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_installatore']);
        } elseif (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'rivenditore') {
            $prezzo = $list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_rivenditore']);
        } else $prezzo = $list['prezzo'];


        $cart->add_item(
            $list['id'],
            $_POST['qty'],
            $prezzo,
            array(
                "nome" => $list['nome_' . $lng],
                "image" => $list['immagine'],
                "url" => BASE_URL . 'p_' . $list['id'] . '/' . seo_url($list['nome_' . $lng]),
                "codice" => $list['codice']
            )
        );
    }

    if ($_POST['metodo'] == 'elimina') {
        $cart->del_item($_POST['id']);
    }
?>

    <a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span>
            <?= $cart->itemcount; ?>
        </span></a>
    <ul>
        <?php

        $totalecarr = 0;
        foreach ($cart->get_contents() as $item) {

            //PRENDO IL TOTALE CARELLO
            $totalecarr = $totalecarr + ($item['price'] * $item['qty']);

            $totalearticolo = ($item['price'] * $item['qty']);
        ?>
            <li id="cart_list_<?= $item['id']; ?>">
                <div class="cart-single-product">
                    <div class="media">
                        <div class="pull-left cart-product-img">
                            <a href="<?= BASE_URL; ?>p_<?= $item['id']; ?>/<?= seo_url($item['info']['nome']); ?>">
                                <?php if (trim($item['info']['image']) == 'Invalid file type.') $immagine = "noimage.jpg";
                                else $immagine = $item['info']['image']; ?>
                                <img class="img-responsive" alt="product" src="<?= $phpThumbBase; ?>?src=upload/prodotti/<?= $immagine; ?>&h=334&w=272&far=1&bg=ffffff">
                            </a>
                        </div>
                        <div class="media-body cart-content">
                            <ul>
                                <li>
                                    <h2><a href="#"><?= $item['info']['nome']; ?></a></h2>
                                    <h3><span><?= $lang['codice']; ?>:</span> <?= $item['info']['codice']; ?></h3>
                                </li>
                                <li>
                                    <p>X <?= $item['qty']; ?></p>
                                </li>
                                <li>
                                    <p><?= number_format($totalearticolo, 2, ',', '.'); ?> &euro;</p>
                                </li>
                                <li>
                                    <a class="trash prod_trash" href="javascript:void(null)" for="<?= $item['id']; ?>" title="<?= $lang['del_from_cart']; ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>

        <li>
            <span><span> <?= $lang['imponibile']; ?></span></span><span><?= number_format($totalecarr, 2, ',', '.'); ?> &euro;</span>
            <!--                                                <span><span>Discount</span></span><span>$30</span>-->
            <span><span><?= $lang['iva']; ?></span></span><span><?= number_format(($totalecarr / 100) * 22, 2, ',', '.'); ?> &euro;</span>
            <span><span><?= $lang['totale']; ?></span></span><span><?= number_format((($totalecarr / 100) * 22) + $totalecarr, 2, ',', '.'); ?> &euro;</span>
        </li>
        <li>
            <ul class="checkout">
                <li><a href="<?= BASE_URL; ?>carts" class="btn-checkout" rel="nofollow"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?= $lang['carrello']; ?></a></li>
                <li><a href="<?= BASE_URL; ?>carrello1.php" class="btn-checkout"><i class="fa fa-share" aria-hidden="true"></i><?= $lang['cassa']; ?></a></li>
            </ul>
        </li>
    </ul>

<?php }

//*****************************FINE AGGIORNA CARRELLO IN ALTO****************************

//******************************** MOSTRA PRODOTTO********************************************
if ($_POST['function'] == "mostra_prodotto") {


    $db->query("SELECT bag_prodotti.*,
                bag_prodotti.id AS id_prodotto,
                bag_scat.nome_" . $lng . " AS nome_scat, 
                bag_marche.nome_" . $lng . " AS nome_marca,
                bag_marche.immagine AS img_marca    
                FROM
                bag_prodotti,bag_scat,bag_marche
                WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                AND bag_prodotti.id_marca=bag_marche.id
                AND bag_prodotti.id='" . $_POST['id'] . "'
               ");
    $list = $db->single();

    //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
    if (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'installatore') {
        $text_prezzo =   '<span ><del>&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</del></span> &euro;';
        $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_installatore']), 2, '.', '');
    } elseif (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'rivenditore') {
        $text_prezzo =   '<span ><del>&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</del></span> &euro;';
        $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_rivenditore']), 2, '.', '');
    } else {
        $text_prezzo = "&euro; " . number_format($list['prezzo'], 2, '.', '') . " ";
    }

?>

    <button type="button" class="close myclose" data-dismiss="modal">&times;</button>
    <div class="product-details1-area">
        <div class="product-details-info-area">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="inner-product-details-left">
                        <div class="tab-content">
                            <?php

                            $db->query("SELECT bag_image.*
                                                   FROM bag_image
                                                    WHERE bag_image.id_prodotto='" . $_POST['id'] . "'
                                                   ");
                            $image = $db->resultset();
                            $cont = 0;
                            foreach ($image as $listim) {
                                if (file_exists('./upload/prodotti/' . $listim['immagine'])) {
                                    $cont++;  ?>
                                    <div id="metro-related<?= $cont; ?>" class="tab-pane fade <?php if ($cont == 1) echo ' active in'; ?>">
                                        <a href="#"><img class="img-responsive" src="<?= $phpThumbBase; ?>?src=upload/prodotti/<?= $listim['immagine']; ?>&h=483&w=372&far=1&bg=ffffff" alt="single"></a>
                                    </div>
                            <?php }
                            } ?>

                        </div>
                        <ul>
                            <?php

                            $db->query("SELECT bag_image.*
                                                    FROM bag_image
                                                    WHERE bag_image.id_prodotto='" . $_POST['id'] . "'
                                                   ");
                            $image = $db->resultset();
                            $cont = 0;
                            foreach ($image as $listim) {

                                if (file_exists('./upload/prodotti/' . $listim['immagine'])) {
                                    $cont++;  ?>
                                    <li <?php if ($cont == 1) echo ' class="active"'; ?>>
                                        <a aria-expanded="false" data-toggle="tab" href="#metro-related<?= $cont; ?>">
                                            <img class="img-responsive" src="<?= $phpThumbBase; ?>?src=upload/prodotti/<?= $listim['immagine']; ?>&h=116&w=118&far=1&bg=ffffff" alt="related1">
                                        </a>
                                    </li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="inner-product-details-right">
                        <h3><?= ucfirst(strtolower($list['nome_' . $lng])); ?></h3>
                        <!--                                    <ul>
                                        <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                        <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                        <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                        <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                        <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                    </ul>-->
                        <?php echo $text_prezzo; ?>
                        <p> <?= ucfirst(strtolower($list['descrizione_' . $lng])); ?>
                        </p>
                        <div class="product-details-content">
                            <p><span><?= $lang['codice']; ?>:</span> <?= $list['codice']; ?></p>
                            <p> <?php if ($list['quantita'] > 0) { ?>
                                    <span style="color:green;"><?= $lang['disponibile']; ?></span>
                                <?php } else { ?>
                                    <span style="color:red;"><?= $lang['non_disponibile']; ?></span>
                                <?php } ?>
                            </p>
                            <p><span><?= $lang['categoria']; ?>:</span> <?= ucfirst(strtolower($list['nome_scat'])); ?></p>
                        </div>

                        <!--                                    <ul class="product-details-social">
                                        <li>Share:</li>
                                        <li><a href="#"><i aria-hidden="true" class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i aria-hidden="true" class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i aria-hidden="true" class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i aria-hidden="true" class="fa fa-pinterest"></i></a></li>
                                    </ul>-->

                        <ul class="inner-product-details-cart">
                            <li><a href="javascript:void(null)" id="nel_carrello" for="<?= $list['id_prodotto']; ?>"> <?= $lang['add_carrello']; ?></a></li>
                            <li>
                                <div class="input-group quantity-holder" id="quantity-holder">
                                    <input type="text" placeholder="1" value="1" class="form-control quantity-input" id="modal_qty" name="quantity">
                                    <div class="input-group-btn-vertical">
                                        <button type="button" class="btn btn-default quantity-plus "><i aria-hidden="true" class="fa fa-plus"></i></button>
                                        <button type="button" class="btn btn-default quantity-minus"><i aria-hidden="true" class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </li>
                            <!--                                        <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                        </ul>
                        <div class="alert alert-success  fade in" id="alert-<?= $list['id_prodotto']; ?>"
                            style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                            <strong>Prodotto inserito nel carrello!</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }

//********************************  FINE MOSTRA PRODOTTO********************************************
//********************************  DIMENSIONI SCHERMO********************************************
if ($_POST['function'] == "dimensioni_schermo") {


    if (isset($_POST['width']) && isset($_POST['height'])) {


        $_SESSION['screen_width'] = $_POST['width'];
        $_SESSION['screen_height'] = $_POST['height'];
        echo json_encode(array('outcome' => 'success', 'width' => $_SESSION['screen_width']));
    } else {
        echo json_encode(array('outcome' => 'error', 'error' => "Couldn't save dimension info"));
    }
}
//********************************  FINE DIMENSIONI SCHERMO ********************************************

//********************************  LOGIN ********************************************
if ($_POST['function'] == "login") {

    $errore = "no";

    $db->query(" SELECT * FROM 
                 bag_utenti 
                 WHERE email = '" . mysql_escape_string($_POST['email']) . "' 
                 AND password = '" . mysql_escape_string(md5($_POST['password'])) . "'
                 AND attivo='s'    ");

    $recordsa = $db->single();
    $list = $db->rowCount();

    if ($list > 0) {
        $_SESSION['user_site'] = $recordsa['id'];
        $_SESSION['nome'] = $recordsa['nome'] . " " . $recordsa['cognome'];
        $_SESSION['email'] = $recordsa['email'];
        $_SESSION['nazione'] = $recordsa['nazione'];
        $_SESSION['tipologia'] = $recordsa['tipologia'];


        //AGGIORNO IL COSTO DI EVENTUALI PRODOTTI MESSI NEL CARRELLO PRIMA DEL LOGIN
        if ($_SESSION['tipologia'] != 'privato' && $cart->itemcount > 0) {

            foreach ($cart->get_contents() as $item) {


                $index_sconto = "sconto_" . $_SESSION['tipologia'];

                $db->query("SELECT $index_sconto FROM bag_prodotti  WHERE id='" . $item['id'] . "' ");
                $list_s = $db->single();

                $new_price = $item['price'] - ($item['price'] / 100 * $list_s[$index_sconto]);

                $cart->update_price_item($item['id'], $new_price);
            }
        }
        //---------------------------------------------------------------------

        $arr = array('campo' => '', 'errore' => $errore);
        echo json_encode($arr);
    } else {
        $errore = "userassente";
        $arr = array('campo' => 'email', 'errore' => $errore);
        echo json_encode($arr);
        exit();
    }
}

//********************************FINE  LOGIN ********************************************

//******************************** MODIFICA UTENTE********************************************
if ($_POST['function'] == 'editutente') {

    $errore = "no";

    $db->query("UPDATE
                bag_utenti 
                SET 
                nome='" . mysql_escape_string($_POST['nome']) . "',
                ragione='" . mysql_escape_string($_POST['ragione']) . "',
                cognome='" . mysql_escape_string($_POST['cognome']) . "',
                p_iva='" . mysql_escape_string($_POST['p_iva']) . "',
                cod_fiscale='" . mysql_escape_string($_POST['cod_fiscale']) . "',
                indirizzo='" . mysql_escape_string($_POST['indirizzo']) . "',
                id_nazione='" . mysql_escape_string($_POST['id_nazione']) . "',
                id_comune='" . mysql_escape_string($_POST['id_comune']) . "',
                cap='" . mysql_escape_string($_POST['cap']) . "',
                telefono='" . mysql_escape_string($_POST['telefono']) . "',
                cellulare='" . mysql_escape_string($_POST['cellulare']) . "'
                WHERE id='" . mysql_escape_string($_POST['id']) . "' ");

    if ($db->execute()) {
        $arr = array('campo' => '', 'errore' => $errore);
        echo json_encode($arr);
        exit();
    }

    $errore = mysql_error();
    $arr = array('campo' => '', 'errore' => $query);
    echo json_encode($arr);
    exit();
}

//********************************FINE  MODIFICA UTENTE********************************************                                     

//******************************** MODIFICA PASSWORD  UTENTE********************************************

if ($_POST['function'] == 'modifica_pwd') {

    $errore = "no";

    $db->query("SELECT * FROM 
                 bag_utenti 
                 WHERE id = '" . $_SESSION['user_site'] . "' 
                 AND password = '" . mysql_escape_string(md5($_POST['password_attuale'])) . "'
                 AND attivo='s'    
               ");
    $recordsa = $db->single();
    $list = $db->rowCount();
    if ($list > 0) {

        $db->query("UPDATE
                bag_utenti 
                SET 
                password='" . mysql_escape_string(md5($_POST['password'])) . "'
                WHERE id='" . $_SESSION['user_site'] . "' ");

        if ($db->execute()) {
            $arr = array('campo' => '', 'errore' => $errore);
            echo json_encode($arr);
            exit();
        }
    } else {
        $errore = "Attenzione password attuale errata. Riprova";
        $arr = array('campo' => 'passw', 'errore' => $errore);
        echo json_encode($arr);
        exit();
    }
}
//******************************** FINE MODIFICA PASSWORD  UTENTE ********************************************     
//                              
//********************************  LOAD PROVINCE ********************************************
if ($_POST['function'] == "provincereg") { ?>

    <div id="data">
        <div class="cart-collaterals" style="margin-bottom:10px;" id="div_prov">
            <label><?= $lang['provincia']; ?><sup>*</sup></label>
            <select required name="id_provincia" style="width:100%" class="select2"
                onchange="jQuery('#comune').load('functionload.php #data',{function:'comunireg',id_provincia:jQuery(this).val()},
                         function(){$('.select2').select2({
                                                            theme: 'classic',
                                                            dropdownAutoWidth: true,
                                                            width: '100%'
                                                            });
                                                        });">
                <option value="">Provincia</option>
                <?php
                $db->query("SELECT * 
                     FROM 
                     province
                     WHERE id_regione='" . $_POST['id_regione'] . "'
                     ORDER BY nome");

                $records = $db->resultset();
                foreach ($records as $list) { ?>
                    <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
                <?php }


                ?>
            </select>
        </div>
    </div>

<?php }
//********************************FINE  LOAD PROVINCE  ********************************************

//********************************  LOAD COMUNI ********************************************
if ($_POST['function'] == "comunireg") { ?>

    <div id="data">
        <div class="cart-collaterals" style="margin-bottom:10px;" id="div_com">
            <label>Comune <sup>*</sup></label>
            <select required style="width:100%" name="id_comune" class="select2">
                <option value=""><?= $lang['citta']; ?></option>
                <?php
                $db->query("SELECT * 
                         FROM 
                         comuni
                         WHERE id_provincia='" . $_POST['id_provincia'] . "' 
                         ORDER BY nome");

                $records = $db->resultset();
                foreach ($records as $list) { ?>
                    <option value="<?= $list['id']; ?>"><?= $list['nome']; ?></option>
                <?php }

                ?>
            </select>
        </div>
    </div>

<?php }

//********************************FINE   LOAD COMUNI ********************************************

//******************************** REGISTRAZIONE UTENTE********************************************
if ($_POST['function'] == 'registrati') {

    $errore = "no";

    if (isset($_POST['newsletter'])) {
        $newsletter = 's';
    } else {
        $newsletter = 'n';
    }

    $db->query("SELECT * FROM 
             bag_utenti 
             WHERE 
             email = '" . mysql_escape_string($_POST['email']) . "' ");
    $recordsa = $db->resultset();
    $list = $db->rowCount();

    if ($list > 0) {
        $errore = "mailpresente";
        $arr = array('campo' => 'email', 'errore' => $errore);
        echo json_encode($arr);
        exit();
    }

    //creazione codice attivazione account    
    $usernameStrip = trim($_POST['email']);
    function ActiveCode($nome_utente)
    {
        $chiave_attivazione = md5(time() . $nome_utente . secretword);
        return $chiave_attivazione;
    }
    $chiave = ActiveCode($usernameStrip);
    $linkattivazione = pathactiveuser . '?user=' . $usernameStrip . '&active=' . $chiave;

    $db->query("INSERT INTO
                     bag_utenti (cellulare,chiave,data_regis,attivo,ragione,nome,cognome,password,p_iva,cod_fiscale,indirizzo,cap,email,tipologia,telefono,id_nazione,id_comune,note_regis) 
                     VALUES('" . mysql_escape_string($_POST['cellulare']) . "','" . $chiave . "',NOW(),'n','" . mysql_escape_string($_POST['ragione']) . "','" . mysql_escape_string($_POST['nome']) . "'
                            ,'" . mysql_escape_string($_POST['cognome']) . "','" . mysql_escape_string(md5($_POST['password'])) . "','" . mysql_escape_string($_POST['p_iva']) . "' 
                            ,'" . mysql_escape_string($_POST['cod_fiscale']) . "','" . mysql_escape_string($_POST['indirizzo']) . "','" . mysql_escape_string($_POST['cap']) . "'
                            ,'" . mysql_escape_string($_POST['email']) . "' ,'privato' 
                            ,'" . mysql_escape_string($_POST['telefono']) . "','" . mysql_escape_string($_POST['id_nazione']) . "','" . mysql_escape_string($_POST['id_comune']) . "' ,'Richiesta registrazione come \"" . mysql_escape_string($_POST['tipologia']) . "\"') ");

    if ($db->execute()) {

        $testo_email = "<span style='color:#1e6ec3;font-family:Arial,sans-serif;font-size:15px;'>";
        $testo_email .= "<span style='color:#000000;'>Gentile Cliente,<br />ti ringraziamo per esserti registrato sul nostro sito.</span><br /><br />";
        $testo_email .= "<span style='color:blue;'>Per attivare il tuo account clicca <a href=\"" . $linkattivazione . "\">qui</a></span><br /> <br />";
        $testo_email .= "<span style='color:#000000;'>Dopo aver attivato il tuo account puoi accedere al sito con i parametri da te inseriti e qui riportati:</span> <br /><br />";
        $testo_email .= "<span style='color:#000000;'>E-mail:</span> " . mysql_escape_string($_POST['email']) . "<br />";
        $testo_email .= "<span style='color:#000000;'>Password:</span> " . mysql_escape_string($_POST['password']) . "<br /><br />";
        $testo_email .= "<br /><br /><br />
                 <div style='font-size:13px;width:200px;float:left;'>
                 Sito Internet: <a style='color: #19a9e5;' href='http://www.gevenit.com'>Sekurbox.com</a><br />
                 Email: <a style='color: #19a9e5;' href='mailto:info@sekurbox.com'>info@sekurbox.com</a><br />
                 </div>
                 </span>";

        $mail = new phpmailer();
        $mail->IsHTML(true);
        $mail->From = EMAIL_ADM;
        $mail->FromName = EMAIL_ADM_NAME;
        $mail->AddAddress(mysql_escape_string($_POST['email']));
        $mail->AddBCC(EMAIL_ADM);
        $mail->Subject = "Registrazione a Sekurbox.com";
        $mail->Body = $testo_email;
        if ($mail->Send()) {
        } else {

            $errore = "Errore Invio Mail";
            $arr = array('campo' => '', 'errore' => $errore);
            echo json_encode($arr);
            exit();
        }


        $arr = array('campo' => '', 'errore' => $errore);
        echo json_encode($arr);
        exit();
    }

    $errore = mysql_error();
    $arr = array('campo' => '', 'errore' => $query);
    echo json_encode($arr);
    exit();
}

//********************************FINE  REGISTRAZIONE UTENTE********************************************     

?>