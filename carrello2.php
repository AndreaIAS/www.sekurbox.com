<?php

include("inc_config.php");
include_once("secrets.php");
//
if (!isset($_SESSION['user_site'])) {
    header("Location: " . BASE_URL . "registrati.php");
    exit();
    die();
}
if ($cart->itemcount == 0) {
    header("Location: " . BASE_URL . $lng . "/");
    exit();
    die();
}

$title_it = "Sekurbox - Conferma ordine";
$title_en = "Sekurbox - Order Confirmation";
$description_it = "";
$description_en = "";


if (isset($_POST['sped_diverso'])) {

    if ($_POST['id_nazione'] == '106') {

        $db->query("SELECT * 
                         FROM 
                         comuni
                         WHERE id='" . $_POST['id_comune'] . "' 
                         ");

        $list_com = $db->single();

        $db->query("SELECT * 
                         FROM 
                         province
                         WHERE id='" . $_POST['id_provincia'] . "' 
                        ");

        $list_prov = $db->single();

        $nazionesped = 'Italia';
        $cittasped = $list_com['nome'];
        $provsped = $list_prov['nome'];
    } else {

        $db->query("SELECT * 
                 FROM 
                 nazioni
                 WHERE id='" . $_POST['id_nazione'] . "' 
                 ");

        $list_naz = $db->single();

        $nazionesped = $list_naz['nome_' . $lng];
        $cittasped = "";
        $provsped = "";
    }

    $nomesped = $_POST['nome'];
    $cognsped = $_POST['cognome'];
    $indsped = $_POST['indirizzo'];
    $capsped = $_POST['cap'];
    $mailsped = $_POST['email'];
    $telsped = $_POST['telefono'];
    $cellsped = $_POST['cellulare'];
} else {

    $db->query("SELECT * 
                 FROM 
                 bag_utenti
                 WHERE id='" . $_SESSION['user_site'] . "' 
                 ");
    $list_ut = $db->single();

    $db->query("SELECT * 
                 FROM 
                 comuni
                 WHERE id='" . $list_ut['id_comune'] . "' 
                 ");

    $list_com = $db->single();

    $db->query("SELECT * 
                 FROM 
                 province
                 WHERE id='" . $list_com['id_provincia'] . "' 
                ");

    $list_prov = $db->single();

    $db->query("SELECT * 
                 FROM 
                 nazioni
                 WHERE id='" . $list_ut['id_nazione'] . "' 
                 ");

    $list_naz = $db->single();

    $cittasped = $list_com['nome'];
    $provsped = $list_prov['nome'];
    $nazionesped = $list_naz['nome_' . $lng];
    $nomesped = $list_ut['nome'];
    $cognsped = $list_ut['cognome'];
    $indsped = $list_ut['indirizzo'];
    $capsped = $list_ut['cap'];
    $mailsped = $list_ut['email'];
    $telsped = $list_ut['telefono'];
    $cellsped = $list_ut['cellulare'];
}

if ($_POST['metodo_sped'] == 'Bartolini' or $_POST['metodo_sped'] == 'Gls') {
    $costo_sped = 8;
} else {
    $costo_sped = 0;
}
if ($_POST['pay_metod'] == 'Carta' or $_POST['pay_metod'] == 'Bonifico') {
    $costo_pay = 0;
} else {
    $costo_pay = 0;
}

$totale_ordine = ((($cart->total / 100) * 22) + $cart->total) + $costo_sped + $costo_pay;
$idPagamUnivoco = uniqid("ORD-");

$db->query("INSERT INTO bag_ordini(id_utente,tipo_pagam,id_pagam,tipo_spedi,note,data,totale,spese_spe,spese_pag,email,
                                   cognome,nome,indirizzo,citta,cap,telefono,cellulare,provincia,spedito,pagato,nazione)
            VALUES('" . $_SESSION['user_site'] . "','" . $_POST['pay_metod'] . "',:id_pagam,'" . $_POST['metodo_sped'] . "',:note,now(),'" . $totale_ordine . "',
                   '" . $costo_sped . "','" . $costo_pay . "','" . $mailsped . "','" . $cognsped . "','" . $nomesped . "','" . $indsped . "','" . $cittasped . "',
                   '" . $capsped . "','" . $telsped . "','" . $cellsped . "','" . $provsped . "','n','n','" . $nazionesped . "') 
          ");

$result = $db->execute(array('id_pagam' => $idPagamUnivoco, 'note' => $_POST['note_ordine']));

$id_ordine = $db->lastInsertId();

foreach ($cart->get_contents() as $item) {
    $db->query("INSERT INTO bag_det_ord(id_articolo,qta,prezzo,id_ordine)
                VALUES('" . $item['id'] . "','" . $item['qty'] . "','" . $item['price'] . "','" . $id_ordine . "') 
               ");
    $result = $db->execute();
}

// Riprendiamo tutti i dati utili
$db->query("SELECT
                u.id as idutente,
                u.cognome as cognomeutente,
                u.nome as nomeutente,
                u.ragione as ragioneutente,
                u.indirizzo as indirizzoutente,
                u.cap as caputente,
                u.email as emailutente,
                u.telefono as telefonoutente,
                o.id as idordine,
                o.tipo_pagam,
                id_pagam,
                tipo_sped,
                data as data_pgam,
                totale,
                spese_spe,
                spese_pag,
                pagato,
                spedito
            FROM bag_utenti u
            INNER JOIN bag_ordini o ON o.id_utente = u.id
            WHERE o.id = " . (int)$id_ordine);

$ordine = $db->single();

if ($_POST['pay_metod'] != 'Carta' && $_POST['pay_metod'] != 'Bonifico') {
    $cart->empty_cart();

    //INVIO EMAIL CONFERMA ORDINE
    $template_email = file_get_contents(BASE_URL . "template-email.php?id_ordine=" . $id_ordine);
    //istanziamo la classe
    $messaggio = new PHPmailer();
    $messaggio->IsHTML(true);
    $messaggio->SetLanguage("it", './php_mailer_language/');
    //$messaggio->IsSMTP(); //Specify usage of SMTP Server
    //$messaggio->Host = "smtps.aruba.it"; //SMTP+ Server address 
    //$messaggio->Port="465";  //SET the SMTP Server port              
    //$messaggio->Username = "info@sekurbox.com"; //SMTP+ authentication: username
    //$messaggio->Password = ""; //SMTP+ authentication: password      
    //$messaggio->SMTPAuth = true;  //Authentication required
    //$messaggio->SMTPSecure = "ssl";
    //$mail->SMTPDebug  = 1;
    //$mail->SMTPSecure = 'tls';
    $messaggio->CharSet = 'UTF-8';

    //definiamo le intestazioni e il corpo del messaggio
    $messaggio->From = 'info@sekurbox.com';
    $messaggio->FromName = "Sekurbox";
    $messaggio->AddAddress($_SESSION['email']);

    //$mail->AddBCC('ippazio.martella@marss.eu');

    $messaggio->Subject = 'Sekurbox.com - Conferma ordine numero SK' . $id_ordine;
    $messaggio->Body = $template_email;
    //$messaggio->AddAttachment('http://www.sekurbox.com/css/stile.css'); // attach style sheet

    //definiamo i comportamenti in caso di invio corretto 
    //o di errore
    if (!$messaggio->Send()) {
        echo $messaggio->ErrorInfo;
    } else {
    }
}

if ($_POST['pay_metod'] == 'Bonifico') {
    header('Location: ' . BASE_URL . 'esito-bonifico.php?id_ordine=' . $id_ordine);
    exit;
}

include("inc_header.php");
?>

<meta name="robots" content="noindex">

</head>

<body>
    <div class="wrapper-area">

        <?php
        include("inc_menu.php");
        ?>
        <!-- Header Area End Here -->
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?= $lang['conferma_ordine']; ?></h1>
                            <ul>
                                <li><a href="<?= BASE_URL . $lng; ?>/">Home</a> /</li>
                                <li><?= $lang['conferma_ordine']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inner Page Banner Area End Here -->
        <!-- Checkout Page Area Start Here -->
        <div class="checkout-page-area" style="padding-top:30px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="order-sheet">
                            <?php echo str_replace(array('[num_ord]', '[url]'), array($id_ordine, BASE_URL), $lang['testo_ordine_confermato']); ?>

                            DETTAGLI PER IL PAGAMENTO:<br />
                            <?php

                            if ($_POST['pay_metod'] == 'Carta') {
                                // id_pagam usato come identificativo esterno
                                $orderIdEsterno = $idPagamUnivoco; // string univoca
                                $totaleEuro     = (float)$totale_ordine;
                                $amount         = (int)round($totaleEuro * 100); // centesimi

                                // Dati cliente (adatta ai tuoi nomi colonna)
                                $nome      = $ordine['nome'];
                                $cognome   = $ordine['cognome'];
                                $email     = $ordine['email'];
                                $telefono  = $ordine['telefono'];    // se vuoi usarlo
                                $cellulare = $ordine['cellulare'];   // se vuoi usarlo
                                $indirizzo = $ordine['indirizzo'];

                                // 2) Costruisci payload per /orders/hpp secondo specifiche Nexi
                                $resultUrl      = BASE_URL . 'esito-nexi.php?id_ordine=' . (int)$id_ordine;
                                $notificationUrl = BASE_URL . 'notifica-nexi.php?id_ordine=' . (int)$id_ordine;

                                $payload = array(
                                    'order' => array(
                                        'orderId'     => $orderIdEsterno,
                                        'amount'      => $amount,
                                        'currency'    => 'EUR',
                                        'description' => 'Ordine ' . $orderIdEsterno
                                    ),
                                    'paymentSession' => array(
                                        // es. cards; controlla il valore esatto ammesso per HPP
                                        'paymentService' => 'cards'
                                    ),
                                    'customer' => array(
                                        'firstName' => $nome,
                                        'lastName'  => $cognome,
                                        'email'     => $email,
                                        // eventuale indirizzo se previsto
                                    ),
                                    'urls' => array(
                                        'resultUrl'       => $resultUrl,
                                        'notificationUrl' => $notificationUrl
                                    )
                                    // eventuali altri campi previsti (language, etc.)
                                );

                                $jsonPayload = json_encode($payload);

                                // 3) Endpoint Nexi (usa sandbox/prod corretti da documentazione /orders/hpp)
                                $url = defined('NEXI_HPP_ENDPOINT') ? NEXI_HPP_ENDPOINT : '';
                                if (!$url) {
                                    die('Endpoint Nexi mancante in secrets.php (NEXI_HPP_ENDPOINT)');
                                }

                                // 4) Header con autenticazione (API key / bearer / alias + chiave, in base al tuo contratto)
                                $headers = array(
                                    'Content-Type: application/json',
                                    // 'Authorization: Bearer TUO_TOKEN',              // esempio
                                    // 'API-Key: TUO_API_KEY'                          // esempio
                                    // o altri header specifici Nexi
                                );

                                if (defined('NEXI_BEARER_TOKEN') && NEXI_BEARER_TOKEN) {
                                    $headers[] = 'Authorization: Bearer ' . NEXI_BEARER_TOKEN;
                                }
                                if (defined('NEXI_API_KEY') && NEXI_API_KEY) {
                                    $headers[] = 'API-Key: ' . NEXI_API_KEY;
                                }

                                // 5) Chiamata cURL
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                                $responseBody = curl_exec($ch);
                                $httpCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                                if ($responseBody === false) {
                                    // logga errore
                                    $err = curl_error($ch);
                                    curl_close($ch);
                                    die('Errore comunicazione Nexi: ' . htmlspecialchars($err));
                                }
                                curl_close($ch);

                                // 6) Gestione risposta
                                $res = json_decode($responseBody, true);
                                if (!is_array($res)) {
                                    die('Risposta Nexi non valida');
                                }

                                if ((int)$httpCode < 200 || (int)$httpCode >= 300) {
                                    die('Errore Nexi HTTP ' . (int)$httpCode);
                                }

                                // ATTENZIONE: i nomi dei campi dipendono dalla specifica,
                                // es. 'hostedPageUrl', 'redirectUrl', 'hostedPage', ecc. [web:40][web:3]
                                $urlHosted = isset($res['hostedPageUrl']) ? $res['hostedPageUrl'] : null;
                                $nexiOrderId = isset($res['order']['id']) ? $res['order']['id'] : null;
                                $securityToken = isset($res['securityToken']) ? $res['securityToken'] : null;

                                if (!$urlHosted) {
                                    // logga $responseBody
                                    die('URL Hosted Page mancante nella risposta Nexi');
                                }

                                // 7) Salva riferimenti Nexi nell’ordine (aggiungi colonne se non ci sono)
                                $db->query("UPDATE bag_ordini SET id_pagam=:id_pagam, dati_pagam=:dati_pagam, pagato='n' WHERE id=:id");
                                $db->execute(array(
                                    'id_pagam'   => (string)$nexiOrderId,
                                    'dati_pagam' => (string)$securityToken,
                                    'id'         => (int)$id_ordine
                                ));

                                // 8) Redirect alla Hosted Payment Page
                                header('Location: ' . $urlHosted);
                                exit;

                                /*
                                //require_once "GestPayCrypt.inc.php";
                                require_once "gestpay.php";
                                $crypt = new GestPayCrypt();
                                // impostare i seguenti parametri
                                $crypt->setShopLogin('9091587');
                                $crypt->setShopTransactionID('SK' . $id_ordine); // Identificativo transazione. Es. "34az85ord19"
                                $crypt->setAmount(number_format($totale_ordine, 2, '.', '')); // Importo. Es.: 1256.50
                                //                             $crypt->SetAmount(number_format(0.5, 2, '.', '')); 
                                $crypt->setCurrency("242"); // Codice valuta. 242 = euro

                                if (!$crypt->encrypt()) {
                                    die("Errore: " . $crypt->getErrorCode() . ": " . $crypt->getErrorDescription() . "\n");
                                }

                            ?>

                                <form id="inviadati" action="https://ecomm.sella.it/gestpay/pagam.asp">
                                    <input type="hidden" name="a" value="<?= $crypt->getShopLogin(); ?>" />
                                    <input type="hidden" name="b" value="<?= $crypt->getEncryptedString(); ?>" />
                                    <input type="image" src="<?= BASE_URL; ?>images/pagaadessoconcarta.jpg" />
                                </form>

                            <?php
                            */
                            } else if ($_POST['pay_metod'] == 'Bonifico') {
                                echo $lang['testo_pag_bon'];
                            }

                            ?>

                        </div>
                    </div>
                </div>

                <!--                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pLace-order">
                            <button class="btn-send-message disabled" type="submit" > <?= $lang['acquista']; ?></button>
                        </div>
                    </div>
                </div>-->
                </form>

            </div>
        </div>
        <!-- Checkout Page Area End Here -->
        <!-- Footer Area Start Here -->
        <?php
        include("inc_footer.php");
        ?>
        <!-- Footer Area End Here -->
    </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- jquery-->
    <script src="<?= BASE_URL; ?>js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap js -->
    <script src="<?= BASE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?= BASE_URL; ?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?= BASE_URL; ?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?= BASE_URL; ?>js/wow.min.js" type="text/javascript"></script>
    <!-- Plugins js -->
    <script src="<?= BASE_URL; ?>js/plugins.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="<?= BASE_URL; ?>js/jquery.countdown.min.js" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?= BASE_URL; ?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
    <!-- Select2 Js -->
    <script src="<?= BASE_URL; ?>js/select2.min.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?= BASE_URL; ?>js/main.js" type="text/javascript"></script>

</body>

</html>