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

if (isset($dbOrdine['pagato']) && $dbOrdine['pagato'] === 's') {
    if (isset($_SESSION['user_site']) && is_object($cart)) {
        $cart->empty_cart();
    }
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
                    <h1>Esito pagamento</h1>
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
                    <?php if (isset($dbOrdine['pagato']) && $dbOrdine['pagato'] === 's') { ?>
                        Pagamento ricevuto. Grazie!<br />
                        Ordine numero SK<?= (int)$idOrdine; ?>
                    <?php } else { ?>
                        Pagamento non confermato.<br />
                        Ordine numero SK<?= (int)$idOrdine; ?>
                    <?php } ?>
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
