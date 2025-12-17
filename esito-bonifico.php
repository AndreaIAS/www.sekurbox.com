<?php

include("inc_config.php");

$idOrdine = isset($_GET['id_ordine']) ? (int)$_GET['id_ordine'] : 0;
if ($idOrdine <= 0) {
    header("Location: " . BASE_URL . $lng . "/");
    exit();
}

$db->query("SELECT * FROM bag_ordini WHERE id=:id");
$dbOrdine = $db->single(array('id' => $idOrdine));
if (!$dbOrdine) {
    header("Location: " . BASE_URL . $lng . "/");
    exit();
}

// Svuota carrello solo se l'ordine appartiene all'utente loggato
if (isset($_SESSION['user_site']) && $dbOrdine['id_utente'] == $_SESSION['user_site'] && is_object($cart)) {
    $cart->empty_cart();
}

include("inc_header.php");
?>
<meta name="robots" content="noindex">
</head>
<body>
<div class="wrapper-area">
<?php include("inc_menu.php"); ?>
<div class="inner-page-banner-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcrumb-area">
                    <h1>Istruzioni per il bonifico</h1>
                    <ul>
                        <li><a href="<?= BASE_URL . $lng; ?>/">Home</a> /</li>
                        <li>Bonifico bancario</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="checkout-page-area" style="padding-top:30px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="order-sheet">
                    <h3>Ordine numero SK<?= (int)$idOrdine; ?> registrato correttamente</h3>
                    <br />
                    <p>Per completare l'ordine, effettua un bonifico bancario di <strong>€ <?= number_format($dbOrdine['totale'], 2, ',', '.'); ?></strong> utilizzando i seguenti dati:</p>
                    <br />
                    <?php if (isset($lang['testo_pag_bon'])) { ?>
                        <?= $lang['testo_pag_bon']; ?>
                    <?php } else { ?>
                        <p><strong>Beneficiario:</strong> Sekurbox S.r.l.</p>
                        <p><strong>IBAN:</strong> IT00X0000000000000000000000</p>
                        <p><strong>Causale:</strong> Ordine SK<?= (int)$idOrdine; ?></p>
                    <?php } ?>
                    <br />
                    <p>Una volta ricevuto il bonifico, procederemo con la spedizione e riceverai una email di conferma.</p>
                    <br />
                    <a href="<?= BASE_URL . $lng; ?>/ordini.php" class="btn btn-13 text-uppercase">I miei ordini</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("inc_footer.php"); ?>
</div>
<script src="<?= BASE_URL; ?>js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/owl.carousel.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/wow.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/plugins.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/jquery.countdown.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/select2.min.js" type="text/javascript"></script>
<script src="<?= BASE_URL; ?>js/main.js" type="text/javascript"></script>
</body>
</html>
