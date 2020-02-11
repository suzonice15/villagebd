<?php
//echo '<pre>'; print_r($catinfo); echo '</pre>';
//echo '<pre>'; print_r($products); echo '</pre>';
$base_url = base_url($category_name);

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

$subcategories = get_subcategories($category_id, 'no');
?>

<section id="mpart">
	<div class="container">
		<div class="row">
			<div id="sidebar" class="col-md-3 filter-sidebar filter-elements">
				<div class="filter-group">
					<div class="filter-item filter_categories <?php if(sizeof($subcategories)==0){ echo 'no-subcat'; } ?>">
						<h4 class="title"><?=$page_title?></h4>
						<?php
						if(sizeof($subcategories)>0)
						{
							?><ul class="subcats"><?php
							
								foreach($subcategories as $subcat)
								{
									$subcat_url = base_url($subcat->category_name);
									
									echo '<li><a href="'.$subcat_url.'">'.$subcat->category_title.'</a></li>';
								}
								
							?></ul><?php
						}
						else
						{
							$category_info = get_category_info($category_id);
							$cat_parent_id = $category_info->parent_id;
							$parent_subcategories = get_subcategories($cat_parent_id);
							
							if(sizeof($parent_subcategories)>0)
							{
								?><ul class="subcats"><?php
								
									foreach($parent_subcategories as $psubcat)
									{
										$psubcat_url = base_url($psubcat->category_name);
										
										echo '<li><a href="'.$psubcat_url.'">'.$psubcat->category_title.'</a></li>';
									}
									
								?></ul><?php
							}
						}
						?>
					</div>
				</div>
				
				<hr class="break30"/>

				<div class="filter-group">
					<div class="filter-item filter_price_range">
						<h4 class="title">Price</h4>
						<form id="formPriceRange" class="filter-cnt clearfix">
							<div class="form-group">
								<label class="control-label">from</label>
								<div class="has-preffix">
									<span class="preffix">৳</span>
									<input type="text" name="price_from" id="price_from" class="form-control" value="<?php if(isset($_GET['price_from'])){ echo $_GET['price_from']; } ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">to</label>
								<div class="has-preffix">
									<span class="preffix">৳</span>
									<input type="text" name="price_to" id="price_to" class="form-control" value="<?php if(isset($_GET['price_to'])){ echo $_GET['price_to']; } ?>">
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-block">ok</button>
							</div>
						</form>
					</div>
				</div>
				
				<hr class="break30"/>
				
				<div class="topviews">
					<?php
					$top_view_products = get_top_view_products_by_terms($category_id);
					//echo '<pre>'; print_r($top_view_products); echo '</pre>';
					if(sizeof($top_view_products)>0)
					{
						echo '<div class="title">Top Views</div>';
						echo '<ul>';
						
							foreach($top_view_products as $topview)
							{
								$tprod = get_product($topview->product_id);
								//echo '<pre>'; print_r($tprod); echo '</pre>';
								
								if($tprod)
								{
									$_tproduct_title = $tprod->product_title ? strip_tags($tprod->product_title) : null;
									if(strlen($_tproduct_title) >= 25){ $_tproduct_title = substr($_tproduct_title, 0, 22).'...'; }

									// product image
		                            $recent_prod_featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $topview->product_id));

									$recent_prod_product_link = base_url($tprod->product_name);
									
									 echo '<li class="top-item">
										<a href="'.$recent_prod_product_link.'">
											<div class="image"><img src="'.get_photo((isset($recent_prod_featured_image->media_path) ? $recent_prod_featured_image->media_path : null), 'uploads/product/','mini_thumbs').'"></div>
											<div class="name">'.$_tproduct_title.'</div>
										</a>
									</li>';
								}
							}
						
						echo '</ul>';
					}
					?>
				</div>
				
				<hr class="break30"/>
				
				<div class="adsbox">
					<?php
					$adds = get_adds('cat_sidebar');
					//echo '<pre>'; print_r($adds); echo '</pre>';
					if(count($adds) > 0)
					{
						$side_html='<ul>';
						
						foreach($adds as $add)
						{
							$side_html.='<li>
								<h4>'.$add->adds_title.'</h4>
								<a href="'.$add->adds_link.'">
									<img src="'.get_media_path($add->media_id).'">
								</a>
							</li>';

						}
						
						$side_html.='</ul>';
						
						echo $side_html;
					}
					?>
				</div>
			</div>
			<div class="col-md-9">
				<?=get_breadcrumb($category_id, 'category'); ?>

				<?php
				$category_banner2 	= $catinfo->category_banner2;
				$banner_target_url2 	= $catinfo->banner_target_url2;

				if($category_banner2)
				{
					echo '<a href="'.$banner_target_url2.'"><img src="'.get_media_path($category_banner2).'"></a>';
					echo '<hr class="break break5">';
				}
				?>

				<div class="productlistpage">
					<div class="sorting well">
						<form id="sortby" class="form-inline pull-left">
							Sort By :
							<?php
							$sortby = 'price_asc';
							if(isset($_COOKIE['sortby'])){ $sortby = $_COOKIE['sortby']; }
							?>
							<select class="span2">
								<option value="default" <?=$sortby=='default'?'selected':null?>>Default</option>
								<option value="name_asc" <?=$sortby=='name_asc'?'selected':null?>>Name A-Z</option>
								<option value="name_desc" <?=$sortby=='name_desc'?'selected':null?>>Name Z-A</option>
								<option value="price_asc" <?=$sortby=='price_asc'?'selected':null?>>Price Low to High</option>
								<option value="price_desc" <?=$sortby=='price_desc'?'selected':null?>>Price High to Low</option>
								<option value="rating_desc" <?=$sortby=='rating_desc'?'selected':null?>>Rating High to Low</option>
							</select>
						</form>
						<div class="btn-group pull-right">
							<a class="btn btn-primary btn-compare" href="<?=base_url('compare')?>">Compare</a>
							<button class="btn" id="list"><i class="fa fa-th-list"></i> </button>
							<button class="btn btn-new" id="grid"><i class="fa fa-th icon-white"></i></button>
						</div>
					</div>
			
					<?php
					if(count($products)>0)
					{
						$grid_view_html = $list_view_html = null;
						
						$i=1; foreach($products as $prod)
						{
							$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
							
							$product_link = base_url($prod->product_name);

							$product_availability = $prod->product_availability;
							$product_availability = $product_availability ? $product_availability : 'In Stock';
							$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));

							// product price
							$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
							
							if($i%4==1)
							{
								if($i==1)
								{
									$grid_view_html.='<ul class="row">';
								}
								else
								{
									$grid_view_html.='<ul class="mt40 row">';
								}
							}
							
							$wishlist_href = in_array($prod->product_id, $wishlist) ? base_url('wishlist') : 'javascript:void(0)';
							
							$compare_href = in_array($prod->product_id, $compare) ? base_url('compare') : 'javascript:void(0)';

							$grid_view_html.='<li class="col-sm-3">
								<div class="pro-box">';

									if($product_availability_index!='in-stock')
									{
										$grid_view_html.='<div class="availability">'.$product_availability.'</div>';
									}

									$grid_view_html.='<div class="img-box">
										<a href="'.$product_link.'"><img src="'.get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list').'" alt="'.$prod->product_title.'"/>
										</a>
										<div class="hover-view-action">
											<a href="javascript:void(0)" class="prod_quick_view" data-product_id="'.$prod->product_id.'" title="Quick View">
												<i class="fa fa-eye"></i>
											</a>
											<a href="'.$wishlist_href.'" class="add_to_wish_list" data-product_id="'.$prod->product_id.'" title="Wishlist">
												<i class="fa fa-heart"></i>
											</a>
											<a href="'.$compare_href.'" class="add_to_compare" data-product_id="'.$prod->product_id.'" title="Compare">
												<i class="fa fa-signal"></i>
											</a>
										</div>
									</div>
									<div class="info-box">
										<div class="pro-name" style="height: 36px;overflow: hidden;" >
											<a href="'.$product_link.'">'.strip_tags($prod->product_title).'</a>
										</div>
										<div class="price">'.formatted_price($sell_price).'</div>
									</div>
									<div class="action-box">
										<a href="'.$product_link.'">View Detail</a>';
											
										if($product_availability_index=='in-stock')
										{
											$grid_view_html.='<a href="javascript:void(0)" class="add_to_cart" data-product_id="'.$prod->product_id.'" data-product_price="'.$sell_price.'" data-product_title="'.$prod->product_title.'">
												Buy Now
											</a>';
										}
										else
										{
											$grid_view_html.='<a href="'.$product_link.'">Buy Now</a>';
										}
									$grid_view_html.='</div>
								</div>
							</li>';

							$list_view_html.='<li>
								<div class="pro-box">
									<div class="img-box">
										<a href="'.$product_link.'">
											<img src="'.get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list').'" alt="'.$prod->product_title.'"/>
										</a>
									</div>
									<div class="pro-desc">
										<div class="pro-name"><a href="'.$product_link.'">'.$prod->product_title.'</a></div>
										
										<div class="clearfix">
											<div class="price">'.formatted_price($sell_price).'</div>
											<div class="productdesc">'.strip_tags($prod->product_summary).'</div>
										</div>
										
										<div class="add-btn-box">
											<a href="javascript:void(0)" class="prod_quick_view" data-product_id="'.$prod->product_id.'">
												<i class="fa fa-eye"></i> Quick View
											</a>
											<a href="'.$product_link.'">
												<i class="fa fa-eye"></i> View Detail
											</a>';
										
											if($product_availability_index=='in-stock')
											{
												$list_view_html.='<a href="javascript:void(0)" class="add_to_cart" data-product_id="'.$prod->product_id.'" data-product_price="'.$sell_price.'" data-product_title="'.$prod->product_title.'">
													<i class="fa fa-shopping-cart"></i> Buy Now
												</a>';
											}
											else
											{
												$list_view_html.='<a href="'.$product_link.'">
													<i class="fa fa-shopping-cart"></i> Buy Now
												</a>';
											}
											
											$list_view_html.='<a href="'.$wishlist_href.'" class="add_to_wish_list" data-product_id="'.$prod->product_id.'">
												<i class="fa fa-heart"></i> Wishlist
											</a>
											<a href="javascript:void(0)" class="add_to_compare" data-product_id="'.$prod->product_id.'">
												<i class="fa fa-signal"></i> Compare
											</a>
										</div>
									</div>
								</div>
							</li>';
							
							if($i%4==0){ $grid_view_html.='</ul>'; }
							
							$i++;
						}

						?><div id="productgrid">
							<?php echo $grid_view_html; ?>
						</div>
						<div class="mt40" id="productlist">
							<ul><?php echo $list_view_html; ?></ul>
						</div>
						
						<div class="mt40 clearfix">
							<?=create_pagination($base_url, $total_rows, 20); ?>
						</div><?php
					}
					else
					{
						?><p style="border:1px solid green;padding:5px;width:100%;font-size:16px;">No available products!</p><?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>


<?php
if((isset($catinfo->seo_title) && !empty($catinfo->seo_title)) || (isset($catinfo->seo_content) && !empty($catinfo->seo_content)))
{
	?><section class="footer-seo-box">
		<div class="container">
			<div class="inner">
				<div class="about-box">
					<h1 itemprop="name"><?=$catinfo->seo_title?></h2>
					<p itemprop="description"><?=$catinfo->seo_content?></p>
				</div>
			</div>
		</div>
	</section><?php
}
?>


<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery('#sortby').change(function()
	{
		var sortby = jQuery(this).find('option:selected').val();
		jQuery.cookie("sortby", sortby, {expires:1, path:'/'});
		window.location.replace('<?=$base_url?>');
	});
});
</script>