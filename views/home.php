
<style>
.main-slider-devision .col-md-3{
    
}


</style>

<div class="container-fluid main-slider-devision">
    <div class="row">
        <div class="col-md-3 col-xs-12">
            	<?php
			if(!empty($leftsliders))
			{
			
				
				foreach($leftsliders as $slider)
				{
				    	$homeslider_banner = $slider->homeslider_banner;
            ?>
                   
                    	<a href="<?php echo $slider->target_url; ?>"><img style="width:100%;" src="<?php echo $homeslider_banner; ?>" alt="<?php echo $slider->homeslider_title; ?>" ></a>
                    
                    <?php } } ?>
                    
                   
                </div>
                
                
                
<section class="banner_slider">
    <div class="col-md-6 col-xs-12">
	<div id="banner_carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
			<?php
			if(!empty($homesliders))
			{
				$indicators = '';
				
				$i=1; foreach($homesliders as $slider)
				{
					$homeslider_banner = $slider->homeslider_banner;

					if(strpos($slider->homeslider_banner, 'www') !== false || strpos($slider->homeslider_banner, 'http') !== false || strpos($slider->homeslider_banner, 'https') !== false)
					{
						$homeslider_banner = $slider->homeslider_banner;
					}
					else
					{
						if(file_exists($slider->homeslider_banner))
						{
							$homeslider_banner = base_url($slider->homeslider_banner);
						}
					}
					
					if($i==1){ $item = 'active'; }else{ $item = ''; }
					
					?><div class="item <?php echo $item; ?>">
						<a href="<?php echo $slider->target_url; ?>"><img src="<?php echo $homeslider_banner; ?>" alt="<?php echo $slider->homeslider_title; ?>" width="400" height="345"></a>
					</div><?php
					
					$indicators .= '<li data-target="#banner_carousel" data-slide-to="'.($i-1).'" class="'.(($i-1)==0 ? 'active' : null).'">&nbsp;</li>';
					
					$i++;
				}

				?><ol class="carousel-indicators"><?php echo $indicators; ?></ol><?php
			}
			?>
		</div>
		
	
		
		
		<a class="left carousel-control" href="#banner_carousel" role="button" data-slide="prev">
			<span class="fa fa-angle-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#banner_carousel" role="button" data-slide="next">
			<span class="fa fa-angle-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		
	</div>
	</div>
</section>
        
        <div class="col-md-3 col-xs-12">
            	<?php
			if(!empty($rightsliders))
			{
			
				
				foreach($rightsliders as $slider)
				{
				    	$homeslider_banner = $slider->homeslider_banner;
            ?>
                   
                    	<a href="<?php echo $slider->target_url; ?>"><img style="width:100%;" src="<?php echo $homeslider_banner; ?>" alt="<?php echo $slider->homeslider_title; ?>" ></a>
                    
                    <?php } } ?>
                
                </div>

</div>
</div>



<!-- for slider bappy -->



	
		
<!-- next images -->

<div class="container-fluid gallery-container-fluid">

    
    <div class="tz-gallery">

        <div class="row">
            
            <?php if(isset($bottom_sliders) ) { 
            
            foreach($bottom_sliders as $slider) { 
               
               $image=get_media_path($slider->media_id);
            ?>

            <div class="col-xs-6 col-sm-3">
                <a class="" href="<?php echo $slider->adds_link?>">
                    <img src="<?php echo $image?>" alt="<?php echo $slider->adds_title?>">
                </a>
            </div>
            
            <?php }  } ?>
            
            
          
            

        </div>

    </div>

</div>



<!-- New product gallery bappy one line-->

<div class="container-fluid">
    <h3 class="h3"></h3>
    <div class="row">

	<?php
					if(count($products)>0)
					{
						$grid_view_html = $list_view_html = null;
						
						$i=1; foreach($products as $prod)
						{
							$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
                          //  $featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod_row->product_id));
//$featured_image_path = get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/');
							
							$product_link = base_url($prod->product_name);
							// product price
							$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
						/*	$discount_price=0;
						//	$discount=0;
							if($prod->discount_price){
							   $discount_price= $prod->product_price-$prod->discount_price;
							  $discount= round(($discount_price*100)/$prod->product_price);
							   
							}
							*/
					
							$image=get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/');
								$wishlist_href = in_array($prod->product_id, $wishlist) ? base_url('wishlist') : 'javascript:void(0)';
							
							$compare_href = in_array($prod->product_id, $compare) ? base_url('compare') : 'javascript:void(0)';
							
						//	$this->db->where('media_type','product_gallery');
							//$this->db->where('relation_id', $prod->product_id);
					//	$result=	$this->db->get('media')->row();
							//echo '<pre>'; uploads/product/list/A4Tech G520 B.jpg
						//	print_r($result);exit();
							$second_featured_image = $this->global_model->get_row('media', array('media_type' => 'product_gallery', 'relation_id' => $prod->product_id));
							if($second_featured_image){
							$second_image=get_photo((isset($second_featured_image->media_path) ? $second_featured_image->media_path : null), 'uploads/product/');
							} else {
							    $second_image=base_url().'uploads/product/list/A4Tech G520 B.jpg';
							}


							?>

<div class="col-md-3 col-sm-6">
            <div class="product-grid4">
                <div class="product-image4">
                    <a href="<?php echo $product_link?>">
                        <img class="pic-1" src="<?php echo $image?>" width="312">
                        <img class="pic-2" src="<?php echo $second_image?>" width="312" >
                    </a>
                    <ul class="social">
                        <li><a href="javascript:void(0)"  class="prod_quick_view" data-tip="Quick View" data-product_id="<?php echo $prod->product_id ?>" data-product_price="<?php echo $sell_price ?>" data-product_title="<?php echo $prod->product_title ?>" ><i class="fa fa-eye"></i></a></li>
                        <li><a href="<?php echo $wishlist_href ?>" class="add_to_wish_list"  data-tip="Add to Wishlist" data-product_id="<?php echo $prod->product_id ?>" data-product_price="<?php echo $sell_price ?>" data-product_title="<?php echo $prod->product_title ?>"><i class="fa fa-heart"></i></a></li>
                        <li><a  href="<?php echo $compare_href ?>" class="add_to_compare"  data-tip="Add to Cart" data-product_id="<?php echo $prod->product_id ?>" data-product_price="<?php echo $sell_price ?>" data-product_title="<?php echo $prod->product_title ?>"><i class="fa fa-signal"></i></a></li>
                    </ul>
                    <span hidden class="product-discount-label">-<?php echo $discount?>%</span>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="<?php echo $product_link?>"><?php echo $prod->product_title?></a></h3>
                    <div class="stars">
                        <span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span>
                    </div>
                    
                    <div class="price">
                       Discount Price
                        <?php 
                        
                        
                        echo formatted_price($sell_price); ?>
                        <span> <?php 
                       
                        	if($prod->discount_price){
                        	     echo 'Regular Price';
                        echo formatted_price($prod->product_price); } ?></span>
                    </div>
                    <a class="add_to_cart add-to-cart" data-product_id="<?php echo $prod->product_id ?>" data-product_price="<?php echo $sell_price ?>" data-product_title="<?php echo $prod->product_title ?>"  href="javascript:void(0)">Buy Now</a>
                </div>
            </div>
        </div>
        
<?php }  } ?>


</div>
</div>
</div> 



<?php 



if(isset($categories)) { 
    
    foreach($categories as $row){ 
?>
    
        <div class="col-md-2">
           
            <h3 class="h3"> </h3>
            
            <div class="product-grid4">
                <div class="product-image4">
                    
                        <a href="<?php echo base_url(); echo $row->category_name; ?>">
                            <h4> <?php echo $row->category_title;?> </h4>
                            <i class="<?php echo $row->category_icon; ?>" style="font-size:60px;color:green;text-shadow:2px 2px 4px #000000;"></i>
                        </a>
                        
                <h3 class="title"><a href="<?php echo base_url(); echo $row->category_name; ?>"><button type="button" class="btn btn-outline-success btn-block"> Starting From <?php echo formatted_price($row->category_price)?></button></a></h3>
               
               </div>
            </div>
        </div>
        
        <?php } } ?>
        
       
        
        
        

        
        

<!-- catagory product Bappy-->


<div class="container">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-8">
			<?php
			$adds = get_adds('home_cat_top');
			//echo '<pre>'; print_r($adds); echo '</pre>';
			if(count($adds) > 0)
			{
				foreach($adds as $add);
				echo '<hr class="break break10">';
				echo '<a href="'.$add->adds_link.'"><img src="'.get_media_path($add->media_id).'" alt="'.$add->adds_title.'"></a>';
				echo '<hr class="break break10">';
			}
			?>
		</div>
	</div>
</div>  


<!-- Finish product Bappy


<section class="liveshopping">
	<div class="container">
		<div class="row row5">
			<div class="col-sm-10">
				<?php
				$live_shopping = false;
				$live_shopping_status = get_option('live_shopping_status');
				$live_shopping_start_time = get_option('live_shopping_start_time');
				$live_shopping_end_time = get_option('live_shopping_end_time');

				if($live_shopping_status == 'enable' && !empty($live_shopping_start_time) && !empty($live_shopping_end_time))
				{
					$live_shopping_start_time = date('Y-m-d H:i:s', strtotime($live_shopping_start_time));
					$live_shopping_end_time = date('Y-m-d H:i:s', strtotime($live_shopping_end_time));

					if(time() >= strtotime($live_shopping_start_time) && time() <= strtotime($live_shopping_end_time))
					{
						$live_shopping = true;					
					}

					if($live_shopping == true)
					{
						$live_products = get_live_products(6);
						if(!empty($live_products))
						{
							?><div class="innerbox">
								<div class="countdown-box">
									<img src="<?=base_url('images/live-shopping.gif')?>">
									<div id="countdown"></div>
								</div>
								<div class="live-shopping-products">
									<ul id="liveShoppingLightSlider" class="">
										<?php
										foreach($live_products as $prod)
										{
											$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));

											$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;

											$percent = number_format((($prod->discount_price / $prod->product_price) * 100), 0);
											$percent = 100 - $percent;
											
											?><li>
												<div class="pro-box">
													<div class="percent"><?=$percent?>%</div>
													<div class="img-box">
														<a href="<?php echo base_url($prod->product_name); ?>">
															<img src="<?php echo get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list'); ?>" alt="<?=$prod->product_title; ?>"/>
														</a>
													</div>
													<div class="pro-desc">
														<div class="previous-price">
															Previous Price: <?=formatted_price($prod->product_price, false, true)?>
														</div>
														<div class="sell-price">
															<?=formatted_price($sell_price, true, true)?>
														</div>
													</div>
												</div>
											</li><?php
										}
										?>
									</ul>
								</div>
							</div><?php
						}
						else
						{
							?><a href="<?php echo get_option('live_shopping_url'); ?>">
								<img src="<?php echo get_option('live_shopping_banner'); ?>">
							</a><?php
						}
					}
					else
					{
						?><a href="<?php echo get_option('live_shopping_url'); ?>">
							<img src="<?php echo get_option('live_shopping_banner'); ?>">
						</a><?php
					}
				}
				else
				{
					?><a href="<?php echo get_option('live_shopping_url'); ?>">
						<img src="<?php echo get_option('live_shopping_banner'); ?>">
					</a><?php
				}
				?>
			</div>
			<div class="col-sm-2 weekly-offer-banner">
				<a href="<?php echo get_option('new_offer_url'); ?>">
					<img src="<?php echo get_option('new_offer_banner'); ?>">
				</a>
				<a href="<?php echo get_option('weekly_offer_url'); ?>">
					<img src="<?php echo get_option('weekly_offer_banner'); ?>">
				</a>
			</div>
		</div>
	</div>
</section>

––>





<!-- category products -->
<?php
$wishlist = array();
if($this->session->userdata('wishlist'))
{
	$wishlist = $this->session->userdata('wishlist');
}

$compare = array();
if($this->session->userdata('compare'))
{
	$compare = $this->session->userdata('compare');
}

$home_cat_section = explode(",", get_option('home_cat_section'));
//echo '<pre>'; print_r($home_cat_section); echo '</pre>';

if(sizeof($home_cat_section)>0)
{
	$cat_i = 1;

	foreach($home_cat_section as $home_cat)
	{
		$category_info = get_category_info($home_cat);
		//echo '<pre>'; print_r($category_info); echo '</pre>';
		
		if(sizeof($category_info)>0)
		{
			$category_title	= $category_info->category_title;
			$category_name 	= $category_info->category_name;
			$category_url 	= base_url($category_name);
			
			$category_banner 		= $category_info->category_banner;
			$banner_target_url 		= $category_info->banner_target_url;
			$category_galleries[0] 	= $category_info->category_gallery1;
			$category_galleries[1] 	= $category_info->category_gallery2;
			$category_galleries[2] 	= $category_info->category_gallery3;
			$category_galleries 	= array_values(array_filter($category_galleries));
			//echo '<pre>'; print_r($category_galleries); echo '</pre>';
			
			$subcategories = get_subcategories($home_cat);
			//echo '<pre>'; print_r($subcategories); echo '</pre>';
			
			$catproducts = get_category_products($home_cat, 4, NULL, 'home');
			//echo '<pre>'; print_r($catproducts); echo '</pre>';
			
			$catproducts2 = get_category_products($home_cat, 5, 2, 'home');
			//echo '<pre>'; print_r($catproducts2); echo '</pre>';
			
			?><section class="catproducts">
				<div class="container">
					<div class="title">
						<?php
						if(sizeof($subcategories)>0)
						{
							?><a href="javascript:void(0)"><?=$category_title?> <i class="fa fa-bars"></i></a>
							<ul class="subcats"><?php
							
								foreach($subcategories as $subcat)
								{
									$subcat_url = base_url($subcat->category_name);
									
									echo '<li><a href="'.$subcat_url.'">'.$subcat->category_title.'</a></li>';
								}
								
							?></ul><?php
						}
						else
						{
							?><a href="<?=$category_url?>"><?=$category_title?></a><?php
						}
						?>
					</div>
					<div class="row">
						<div class="col-sm-4">
				
							<?php
							if(sizeof($category_galleries)>0)
							{
								?>
								
								<div id="cat_img_slider<?=$home_cat?>" class="carousel slide cat_img_slider" data-ride="carousel">
									<div class="carousel-outer">
										<div class="carousel-inner">
											<?php
											//$indicators = '';
											$gallery_item=1;
											$i=1;
											foreach($category_galleries as $gallery)
											{
											
											if($i==1){
												if($gallery_item==1){ $item_active = 'active'; }
												else{ $item_active = ''; }
												
												if($gallery_item==1){ $target_url = $category_info->target_url1; }
												elseif($gallery_item==2){ $target_url = $category_info->target_url2; }
												elseif($gallery_item==3){ $target_url = $category_info->target_url3; }
												
												$gallery_img = get_media_path($gallery);
												
												echo '<div class="item '.$item_active.'"><a href="'.$target_url.'"><img src="'.$gallery_img.'" alt="#"></a></div>';
												
												$gallery_item++;
											}
												$i++;
												
											}
											?>
										</div>
									
									<!--	<a class="left carousel-control" href="#cat_img_slider<?=$home_cat?>" data-slide="prev">
											<span class="glyphicon glyphicon-chevron-left"></span>
										</a>
										<a class="right carousel-control" href="#cat_img_slider<?=$home_cat?>" data-slide="next">
											<span class="glyphicon glyphicon-chevron-right"></span>
										</a>
										-->
									</div>
								</div><?php
							}
							else
							{
								if(sizeof($catproducts2)>0)
								{
									?><div class="row products">
										<?php
										foreach($catproducts2 as $prod)
										{
											$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
											
											$product_link = base_url($prod->product_name);
											
											$product_availability = $prod->product_availability;
											$product_availability = $product_availability ? $product_availability : 'In Stock';
											$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));

											// product price
											$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
											
											$wishlist_href = 'javascript:void(0)';
											if(in_array($prod->product_id, $wishlist))
											{
												$wishlist_href = base_url('wishlist');
											}
											
											$compare_href = 'javascript:void(0)';
											if(in_array($prod->product_id, $compare))
											{
												$compare_href = base_url('compare');
											}
											
											?><div class="col-sm-6">
												<div class="pro-box">
													<?php if($product_availability_index!='in-stock'){ ?>
													<div class="availability">
														<?=$product_availability?>
													</div>
													<?php } ?>
													
													<div class="img-box">
														<a href="<?=$product_link?>">
															<img src="<?php echo get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_list'); ?>" alt="<?=$prod->product_title; ?>"/>
														</a>
														<div class="hover-view-action">
															<a href="javascript:void(0)" class="prod_quick_view" data-product_id="<?=$prod->product_id?>" title="Quick View">
																<i class="fa fa-eye"></i>
															</a>
															<a href="<?=$wishlist_href?>" class="add_to_wish_list" data-product_id="<?=$prod->product_id?>" title="Wishlist">
																<i class="fa fa-heart"></i>
															</a>
															<a href="<?=$compare_href?>" class="add_to_compare" data-product_id="<?=$prod->product_id?>" title="Compare">
																<i class="fa fa-signal"></i>
															</a>
														</div>
													</div>
													<div class="info-box">
														<div class="pro-name">
															<a href="<?=$product_link?>"><?=strip_tags($prod->product_title)?></a>
														</div>
														
														<div class="price"><?php echo formatted_price($sell_price); ?></div>
													</div>
													<div class="action-box">
														<a href="<?=$product_link?>">
															View Detail
														</a>
														
														<?php
														if(!empty($sell_price) && $product_availability_index=='in-stock')
														{
															?><a href="javascript:void(0)" class="add_to_cart" data-product_id="<?=$prod->product_id?>" data-product_price="<?=$sell_price?>" data-product_title="<?=$prod->product_title?>">
																Buy Now
															</a><?php
														}
														else
														{
															?><a href="<?=$product_link?>">
																Buy Now
															</a><?php
														}
														?>
													</div>
												</div>
											</div><?php
										}
										?>
									</div><?php
								}
							}
							?>
							
			
						</div>
						<div class="col-sm-8">
							<?php
							if(sizeof($catproducts)>0)
							{
								?><div class="row products">
									<?php
									foreach($catproducts as $prod)
									{
										$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
										
										$product_link = base_url($prod->product_name);

										$product_availability = $prod->product_availability;
										$product_availability = $product_availability ? $product_availability : 'In Stock';
										$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));

										// product price
										$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
										
										$wishlist_href = 'javascript:void(0)';
										if(in_array($prod->product_id, $wishlist))
										{
											$wishlist_href = base_url('wishlist');
										}
										
										$compare_href = 'javascript:void(0)';
										if(in_array($prod->product_id, $compare))
										{
											$compare_href = base_url('compare');
										}
										
										?><div class="col-sm-3">
											<div class="pro-box">
												<?php if($product_availability_index!='in-stock'){ ?>
												<div class="availability">
													<?=$product_availability?>
												</div>
												<?php } ?>
												
												<div class="img-box">
													<a href="<?=$product_link?>">
														<img src="<?php echo get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_list'); ?>" alt="<?=$prod->product_title; ?>"/>
													</a>
													<div class="hover-view-action">
														<a href="javascript:void(0)" class="prod_quick_view" data-product_id="<?=$prod->product_id?>" title="Quick View">
															<i class="fa fa-eye"></i>
														</a>
														<a href="<?=$wishlist_href?>" class="add_to_wish_list" data-product_id="<?=$prod->product_id?>" title="Wishlist">
															<i class="fa fa-heart"></i>
														</a>
														<a href="<?=$compare_href?>" class="add_to_compare" data-product_id="<?=$prod->product_id?>" title="Compare">
															<i class="fa fa-signal"></i>
														</a>
													</div>
												</div>
												<div class="info-box">
													<div class="pro-name">
														<a href="<?=$product_link?>"><?=strip_tags($prod->product_title)?></a>
													</div>
													
													<div class="price"><?php echo formatted_price($sell_price); ?></div>
												</div>
												<div class="action-box">
													<a href="<?=$product_link?>">
														View Detail
													</a>
														
													<?php
													if(!empty($sell_price) && $product_availability_index=='in-stock')
													{
														?><a href="javascript:void(0)" class="add_to_cart" data-product_id="<?=$prod->product_id?>" data-product_price="<?=$sell_price?>" data-product_title="<?=$prod->product_title?>">
															Buy Now
														</a><?php
													}
													else
													{
														?><a href="<?=$product_link?>">
															Buy Now
														</a><?php
													}
													?>
												</div>
											</div>
										</div><?php
									}
									?>
								</div><?php
							}

							if($category_banner)
							{
								echo '<hr class="break break10">';
								echo '<a href="'.$banner_target_url.'"><img src="'.get_media_path($category_banner).'"></a>';
							}
							?>
						</div>
					</div>
				</div>
			</section><?php
		}

		$cat_i++;
	}
}
?>




<!-- end category products -->


<!-- customer recent view products
<?php
$recent_view = array();
if($this->session->userdata('recent_view'))
{
	$recent_view = $this->session->userdata('recent_view');
}
//echo '<pre>'; print_r($recent_view); echo '</pre>';

if(sizeof($recent_view)>0)
{
	$recent_view_products = get_customer_recent_view_products($recent_view);
	
	?><section class="recentview">
		<div class="container">
			<div class="title">Your Recent Views</div>
			<div class="row products">
				<?php
				if(sizeof($recent_view_products)>0)
				{
					foreach($recent_view_products as $prod)
					{
						$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));;
						
						$product_link = base_url($prod->product_name);

						$product_availability = $prod->product_availability;
						$product_availability = $product_availability ? $product_availability : 'In Stock';
						$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));

						// product price
						$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
						
						$wishlist_href = 'javascript:void(0)';
						if(in_array($prod->product_id, $wishlist))
						{
							$wishlist_href = base_url('wishlist');
						}
						
						$compare_href = 'javascript:void(0)';
						if(in_array($prod->product_id, $compare))
						{
							$compare_href = base_url('compare');
						}
						
						?><div class="col-sm-2">
							<div class="pro-box">
								<?php if($product_availability_index!='in-stock'){ ?>
								<div class="availability">
									<?=$product_availability?>
								</div>
								<?php } ?>
								
								<div class="img-box">
									<a href="<?=$product_link?>">
										<img src="<?php echo get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_list'); ?>" alt="<?=$prod->product_title; ?>"/>
									</a>
									<div class="hover-view-action">
										<a href="javascript:void(0)" class="prod_quick_view" data-product_id="<?=$prod->product_id?>" title="Quick View">
											<i class="fa fa-eye"></i>
										</a>
										<a href="<?=$wishlist_href?>" class="add_to_wish_list" data-product_id="<?=$prod->product_id?>" title="Wishlist">
											<i class="fa fa-heart"></i>
										</a>
										<a href="<?=$compare_href?>" class="add_to_compare" data-product_id="<?=$prod->product_id?>" title="Compare">
											<i class="fa fa-signal"></i>
										</a>
									</div>
								</div>
								<div class="info-box">
									<div class="pro-name">
										<?php
										$_product_title = strip_tags($prod->product_title);
										//if(strlen($_product_title) >= 25){ $_product_title = substr($_product_title, 0, 22).'...'; }
										?>
										
										<a href="<?=$product_link?>"><?=$_product_title?></a>
									</div>
									
									<div class="price"><?php echo formatted_price($sell_price); ?></div>
								</div>
								<div class="action-box">
									<a href="<?=$product_link?>">
										View Detail
									</a>
										
									<?php
									if(!empty($sell_price) && $product_availability_index=='in-stock')
									{
										?><a href="javascript:void(0)" class="add_to_cart" data-product_id="<?=$prod->product_id?>" data-product_price="<?=$sell_price?>" data-product_title="<?=$prod->product_title?>">
											Buy Now
										</a><?php
									}
									else
									{
										?><a href="<?=$product_link?>">
											Buy Now
										</a><?php
									}
									?>
								</div>
							</div>
						</div><?php
					}
					
					$prod='';
				}
				?>
			</div>
		</div>
	</section>
<?php } ?>
<!-- end customer recent view products 


<?php
$brands = get_brands();
//echo '<pre>'; print_r($brands); echo '</pre>';

if(isset($brands))
{
	?><section id="brand_list">
		<div class="container">
			<div class="title"><a>Brands</a></div>
			
			<div class="owl-carousel owl-theme">
				<?php
				foreach($brands as $brand)
				{
					$media_path = get_media_path($brand->media_id);

					?>
					<div class="item">
						<img src="<?php echo $media_path; ?>">
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</section>

	<script>
	jQuery(document).ready(function()
	{
		var owl = jQuery('#brand_list .owl-carousel');
		owl.owlCarousel({
			margin: 15,
			nav: true,
			dots: false,
			loop: true,
			autoplay: true,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 4
				},
				999: {
					items: 3
				},
				360: {
					items: 1
				},
				320: {
					items: 1
				},
			}
		});
	});
	</script>
	<?php
}
?>

-->




<section class="footer-seo-box">
	<div class="container">
		<div class="inner">
			<div class="about-box">
				<h1 itemprop="name"><?=get_option('home_about_title')?></h2>
				<p itemprop="description"><?=get_option('home_about_content')?></p>
			</div>
		</div>
	</div>
</section>

<div class="container-fluid">
  <div class="row">
      <marquee>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/asus.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/acer.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/apple.jpg">
    </div>
    <div class="col-md-1 col-sm-3">
      <img class="client" src="images/lenovo.jpg">
    </div>
    <div class="col-md-1 col-sm-3">
      <img class="client" src="images/cisco.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/dell.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/gigabyte.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/hp.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/intel.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/ryzen.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/msi.jpg">
    </div>
    <div class="col-md-1 col-sm-6">
      <img class="client" src="images/microsoft.jpg">
    </div>
    </marquee>
  </div>
  </div>


