<?php

include("inc_config.php");


$title_it = "Elenco prodotti | Sekurbox.com";
$title_en = "Product list | Sekurbox.com";
$description_it = "I migliori prodotti per domotica,sicurezza e TVCC ai migliori prezzi del mercato";
$description_en = "Best product for domotic,security and TVCC at best price";

include("inc_header.php");
?>

<!-- jPList Core -->
<script src="<?= BASE_URL; ?>jplist/jplist.core.min.js"></script>
<link href="<?= BASE_URL; ?>jplist/jplist.core.min.css" rel="stylesheet" type="text/css" />

<!-- jPList Sort Bundle -->
<script src="<?= BASE_URL; ?>jplist/jplist.sort-bundle.min.js"></script>

<!-- jPList filter dropdown -->
<script src="<?= BASE_URL; ?>jplist/jplist.filter-dropdown-bundle.min.js"></script>

<!-- Textbox Filter Control -->
<script src="<?= BASE_URL; ?>jplist/jplist.textbox-filter.min.js"></script>
<link href="<?= BASE_URL; ?>jplist/jplist.textbox-filter.min.css" rel="stylesheet" type="text/css" />

<!-- jQuery UI  -->
<link href="<?= BASE_URL; ?>jplist/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="<?= BASE_URL; ?>jplist/jquery-ui.js"></script>
<!-- jQuery UI Bundle -->
<link href="<?= BASE_URL; ?>jplist/jplist.jquery-ui-bundle.min.css" rel="stylesheet" type="text/css" />
<script src="<?= BASE_URL; ?>jplist/jplist.jquery-ui-bundle.min.js"></script>

<!-- Animation  -->
<script src="<?= BASE_URL; ?>jplist/jplist.ext-animation.min.js"></script>


<!-- Initialization -->
<script>
    $('document').ready(function() {

        /**
         * user defined functions
         */
        jQuery.fn.jplist.settings = {

            pricesSlider: function($slider, $prev, $next) {

                    $slider.slider({
                        min: 0,
                        max: 1000,
                        range: true,
                        values: [0, 1000],
                        slide: function(event, ui) {
                            $prev.text('€' + ui.values[0]);
                            $next.text('€' + ui.values[1]);
                        }
                    });
                }

                /**
                 * PRICES: jquery ui set values
                 */
                ,
            pricesValues: function($slider, $prev, $next) {

                $prev.text('€ ' + $slider.slider('values', 0));
                $next.text('€ ' + $slider.slider('values', 1));
            }


        };

        //check all jPList javascript options here
        $('#jplist-main').jplist({
            itemsBox: '.include-item',
            itemPath: '.list-item',
            panelPath: '.jplist-panel',
            effect: 'fade',
            duration: 300, //animation duration
            fps: 24 //frames per second value
        });

    });
</script>

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
                            <h1><?= $lang['elenco_prodotti']; ?></h1>
                            <ul>
                                <li><a href="<?= BASE_URL . $lng; ?>/">Home</a> /</li>
                                <li><?= $lang['elenco_prodotti']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Shop Page Area Start Here -->
        <div class="shop-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="sidebar hidden-after-desk">
                            <h2 class="title-sidebar"><?= $lang['categorie_tutte']; ?></h2>

                            <div class="category-menu-area sidebar-section-margin" id="category-menu-area">
                                <ul>

                                    <?php

                                    $db->query("SELECT *
                                                FROM
                                                bag_categorie
                                                ORDER BY posizione 
                                                ");

                                    $resultc =  $db->resultSet();
                                    foreach ($resultc as $listc) {
                                        $db->query("SELECT *
                                                    FROM
                                                    bag_scat
                                                    WHERE id_categoria='" . $listc['id'] . "'
                                                    ORDER BY posizione 
                                                   ");

                                        $resultsc =  $db->resultSet();
                                    ?>

                                        <li>

                                            <a href="<?= BASE_URL . $lng; ?>/c_<?= $listc['id']; ?>/<?= seo_url($listc['nome_' . $lng]); ?>"
                                                <?php if (isset($categoria)  and $categoria == $listc['id']) {
                                                    echo ' style="color:#009392 !important;" ';
                                                } ?>>
                                                <i class="fa  fa-<?= $listc['font_awesome_code']; ?>" style='line-height: 12px;'></i> <?= ucfirst(strtolower($listc['nome_' . $lng])); ?>
                                                <?php if ($db->rowCount($resultsc) > 0) { ?>
                                                    <span><i class="flaticon-next"></i></span>
                                                <?php } ?>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php
                                                foreach ($resultsc as $listsc) { ?>
                                                    <li>
                                                        <a <?php if (isset($scat)  and $scat == $listsc['id']) {
                                                                echo ' style="color:#009392 !important;" ';
                                                            } ?> href="<?= BASE_URL . $lng; ?>/s_<?= $listsc['id']; ?>/<?= seo_url($listsc['nome_' . $lng]); ?>"><?= ucfirst(strtolower($listsc['nome_' . $lng])); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>

                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <h2 class="title-sidebar"><?= $lang['offerte']; ?></h2>
                            <div class="best-products sidebar-section-margin">

                                <?php

                                $db->query("SELECT bag_prodotti.*,
                                                bag_prodotti.id AS id_prodotto,
                                                bag_scat.nome_" . $lng . " AS nome_scat, 
                                                bag_marche.nome_" . $lng . " AS nome_marca,
                                                bag_marche.immagine AS img_marca    
                                                FROM
                                                bag_prodotti,bag_scat,bag_marche
                                                WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                                AND bag_prodotti.id_marca=bag_marche.id
                                                AND bag_prodotti.offerta='s'
                                                ORDER by posizione
                                                LIMIT 0,4
                                            ");
                                $recordleft = $db->resultset();
                                foreach ($recordleft as $list) {
                                    //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                    if (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'installatore') {
                                        $text_prezzo =   '<span >&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</span> &euro;';
                                        $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_installatore']), 2, '.', '');
                                    } elseif (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'rivenditore') {
                                        $text_prezzo =   '<span >&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</span> ';
                                        $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_rivenditore']), 2, '.', '');
                                    } else {
                                        $text_prezzo = "&euro; " . number_format($list['prezzo'], 2, '.', '') . " </span>";
                                    }
                                    $text_prezzo .= " + IVA";
                                ?>
                                    <div class="media">
                                        <a href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>" class="pull-left">
                                            <img alt="<?= $list['nome_' . $lng]; ?>" src="<?= $phpThumbBase; ?>?src=upload/prodotti/<?= $list['immagine']; ?>&h=107&w=107&far=1&bg=ffffff" class="img-responsive">
                                        </a>
                                        <div class="media-body">
                                            <h3 class="media-heading"><a href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>"><?= substr(ucfirst(strtolower($list['nome_' . $lng])), 0, 30); ?>..</a></h3>
                                            <p>
                                                <?php echo $text_prezzo; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <br /><br />
                            <h2 class="title-sidebar"><?= $lang['ultarrivi']; ?></h2>
                            <div class="best-products sidebar-section-margin">

                                <?php
                                $db->query("SELECT bag_prodotti.*,
                                                bag_prodotti.id AS id_prodotto,
                                                bag_scat.nome_" . $lng . " AS nome_scat, 
                                                bag_marche.nome_" . $lng . " AS nome_marca,
                                                bag_marche.immagine AS img_marca    
                                                FROM
                                                bag_prodotti,bag_scat,bag_marche
                                                WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                                AND bag_prodotti.id_marca=bag_marche.id
                                                AND bag_prodotti.ultimo_arrivo='s'
                                                ORDER by posizione
                                                LIMIT 0,4
                                            ");
                                $recordleft = $db->resultset();

                                foreach ($recordleft as $list) {
                                    //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                    if (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'installatore') {
                                        $text_prezzo =   '<span >&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</span> &euro;';
                                        $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_installatore']), 2, '.', '');
                                    } elseif (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'rivenditore') {
                                        $text_prezzo =   '<span >&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</span> &euro;';
                                        $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_rivenditore']), 2, '.', '');
                                    } else {
                                        $text_prezzo = "&euro; " . number_format($list['prezzo'], 2, '.', '');
                                    }
                                    $text_prezzo .= " + IVA";
                                ?>

                                    <div class="media">
                                        <a href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>" class="pull-left">
                                            <img alt="<?= $list['nome_' . $lng]; ?>" src="<?= $phpThumbBase; ?>?src=upload/prodotti/<?= $list['immagine']; ?>&h=107&w=107&far=1&bg=ffffff" class="img-responsive">
                                        </a>
                                        <div class="media-body">
                                            <h3 class="media-heading"><a href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>"><?= substr(ucfirst(strtolower($list['nome_' . $lng])), 0, 30); ?>..</a></h3>
                                            <p>
                                                <?php echo $text_prezzo; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--
                            <h2 class="title-sidebar">FILTER BY PRICE</h2>
                            <div id="price-range-wrapper" class="price-range-wrapper">
                                <div id="price-range-filter"></div>
                                <div class="price-range-select">
                                    <div class="price-range" id="price-range-min"></div>
                                    <div class="price-range" id="price-range-max"></div>
                                </div>
                                <button class="btn-services-shop-now" type="submit" value="Login">Filter</button>
                            </div>-->
                            <!--
                            <h2 class="title-sidebar">Product Tags</h2>
                            <div class="product-tags sidebar-section-margin">
                                <ul>
                                    <li><a href="#">Fashion</a></li>
                                    <li><a href="#">Glamour</a></li>
                                    <li><a href="#">Shoes</a></li>
                                    <li><a href="#">Dress</a></li>
                                    <li><a href="#">Kid’s</a></li>
                                    <li><a href="#">Accessories</a></li>
                                    <li><a href="#">Mobile</a></li>
                                </ul>
                            </div>-->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="jplist-main">
                        <div class="row jplist-panel">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="inner-shop-top-left">

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                        <div><?= $lang['ordina']; ?></div>
                                        <div class="jplist-drop-down"
                                            data-control-type="sort-drop-down"
                                            data-control-name="sort"
                                            data-control-action="sort"
                                            data-datetime-format="{month}/{day}/{year}">
                                            <!--                                        <button class="btn sorting-btn dropdown-toggle" data-path="default" type="button" data-toggle="dropdown">Default Sorting<span class="caret"></span>
                                        </button>-->
                                            <ul class="dropdown-menu" style="width:180px;">
                                                <li><span data-path=".title" data-order="asc" data-type="text" data-default="true"><?= $lang['nome_az']; ?></span></li>
                                                <li><span data-path=".title" data-order="desc" data-type="text"><?= $lang['nome_za']; ?></span></li>
                                                <li><span data-path=".price" data-order="asc" data-type="number"><?= $lang['prezzo_cre']; ?></span></li>
                                                <li><span data-path=".price" data-order="desc" data-type="number"><?= $lang['prezzo_des']; ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                        <div><?= $lang['categorie_tutte']; ?></div>
                                        <div style="font-size:12px;"
                                            class="jplist-drop-down"
                                            data-control-type="filter-drop-down"
                                            data-control-name="category-filter1"
                                            data-control-action="filter">
                                            <ul>
                                                <li><span data-path="default"><?= $lang['tutte']; ?></span></li>
                                                <?php
                                                $db->query("SELECT *
                                                                FROM
                                                                bag_categorie
                                                                ORDER BY posizione
                                                            ");

                                                $resultc =  $db->resultSet();
                                                foreach ($resultc as $listc) {
                                                ?>
                                                    <li><span data-path=".c<?= $listc['id']; ?>"
                                                            <?php if (isset($_POST['id_categoria_search']) and $_POST['id_categoria_search'] == $listc['id']) echo "data-default='true'"; ?>><?= $listc['nome_' . $lng]; ?></span></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Filter DropDown Control -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                        <div><?= $lang['marca']; ?></div>
                                        <div
                                            class="jplist-drop-down"
                                            data-control-type="filter-drop-down"
                                            data-control-name="category-filter"
                                            data-control-action="filter">
                                            <ul>
                                                <li><span data-path="default"><?= $lang['tutte']; ?></span></li>
                                                <?php

                                                $db->query("SELECT bag_marche.*
                                                                FROM
                                                                bag_marche
                                                                ORDER by bag_marche.nome_" . $lng . "
                                                            ");
                                                $recordleft = $db->resultset();
                                                foreach ($recordleft as $listm) { ?>
                                                    <li><span data-path=".m<?= $listm['id']; ?>"><?= $listm['nome_' . $lng]; ?></span></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- prices range slider -->
                                        <!-- pricesSlider and priesValues are user function defined in jQuery.fn.jplist.settings -->

                                        <div><?= $lang['prezzo']; ?></div>
                                        <div class="jplist-range-slider"
                                            data-control-type="range-slider"
                                            data-control-name="range-slider-prices"
                                            data-control-action="filter"
                                            data-path=".price"
                                            data-slider-func="pricesSlider"
                                            data-setvalues-func="pricesValues">

                                            <div class="value-left" data-type="prev-value"></div>
                                            <div class="ui-slider" data-type="ui-slider"></div>
                                            <div class="value-right" data-type="next-value"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div><?= $lang['cerca_all']; ?></div>
                                        <i class="fa fa-search  jplist-icon"></i>
                                        <input type="text" data-path=".title, .descr" value="<?= $_POST['testo_ricerca']; ?>" class="jplist-no-right-border" data-control-type="textbox" data-control-name="title-filter" data-control-action="filter">
                                        <i class="fa fa-times-circle jplist-clear" data-type="clear"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row inner-section-space-top include-item">
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <!-- List Style -->
                                <div role="tabpanel" class="tab-pane active clear products-container" id="list-view">

                                    <?php

                                    $db->query("SELECT bag_prodotti.*,
                                                    bag_prodotti.id AS id_prodotto,
                                                    bag_scat.nome_" . $lng . " AS nome_scat, 
                                                    bag_scat.id_categoria AS id_cat,     
                                                    bag_marche.nome_" . $lng . " AS nome_marca,
                                                    bag_marche.id  AS id_marca,    
                                                    bag_marche.immagine AS img_marca    
                                                    FROM
                                                    bag_prodotti,bag_scat,bag_marche
                                                    WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                                    AND bag_prodotti.id_marca=bag_marche.id
                                                    ORDER by posizione
                                                ");
                                    $recordleft = $db->resultset();
                                    foreach ($recordleft as $list) {

                                        //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                        if (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'installatore') {
                                            $text_prezzo =   '<span class="price" style="display:inline;"><del>&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</del></span> &nbsp; &nbsp; &euro;';
                                            $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_installatore']), 2, '.', '');
                                        } elseif (isset($_SESSION['tipologia']) && $_SESSION['tipologia'] == 'rivenditore') {
                                            $text_prezzo =   '<span class="price" style="display:inline;"><del>&euro; ' . number_format($list['prezzo'], 2, '.', '') . '</del></span> &nbsp; $nbsp; &euro;';
                                            $text_prezzo .= number_format($list['prezzo'] - ($list['prezzo'] / 100 * $list['sconto_rivenditore']), 2, '.', '');
                                        } else {
                                            $text_prezzo = "<span class='price' style='display:inline;'>&euro; " . number_format($list['prezzo'], 2, '.', '') . " </span>";
                                        }
                                        $text_prezzo .= " + IVA";
                                    ?>

                                        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12 list-item">
                                            <div class="product-box2">
                                                <div class="media" style="border: solid 1px #dedede;">
                                                    <a class="pull-left" href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>">
                                                        <img class="img-responsive" alt="<?= $list['nome_' . $lng]; ?>" src="<?= $phpThumbBase; ?>?src=upload/prodotti/<?= $list['immagine']; ?>&h=294&w=273&far=1&bg=ffffff">
                                                    </a>
                                                    <input type="hidden" name="categoria" class="c<?= $list['id_cat']; ?>" value="<?= $_POST['id_categoria_search']; ?>" />
                                                    <div class="media-body" style="line-height:20px;">
                                                        <div class="product-box2-content">
                                                            <h3><a href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>" class="title"><?= ucfirst(strtolower($list['nome_' . $lng])); ?></a></h3>
                                                            <span>
                                                                <?php echo $text_prezzo; ?>
                                                            </span>

                                                            <?php if ($list['quantita'] > 0) { ?>
                                                                <span style="color:green;display:inline"><?= $lang['disponibile']; ?></span>
                                                            <?php } else { ?>
                                                                <span style="color:red;display:inline"><?= $lang['non_disponibile']; ?></span>
                                                            <?php } ?>
                                                            <div style="clear:both"></div>
                                                            <br />
                                                            <div class="descr"><?= ucfirst(strtolower(trim($list['descrizione_' . $lng]))); ?></div>
                                                        </div>
                                                        <div class="product-details-content">
                                                            <p style="margin-bottom:5px;">
                                                                <span style="display:inline"><b><?= $lang['marca']; ?>:</b></span>
                                                                <img class="m<?= $list['id_marca']; ?>" style="width:120px;" src="<?= BASE_URL; ?>upload/marche/<?= $list['img_marca']; ?>" />
                                                            </p>
                                                            <p style="margin-bottom:5px;">
                                                                <span style="display:inline"><b><?= $lang['codice']; ?>:</b></span>
                                                                <?= $list['codice']; ?>
                                                            </p>
                                                            <p style="margin-bottom:5px;">

                                                            </p>
                                                            <p style="margin-bottom:5px;">
                                                                <span style="display:inline"><b><?= $lang['categoria']; ?>:</b></span>
                                                                <?= ucfirst(strtolower($list['nome_scat'])); ?>
                                                            </p>
                                                        </div>
                                                        <ul class="product-box2-cart">
                                                            <?php if ($list['quantita'] > 0) { ?>
                                                                <li><a href="javascript:void(null)" class='add_carrello' alert-id="<?= $list['id_prodotto']; ?>" for="<?= $list['id_prodotto']; ?>"><?= $lang['add_carrello']; ?></a></li>
                                                            <?php } ?>
                                                            <!--                                                        <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                                            <li><a href="<?= BASE_URL . $lng; ?>/p_<?= $list['id_prodotto']; ?>/<?= seo_url($list['nome_' . $lng]); ?>"><?= $lang['dettagli']; ?></a></li>
                                                        </ul>
                                                        <br />
                                                        <div class="alert alert-success  fade in alert-<?= $list['id_prodotto']; ?>"
                                                            style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                                                            <strong>Prodotto inserito nel carrello!</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <ul class="mypagination">
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                </ul>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Page Area End Here -->

        <?php
        include("inc_footer.php");
        ?>
    </div>

    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- jquery-->
    <!--    <script src="js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>-->
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
    <!-- Actual Js -->
    <script src="<?= BASE_URL; ?>js/jquery.actual.min.js" type="text/javascript"></script>
    <!-- Nouislider Js -->
    <script src="<?= BASE_URL; ?>vendor/noUiSlider/nouislider.min.js" type="text/javascript"></script>
    <!-- wNumb Js -->
    <script src="<?= BASE_URL; ?>js/wNumb.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?= BASE_URL; ?>js/main.js" type="text/javascript"></script>

</body>

</html>