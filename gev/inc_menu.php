	<!-- LOADING -->
<!--	<div class="loading-container" id="loading">
		<div class="loading-inner">
			<span class="loading-1"></span>
			<span class="loading-2"></span>
			<span class="loading-3"></span>
		</div>
	</div>-->
	<!-- END LOADING -->

	<div class="wrap-page">

		<!-- HEADER -->
		<header class="header _3">
			<div class="container">

				<!-- HEADER CONTENT -->
				<div class="header-cn clearfix">

					<!-- TOP MENU -->
					<div class="top-menu">
                                                <?php if(isset($_SESSION['user'])) { ?>
                                                <div style="float:left;margin:-2px 0px 0px 22px;">Benvenuto <?=$_SESSION['nome'];?></div>
                                                <?php } else { ?>
                                                <div id="logstart" style="float:left;margin:-2px 0px 0px 22px;">&nbsp;&nbsp;
                                                    <a href="<?=BASE_URL;?>registrati.php">Registrati</a>&nbsp;&nbsp;
                                                    <a href="<?=BASE_URL;?>registrati.php">Login</a>
                                                </div>
                                                <?php }  ?>
						<span class="bar-icon" id="bar-icon"></span>


						<div class="box">

                                                <?php if(isset($_SESSION['user'])) { ?>
							<ul>
								<li><a href="<?=BASE_URL;?>modificadati.php">Modifica dati personali</a></li>
								<li><a href="<?=BASE_URL;?>modificapwd.php">Modifica password</a></li>
								<li><a href="<?=BASE_URL;?>ordini.php">I tuoi ordini</a></li>
								<li><a href="<?=BASE_URL;?>index.php?logout">Logout</a></li>

							</ul>
                                               <?php } else {?>

                                                      <ul>
                                                          <li><a href="<?=BASE_URL;?>registrati.php">Registrati</a></li>
						          <li><a href="<?=BASE_URL;?>registrati.php">Login</a></li>
						      </ul>

                                               <?php } ?>


<!--							<h6>Your Language</h6>
							<div class="flags">
								<a href="#" class="current"><img src="<?=BASE_URL;?>images/flags/icon-1.jpg" alt=""></a>
								<a href="#"><img src="<?=BASE_URL;?>images/flags/icon-2.jpg" alt=""></a>
								<a href="#"><img src="<?=BASE_URL;?>images/flags/icon-3.jpg" alt=""></a>
								<a href="#"><img src="<?=BASE_URL;?>images/flags/icon-4.jpg" alt=""></a>
							</div>-->
						</div>
					</div>
					<!-- END TOP MENU -->

					<!-- MINI CART -->
					<div class="mini-cart ">

						<!-- HEADER CART -->
						<div class="cart-head" id="cart-head">
							<label>Il mio carrello <span>( <?php

                                                            $tot=0;
                                                            if($cart->itemcount > 0) {
                                                             foreach($cart->get_contents() as $item) {$tot=$tot+$item['qty'];} }
                                                            //PRENDO IL TOTALE CARELLO
                                                            foreach($cart->get_contents() as $item) {$totalecarr=$totalecarr+($item['price']*$item['qty']); }
                                                            ?>

                                                            <?=$tot;?>)</span></label>
							<p><span>Totale:</span> <?=number_format((($totalecarr/100)*22)+$totalecarr,2,',','.');?> <small>(<?=$tot;?>)</small></p>
							<span class="cart-count"><?=$tot;?></span>
						</div>
						<!-- END HEADER CART -->

						<!-- CART CONTENT -->
						<div class="cart-cn">
							<ul class="cart-list">
                                                             <?php   foreach($cart->get_contents() as $item) {

                                                                $totalearticolo=($item['price']*$item['qty']);
                                                             ?>
								<li>
									<a href="#" class="img">
                                                                           <?php if(trim($item['info']['image'])=='Invalid file type.') $immagine="noimage.jpg" ; else $immagine=$item['info']['image']; ?>
										<img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$immagine;?>&h=79&w=60&far=1&bg=ffffff" alt="">
									</a>
									<div class="text">
										<div class="name">
										<a href="<?=$item['info']['url'];?>"><?=$item['info']['nome'];?></a>
										</div>
                                                                                <div class="name">
										 Quantità: 	<?=$item['qty'];?>
										</div>
                                                                                  <form method="POST" name="rem_<?=$item['id'];?>" action="<?=BASE_URL;?>carts" style="margin:0px;padding:0px">
                                                                                  <input type="hidden" name="id_item" value="<?=$item['id'];?>" />
                                                                                  <input type="hidden" name="action" value="remove" />
                                                                                  </form>
										<span class="price"><?=number_format($totalearticolo,2,',','.');?> &euro;</span>
										<a href="javascript:void(null)" onclick="document.rem_<?= $item['id'] ;?>.submit();" class="delete"><img src="<?=BASE_URL;?>images/icon-delete.png" alt=""></a>
									</div>
								</li>
                                                             <?php } ?>

							</ul>

							<p class="cart-total">Totale imponibile: <span><?=number_format($totalecarr,2,',','.');?> &euro;</span> </p>
                                                        <p class="cart-total">Totale iva: <span><?=number_format(($totalecarr/100)*22,2,',','.');?> &euro;</span> </p>
                                                        <p class="cart-total">Totale carrello: <span><?=number_format((($totalecarr/100)*22)+$totalecarr,2,',','.');?> &euro;</span></p>

							<div class="cart-bt">

								<a href="<?=BASE_URL;?>carts" class="btn btn-4 text-uppercase">Carrello</a>
                                                              <?php if($_SESSION['nazione']==1) { ?>
								<a href="<?=BASE_URL;?>carrello1.php" class="btn btn-4 text-uppercase">Acquista</a>
                                                                 <?php } ?>
							</div>
						</div>
						<!-- END CART CONTENT -->

					</div>
					<!-- END MINI CART -->

					<!-- SEARCH -->
					<div class="search-h">
						<div class="form" style="width: 200px;padding-right: 45px;visibility: visible;border-color: #e5e5e5;" itemscope itemtype="http://schema.org/WebSite">
    				<link itemprop="url" href="http://www.gevenit.com/"/>
							<form action="<?=BASE_URL;?>cerca" method="GET" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
								<meta itemprop="target" content="http://www.gevenit.com/cerca?text_search={text_search}"/>
								<input itemprop="query-input" type="text" name="text_search"  class="input-text" placeholder="Cerca nel sito...">
								<button class="search-btn" type="submit">Submit</button>
								<button class="icon-search" id="icon-search" type="submit"></button>
							</form>
						</div>
						<!--<span class="icon-search" id="icon-search"></span>-->
					</div>
					<!-- END SEARCH -->

					<!-- LOGO -->
					<div class="logo">
					    <a href="<?=BASE_URL;?>index.php"><img src="<?=BASE_URL;?>images/logo_web1.jpg" alt="Gevenit" title="Gevenit"></a>
					</div>
					<!-- END LOGO -->

					<!-- MENU BAR -->
					<div id="menu-bar" class="menu-bar ">
						<span class="one"></span>
						<span class="two"></span>
						<span class="three"></span>
					</div>
					<!-- END MENU BAR -->

					<div class="clear"></div>

					<!-- NAVIGATION -->
					<nav class="navigation ">
						<ul class="menu">

							<li class="menu-parent <?php if($pagename=='' OR $pagename=='index.php') echo ' current-menu-parent';?>" >

								<a href="<?=BASE_URL;?>index.php">Home</a>
<!--
								<ul class="sub-menu">
									<li><a href="index-2.html">Home V1</a></li>
									<li><a href="index-3.html">Home V2</a></li>
									<li><a href="index-4.html">Home V3</a></li>
								</ul>-->

							</li>

							<li class="megamenu col-5 menu-parent  <?php if( $pagename=='azienda.php') echo ' current-menu-parent';?>">

								<a href="<?=BASE_URL;?>azienda-pulizia-civile-industriale.php">Azienda</a>

<!--								<ul class="sub-menu">

									<li>
										<a href="product-grid-1.html">Product grid</a>
										<ul>
											<li><a href="product-grid-1.html">Product grid 1</a></li>
											<li><a href="product-grid-2.html">Product grid 2</a></li>
											<li><a href="product-grid-3.html">Product grid 3</a></li>
											<li class="current-menu-item"><a href="product-grid-4.html">Product grid 4</a></li>
										</ul>
									</li>

									<li>
										<a href="product-list-1.html">Product list</a>
										<ul>
											<li><a href="product-list-1.html">Product list 1</a></li>
											<li><a href="product-list-2.html">Product list 2</a></li>
											<li><a href="product-list-3.html">Product list 3</a></li>
										</ul>
									</li>

									<li>
										<a href="portfolio-1.html">Portfolio</a>
										<ul>
											<li><a href="portfolio-1.html">Portfolio 1</a></li>
											<li><a href="portfolio-2.html">Portfolio 2</a></li>
											<li><a href="portfolio-3.html">Portfolio 3</a></li>
										</ul>
									</li>

									<li>
										<a href="portfolio-1.html">Detail</a>
										<ul>
											<li><a href="portfolio-detail.html">Portfolio detail</a></li>
											<li><a href="product-detail-1.html">Product detail 1</a></li>
											<li><a href="product-detail-2.html">Product detail 2</a></li>
											<li><a href="product-detail-3.html">Product detail 3</a></li>
										</ul>
									</li>

									<li>
										<a href="#">Shop</a>
										<ul>
											<li><a href="shop-cart.html">Cart</a></li>
											<li><a href="check-out.html">Check out</a></li>
											<li><a href="login-register.html">Login / register</a></li>
											<li><a href="lookbook.html">Lookbook</a></li>
											<li><a href="page-404.html">Page 404</a></li>
											<li><a href="element.html">Element</a></li>
										</ul>
									</li>
								</ul>-->

							</li>

							<li class="megamenu col-5 menu-parent <?php if( $pagename=='servizi.php') echo ' current-menu-parent';?>">

								<a href="<?=BASE_URL;?>servizi-pulizia-industriale-professionale.php">Servizi</a>

<!--								<ul class="sub-menu bg-r bg-3">
									<li>
										<a href="#">New Arrivals</a>
										<ul>
											<li><a href="#">Shirts &amp; Tops</a></li>
											<li><a href="#">Dresses</a></li>
											<li><a href="#">Swimwear</a></li>
											<li><a href="#">Sweaters</a></li>
											<li><a href="#">Coats &amp; Outerwear</a></li>
										</ul>
									</li>
									<li>
										<a href="#">Best Sellers</a>
										<ul>
											<li><a href="#">Party Dress</a></li>
											<li><a href="#">Jean &amp; Trousers</a></li>
											<li><a href="#">Jacket &amp; Coats</a></li>
											<li><a href="#">Sweaters</a></li>
											<li><a href="#">Sports &amp; Lifestyle</a></li>
										</ul>
									</li>
									<li>
										<a href="#">Accessories</a>
										<ul>
											<li><a href="#">Bag &amp; Persess</a></li>
											<li><a href="#">Belts</a></li>
											<li><a href="#">Jewelry</a></li>
											<li><a href="#">Sunglasses</a></li>
											<li><a href="#">Cassuawear</a></li>
										</ul>
									</li>
									<li class="block-image">
										<a href="#"><img src="<?=BASE_URL;?>images/block/img-2.jpg" alt=""></a>
									</li>
								</ul>-->

							</li>

							<li class="megamenu col-5 menu-parent <?php if( $pagename=='contatti.php') echo ' current-menu-parent';?>"><a href="<?=BASE_URL;?>contatti.php">Contatti</a></li>

<!--							<li><a href="collection.html">Collections</a></li>-->

							<li class="megamenu col-5 menu-parent <?php if( $pagename=='blog.php') echo ' current-menu-parent';?>"><a href="<?=BASE_URL;?>blog.php">Blog</a></li>
                                                        <li class="megamenu col-5 menu-parent <?php if( $pagename=='carrello.php') echo ' current-menu-parent';?>"><a href="<?=BASE_URL;?>carts">Carrello</a></li>

<!--							<li class="menu-parent">

								<a href="blog.html">Blog</a>

								<ul class="sub-menu">

									<li><a href="blog-detail.html">Blog Detail</a></li>

								</ul>

							</li>
                                                        <li><a href="<?=BASE_URL;?>registrati.php">Registrati</a></li>-->
<!--<li  id="livuoto" class="megamenu col-5 menu-parent" style="width:29%;"><a href="#" style="a:after"></a></li>-->

                                                        <li>    <a href="https://www.facebook.com/Gevenit-srl-590638421085727/"><i class="fa  fa-facebook"></i></a></li>
							<!-- <li>	<a href="#"><i class="fa fa-twitter"></i></a></li> -->
							<li>	<a href="https://plus.google.com/100622012888684319512"><i class="fa fa-google-plus"></i></a></li>

						</ul>






					</nav>
					<!-- END NAVIGATION -->

				</div>
				<!-- END HEADER CONTENT -->

			</div>

		</header>
		<!-- END HEADER -->
