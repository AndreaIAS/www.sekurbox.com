<!-- SLIDER -->
		<section class="slide-watch">
			<div class="container">
				<div class="slide-watch-cn" id="slide-watch">
                    <?php
                          $db->query("SELECT slider_home.*
                                      FROM 
                                      slider_home
                                      ");
                
                          $list =  $db->single();
                          for ($i=1;$i<=5;$i++) {
                             if($list['img'.$i]!='') {
                     ?>
					<!-- SLIDE ITEM -->
			  <div class="item">

<!--						<div class="text">
						   	<h2>
						   		<span>The right place to get<br> 
						   		your dream</span> Watch
							</h2>
						   
					   		<div class="group">
					   			<a href="#" class="btn btn-9">Shop Now</a>
					   			<a href="#" class="btn btn-9">Men’s Lookbook</a>
					   		</div>
			   			</div>-->

<!--                           <a href="<?=$list['link_img'.$i];?>" >	-->
                               <img src="<?=$phpThumbBase;?>?src=images/img_slider_home/<?=$list['img'.$i];?>&w=1170&h=500&iar=1" alt=""> 
                           <!--</a>-->

			   </div>	
			   		<!-- SLIDE ITEM -->
                         <?php } }?>                     

			   		

				</div>
			</div>
		</section>
		<!-- END SLIDER -->