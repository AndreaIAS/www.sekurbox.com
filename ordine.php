<?php

include("inc_config.php");


if (!isset($_SESSION['user_site']) || !isset($_REQUEST['val'])) {
    header("Location: index.php");
    die();
    exit();
}

$db->query("SELECT * 
                FROM 
                bag_ordini
                WHERE id='" . $_REQUEST['val'] . "' 
            ");
$ordine = $db->single();

if ($_SESSION['user_site'] != $ordine['id_utente']) {
    header("Location: index.php");
    die();
    exit();
}

$title_it = "Sekurbox.com | Dettaglio Ordine.";
$description_it = "";


$title_en = "Sekurbox.com | Order Details.";
$description_en = "";

include("inc_header.php");
?>

<meta name="robots" content="noindex">
</head>

<body>
    <div class="wrapper-area">

        <?php
        include("inc_menu.php");

        ?>
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?= $lang['dettagli_ordine']; ?></h1>
                            <ul>
                                <li><a href="<?= BASE_URL . $lng; ?>/">Home</a> /</li>
                                <li><?= $lang['dettagli_ordine']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Page Area Start Here -->
        <div class="order-details-page-area" style="padding-top:20px">
            <div class="container">
                <!--                <h2 class="order-details-page-title">Thank You. Your Order Has been Received.</h2> -->

                <ul class="order-details-summery">
                    <li><?= $lang['numero_ordine']; ?>:<span>SK<?= $ordine['id']; ?></span></li>
                    <li><?= $lang['data_ordine']; ?>:<span><?= date("d/m/Y", strtotime($ordine['data'])); ?></span></li>
                    <li><?= $lang['totale']; ?>:<span>&euro; <?= number_format($ordine['totale'], 2, ',', '.'); ?></span></li>
                    <li><?= $lang['pay_metod']; ?>:<span><?= $lang[$ordine['tipo_pagam']]; ?></span></li>
                    <li><?= $lang['sped_metod']; ?>:<span><?= $lang[$ordine['tipo_spedi']]; ?></span></li>
                </ul>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><?= $lang['dettagli_ordine']; ?></h3>
                        <div class="order-details-page-top table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td class="order-details-form-heading"><?= $lang['prodotto']; ?></td>
                                        <td class="order-details-form-heading"><?= $lang['totale']; ?></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $db->query("SELECT * 
                                               FROM 
                                               bag_det_ord
                                               INNER JOIN bag_prodotti ON bag_prodotti.id=bag_det_ord.id_articolo
                                               WHERE id_ordine='" . $_REQUEST['val'] . "' 
                                                ");
                                    $articoli = $db->resultset();
                                    foreach ($articoli as $articolo) {
                                        $totale_articoli = $totale_articoli + ($articolo['prezzo'] * $articolo['qta']);
                                    ?>
                                        <tr>
                                            <td><?php echo $articolo['nome_' . $lng]; ?> X <?php echo $articolo['qta']; ?></td>
                                            <td><?php echo "&euro; " . number_format(($articolo['prezzo'] * $articolo['qta']), 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td><strong> <?= strtoupper($lang['imponibile']); ?></strong></td>
                                        <td><strong>&euro; <?php echo  number_format($totale_articoli, 2, ',', '.'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong> <?= strtoupper($lang['iva']); ?></strong></td>
                                        <td><strong> &euro; <?php echo  number_format(($totale_articoli / 100) * 22, 2, ',', '.'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= $lang['payment_cost']; ?></strong></td>
                                        <td><strong>&euro; <?php echo  number_format($ordine['spese_pag'], 2, ',', '.'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= $lang['shipping_cost']; ?></strong></td>
                                        <td><strong>&euro; <?php echo  number_format($ordine['spese_spe'], 2, ',', '.'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= $lang['totale']; ?></strong></td>
                                        <td><strong>&euro; <?php echo number_format((($totale_articoli / 100) * 22) + $totale_articoli + $ordine['spese_spe'] + $ordine['spese_pag'], 2, ',', '.'); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><?= $lang['indirizzo_spedizione']; ?></h3>
                        <div class="order-details-page-bottom">
                            <ul>
                                <li><strong><?= $lang['nome']; ?>:</strong> <?= $ordine['nome'] . " " . $ordine['cognome']; ?></li>
                                <li><strong><?= $lang['indirizzo']; ?>:</strong> <?= $ordine['indirizzo']; ?></li>
                                <li><strong><?= $lang['citta']; ?>:</strong> <?= $ordine['citta']; ?></li>
                                <li><strong><?= $lang['provincia']; ?>:</strong> <?= $ordine['provincia']; ?></li>
                                <li><strong><?= $lang['cap']; ?>:</strong> <?= $ordine['cap']; ?></li>
                                <li><strong>Mail:</strong> <?= $_SESSION['email']; ?></li>
                                <li><strong><?= $lang['telefono']; ?>:</strong> <?= $ordine['telefono']; ?></li>
                                <li><strong><?= $lang['cellp']; ?>:</strong> <?= $ordine['cellulare']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order Details Page Area End Here -->



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
    <!-- Custom Js -->
    <script src="<?= BASE_URL; ?>js/main.js" type="text/javascript"></script>
</body>

</html>