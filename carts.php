<?php

include("inc_config.php");


$title_it="Sekurbox - Carrello";
$title_en="Sekurbox - Cart";
$description_it="";
$description_en="";


if(isset($_POST['action']) ) {

    switch ($_POST['action']) {

        case "remove":
         $cart->del_item($_POST['item']);
         break;
        case "addqty":
         $cart->edit_item($_POST['item'],$_POST['qty']+1);
         break;  
        case "removeqty":
         if($_POST['qty']>1){
          $cart->edit_item($_POST['item'],$_POST['qty']-1);
         }else{
          $cart->del_item($_POST['item']);    
         }
         break;
    }   
       
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
                            <h1><?=ucfirst(strtolower($lang['carrello']))?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><?=ucfirst(strtolower($lang['carrello']));?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Cart Page Area Start Here -->
        <div class="cart-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="cart-page-top table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td class="cart-form-heading"></td>
                                        <td class="cart-form-heading"><?=$lang['nome'];?></td>
                                        <td class="cart-form-heading"><?=$lang['prezzo'];?></td>
                                        <td class="cart-form-heading"><?=$lang['quantita'];?></td>
                                        <td class="cart-form-heading"><?=$lang['totale'];?></td>
                                        <td class="cart-form-heading"></td>
                                    </tr>
                                </thead>
                                <tbody id="quantity-holder">
                                    
                                    <?php  
                                        foreach($cart->get_contents() as $item) {     
                                            $totalearticolo=($item['price']*$item['qty']);
                                        ?>
                                    <tr>
                                        <td class="cart-img-holder">
                                            <?php if(trim($item['info']['image'])=='Invalid file type.') $immagine="noimage.jpg" ; else $immagine=$item['info']['image']; ?>
                                            <a href="#"><img src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$immagine;?>&h=104&w=116&far=1&bg=ffffff" alt="cart" class="img-responsive"></a>
                                        </td>
                                        <td>
                                            <h3><a href="#"><?=ucfirst(strtolower($item['info']['nome']));?></a></h3>
                                        </td>
                                        <td class="amount"><?=number_format($item['price'],2,',','.');?> &euro;</td>
                                        <td class="quantity">
                                            
                                               <form method="POST" id="add_<?=$item['id'];?>" name="add_<?=$item['id'];?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                               <input type="hidden" name="item" value="<?=$item['id'] ;?>" />
                                               <input type="hidden" name="action" value="addqty" />
                                                <input type="hidden" name="qty" value="<?=$item['qty'];?>" />
                                                </form>
                                            
                                                <form method="POST" id="sub_<?=$item['id'];?>" name="sub_<?=$item['id'];?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                                <input type="hidden" name="item" value="<?=$item['id'] ;?>" />
                                                <input type="hidden" name="action" value="removeqty" />
                                                <input type="hidden" name="qty" value="<?=$item['qty'];?>" />
                                                </form>
                                            
                                                <form method="POST" id="red_<?=$item['id'];?>" name="red_<?=$item['id'];?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                                <input type="hidden" name="item" value="<?=$item['id'];?>" />
                                                <input type="hidden" name="action" value="remove" />
                                                </form>
                                            
                                            <div class="input-group quantity-holder">
                                                <input type="text" name='quantity' class="form-control quantity-input" id="quantity_<?=$item['id'];?>" value="<?=$item['qty'];?>" >
                                                <div class="input-group-btn-vertical">
                                                    <button class="btn btn-default quantity-plus cartplus" for="<?=$item['id'];?>" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                    <button class="btn btn-default quantity-minus cartminus" for="<?=$item['id'];?>" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="amount"><?=number_format($totalearticolo,2,',','.');?> &euro;</td>
                                        <td class="dismiss"><a href="javascript:void(null)" onclick="document.red_<?=$item['id'];?>.submit();"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                    </tr>
                                        <?php } ?> 
                             
                                </tbody>
                            </table>
<!--                            <div class="update-button">
                                <button class="btn-apply-coupon disabled" type="submit" value="Login">Update Cart</button>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
<!--                        <div class="cart-page-bottom-left">
                            <h2>Coupon</h2>
                            <form method="post">
                                <input type="text" id="coupon" name="coupon" placeholder="Enter your coupon code if you have one">
                                <button value="Coupon" type="submit" class="btn-apply-coupon disabled">Apply Coupon</button>
                            </form>
                        </div>-->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="cart-page-bottom-right">
                            <h2><?=$lang['totale_carrello'];?></h2>
                            <h3><?=$lang['imponibile'];?><span><?=number_format($totalecarr,2,',','.');?> &euro;</span></h3>
                             <h3><?=$lang['iva'];?><span><?=number_format(($totalecarr/100)*22,2,',','.');?> &euro;</span></h3>
                            <h3><?=$lang['totale'];?><span><?=number_format((($totalecarr/100)*22)+$totalecarr,2,',','.');?> &euro;</span></h3>
                           
                            <?php if($totalecarr > 0){ ?>
                            <div class="proceed-button">
                                <a href="<?=BASE_URL;?>carrello1.php" class="btn-apply-coupon disabled" rel="nofollow"  ><?=$lang['cassa'];?></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Page Area End Here -->
        <!-- Footer Area Start Here -->
                 
    <?php  
    include("inc_footer.php");  
     ?> 
        <!-- Footer Area End Here -->
    </div>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <!-- Bootstrap js -->
    <script src="<?=BASE_URL;?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?=BASE_URL;?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?=BASE_URL;?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?=BASE_URL;?>js/wow.min.js" type="text/javascript"></script>
    <!-- Plugins js -->
    <script src="<?=BASE_URL;?>js/plugins.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="<?=BASE_URL;?>js/jquery.countdown.min.js" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?=BASE_URL;?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
</body>

</html>
