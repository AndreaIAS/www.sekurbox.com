<!-- SIDEBAR -->


						<!-- SIDEBAR CATEGORIES -->
						<aside class="sidebar sidebar-cat _3">

							<div class="wrap-sidebar-title">
<!--								<h2 class="sidebar-title">Categorie</h2>-->
							</div>
						<ul class="nav-cat ">

                                                <?php
                                                $db->query("SELECT *
                                                            FROM
                                                            bag_macro
                                                            ORDER BY nome
                                                          ");

                                                $result =  $db->resultSet();
                                                foreach ($result as $list) {


                                                      $db->query("SELECT *
                                                                  FROM
                                                                  bag_articoli,bag_scat,bag_categorie,bag_macro
                                                                  WHERE bag_articoli.id_sottocategoria=bag_scat.id
                                                                  AND bag_scat.id_categoria=bag_categorie.id
                                                                  AND bag_categorie.id_macro=bag_macro.id AND bag_macro.id='".$list['id']."'

                                                          ");

                                                     $result =  $db->resultSet();
                                                     $numarticolimacro=$db->rowCount();


                                                ?>

								<li>
									<div class="check-box">

                                                                        <label for="cat-1" style="padding-left:5px;">
                                                                            <a style="text-decoration:none;color:black;
                                                                               <?php if(isset($categoria)  AND $categoria==$list['id']){ echo ' color:#009392 !important; '; } else { } ?>" href="javascript:void(null)" onclick="$('#m<?=$list['id'];?>').slideToggle();"><?=$list['nome'];?><span>(<?=$numarticolimacro;?>)</span></a>
                                                                        </label>
									</div>

								</li>

                                                                <ul id="m<?=$list['id'];?>" class="nav-cat"
                                                                <?php if(isset($categoria) AND $categoria==$list['id']){  } else { echo ' style="display:none" ';} ?>
                                                                    for="categorie" >

                                                             <?php
                                                             $db->query("SELECT *
                                                                         FROM
                                                                         bag_categorie
                                                                         WHERE id_macro='".$list['id']."'
                                                                         ORDER BY nome
                                                                          ");

                                                              $resultc =  $db->resultSet();
                                                              foreach ($resultc as $listc) {


                                                                      $db->query("SELECT *
                                                                                  FROM
                                                                                  bag_articoli,bag_scat,bag_categorie
                                                                                  WHERE bag_articoli.id_sottocategoria=bag_scat.id
                                                                                  AND bag_scat.id_categoria=bag_categorie.id
                                                                                  AND bag_categorie.id='".$listc['id']."'

                                                                          ");

                                                                $result =  $db->resultSet();
                                                                $numarticolicate=$db->rowCount();

                                                               ?>


                                                               <li>
									<div class="check-box">

                                                                        <label for="cat-1" style="padding-left:10px;font-size:14px;">
                                                                            <a style="text-decoration:none;
                                                                                <?php if(isset($scat)  AND $scat==$listc['id']){ echo ' color:#009392 !important; '; } else { } ?> " href="javascript:void(null)" onclick="$('#c<?=$listc['id'];?>').slideToggle();"><?=$listc['nome'];?><span>(<?=$numarticolicate;?>)</span></a>
                                                                        </label>
									</div>

								</li>
                                                                <ul id="c<?=$listc['id'];?>" class="nav-cat "
                                                              <?php if(isset($scat)  AND $scat==$listc['id']){  } else { echo ' style="display:none" ';} ?>
                                                                    for="sottocategorie">


                                                                <?php
                                                             $db->query("SELECT *
                                                                         FROM
                                                                         bag_scat
                                                                         WHERE id_categoria='".$listc['id']."'
                                                                         ORDER BY nome
                                                                          ");

                                                              $resultsc =  $db->resultSet();
                                                              foreach ($resultsc as $listsc) {


                                                                      $db->query("SELECT *
                                                                                  FROM
                                                                                  bag_articoli,bag_scat
                                                                                  WHERE bag_articoli.id_sottocategoria=bag_scat.id
                                                                                  AND bag_scat.id='".$listsc['id']."'

                                                                          ");

                                                                $result =  $db->resultSet();
                                                                $numarticoliscate=$db->rowCount();

                                                               ?>

                                                                 <li>
									<div class="check-box">

                                                                        <label for="cat-1" style="padding-left:20px;font-size:12px;">

                                                                            <i> <a  <?php if(isset($sottocategoria)  AND $sottocategoria==$listsc['id']){echo ' style="color:#009392 !important;" ';  } else { } ?>

                                                                                    href="<?=BASE_URL;?>scat_<?=$listsc['id'];?>/<?=seo_url($listsc['nome']) ;?>"> <?=$listsc['nome'];?><span>(<?=$numarticoliscate;?>)</a></i>
                                                                        </label>
									</div>

								</li>

                                                                <?php } ?>
                                                                <li>
									<div class="check-box">
                                                                        <label for="cat-1" style="padding-left:20px;font-size:12px;">
                                                                            <i> <a href="<?=BASE_URL;?>cat_<?=$listc['id'];?>/<?=seo_url($listc['nome']) ;?>">Tutti<span>(<?=$numarticolicate;?>)</span></a></i>
                                                                        </label>
									</div>

								 </li>
                                                                </ul>




                                                                <?php } ?>
                                                                 <li>
									<div class="check-box">
                                                                        <label for="cat-1" style="padding-left:10px;font-size:14px;">
                                                                             <a style="color:black;" href="<?=BASE_URL;?>mcat_<?=$list['id'];?>/<?=seo_url($list['nome']) ;?>">Tutti<span>(<?=$numarticolimacro;?>)</span></a>
                                                                        </label>
									</div>

								 </li>
                                                                </ul>

                                                <?php } ?>
						</ul>
						</aside>
						<!-- END SIDEBAR CATEGORIES -->

						<!-- SIDEBAR MANUFACTURE -->
<!--						<aside class="sidebar sidebar-fac _3">
							<div class="wrap-sidebar-title">
								<h2 class="sidebar-title"><span>By</span> Manufacture</h2>
							</div>
							<ul class="nav-cat ">
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-1">
										<label for="factory-1">10 Crosby Derek Lam <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-2">
										<label for="factory-2">Winks <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-3">
										<label for="factory-3">525 america <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-4">
										<label for="factory-4">55DSL <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-5">
										<label for="factory-5">For All Mankind <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-6">
										<label for="factory-6">A Gold E <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-7">
										<label for="factory-7">ABS Allen Schwartz <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-8">
										<label for="factory-8">Stella McCartney <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-9">
										<label for="factory-9">Adidas Originals <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="factory-10">
										<label for="factory-10">Adidas Outdoor <span>(212)</span></label>
									</div>
								</li>
							</ul>
						</aside>
						 END SIDEBAR MANUFACTURE

						 SIDEBAR SLIDER
						<aside class="sidebar sidebar-slider  _3">
							<div class="wrap-sidebar-title">
								<h2 class="sidebar-title"><span>By</span> Prices</h2>
							</div>
							<div class="slider">
								<div id="slider"></div>
								<div class="slider-g">
									<span class="price-value" id="price-f"></span>
									<span class="price-value" id="price-t"></span>
									<button class="btn-filter">Filter</button>
								</div>
							</div>
						</aside>-->
						<!-- END SIDEBAR SLIDER -->

						<!-- SIDEBAR COLOR -->
<!--						<aside class="sidebar sidebar-color _3">
							<div class="wrap-sidebar-title">
								<h2 class="sidebar-title"><span>By</span> Colors</h2>
							</div>
							<ul class="nav-color">
								<li class="_1"><a href="#"></a></li>
								<li class="_2"><a href="#"></a></li>
								<li class="_3"><a href="#"></a></li>
								<li class="_4"><a href="#"></a></li>
								<li class="_5"><a href="#"></a></li>
								<li class="_6"><a href="#"></a></li>
								<li class="_7"><a href="#"></a></li>
								<li class="_8"><a href="#"></a></li>
								<li class="_9"><a href="#"></a></li>
								<li class="_10"><a href="#"></a></li>
							</ul>
						</aside>-->
						<!-- END SIDEBAR COLOR -->

						<!-- SIDEBAR SIZE -->
<!--						<aside class="sidebar sidebar-size _3">
							<div class="wrap-sidebar-title">
								<h2 class="sidebar-title"><span>By</span> Size</h2>
							</div>
							<ul class="nav-cat ">
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="size-1">
										<label for="size-1">XL <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="size-2">
										<label for="size-2">S <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="size-3">
										<label for="size-3">XS <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="size-4">
										<label for="size-4">M <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="size-5">
										<label for="size-5">XXL <span>(212)</span></label>
									</div>
								</li>
								<li>
									<div class="check-box">
										<input type="checkbox" class="checkbox" id="size-6">
										<label for="size-6">L <span>(212)</span></label>
									</div>
								</li>
							</ul>
						</aside>-->
						<!-- END SIDEBAR SIZE -->

						<!-- SIDEBAR TAG -->
<!--						<aside class="sidebar sidebar-tags  _3">
							<div class="wrap-sidebar-title">
								<h2 class="sidebar-title"><span>Popular</span> Tags</h2>
							</div>
							<div class="sidebar-cloud">
								<a href="#">Tops</a>
								<a href="#">Women</a>
								<a href="#">Uber-Jean</a>
								<a href="#">Menstyle</a>
								<a href="#">Dress</a>
								<a href="#">Gree Kids</a>
								<a href="#">Unai Skirts</a>
								<a href="#">Cristmas14</a>
								<a href="#">Tea</a>
								<a href="#">Iphone 6 Plus</a>
								<a href="#">Sexy</a>
								<a href="#">Bagarols</a>
								<a href="#">Black Friday</a>
								<a href="#">50% Off</a>
							</div>
						</aside>-->
						<!-- END SIDEBAR TAG -->
