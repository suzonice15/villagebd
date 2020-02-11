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
?>

<section id="mpart">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?=base_url()?>">Home</a></li>
			<li class="active">Search</li>
		</ul>
		<div class="row mt40">
			<div class="col-md-3">
				<?php echo $sidebar; ?>
			</div>
			<div class="col-md-9">
				<h3 class="section-title"><?php echo $page_title; ?></h3>
				<br/>
				
				<?php
				if(!empty($products))
				{
					?><div class="productlistpage">
						<div class="sorting well">
							<div class="btn-group pull-right">
								<button class="btn" id="list"><i class="fa fa-th-list"></i> </button>
								<button class="btn btn-new" id="grid"><i class="fa fa-th icon-white"></i></button>
							</div>
						</div>
						<div id="productgrid">
							<?php
							$i=1; foreach($products as $prod)
							{
								$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
						
								$product_link = base_url($prod->product_name);

								$product_availability = $prod->product_availability ? $prod->product_availability : 'In Stock';
								$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));

								// product price
								$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
								
								if($i%4==1){ echo '<ul class="mt40 row">'; }
								
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
								
								?><li class="col-sm-3">
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
								</li><?php
								
								if($i%4==0){ echo '</ul>'; }
								
								$i++;
							}
							?>
						</div>
						<div class="mt40" id="productlist">
							<ul>
								<?php
								foreach($products as $prod)
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
									
									?><li>
										<div class="pro-box">
											<div class="img-box">
												<a href="<?=$product_link?>">
													<img src="<?php echo get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_thumbs'); ?>" alt="<?=$prod->product_title; ?>"/>
												</a>
											</div>
											<div class="pro-desc">
												<div class="pro-name"><a href="<?=$product_link?>"><?=$prod->product_title; ?></a></div>
												
												<div class="clearfix">
													<div class="price"><?php echo formatted_price($sell_price); ?></div>
													<div class="productdesc"><?=$prod->product_summary; ?></div>
												</div>
												
												<div class="add-btn-box">
													<a href="javascript:void(0)" class="prod_quick_view" data-product_id="<?=$prod->product_id?>">
														<i class="fa fa-eye"></i> Quick View
													</a>
													
													<a href="<?=$product_link?>">
														<i class="fa fa-eye"></i> View Detail
													</a>
										
													<?php
													if(!empty($sell_price) && $product_availability_index=='in-stock')
													{
														?><a href="javascript:void(0)" class="add_to_cart" data-product_id="<?=$prod->product_id?>" data-product_price="<?=$sell_price?>" data-product_title="<?=$prod->product_title?>">
															<i class="fa fa-shopping-cart"></i> Buy Now
														</a><?php
													}
													else
													{
														?><a href="<?=$product_link?>">
															<i class="fa fa-shopping-cart"></i> Buy Now
														</a><?php
													}
													?>
													
													<a href="<?=$wishlist_href?>" class="add_to_wish_list" data-product_id="<?=$prod->product_id?>">
														<i class="fa fa-heart"></i> Wishlist
													</a>
													
													<a href="javascript:void(0)" class="add_to_compare" data-product_id="<?=$prod->product_id?>">
														<i class="fa fa-signal"></i> Compare
													</a>
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
					echo '<p style="border:1px solid green;padding:5px;width:100%;font-size:16px;">No available products found!</p>';
				}
				?>
			</div>
		</div>
	</div>
</section>