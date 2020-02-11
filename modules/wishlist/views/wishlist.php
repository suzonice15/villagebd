<section id="mpart">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?=base_url()?>">Home</a></li>
			<li class="active"><?=$page_title?></li>
		</ul>
		<div class="row mt40 wishlistpage"> 
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="cart-info">
					
					<?php if(count($products)>0){ ?>
					
					<table class="table table-striped table-bordered">
						<tr>
							<th class="image text-center">Image</th>
							<th	class="name">Product Name</th>
							<th class="quantity">Stock</th>
							<th class="price">Price</th>
							<th class="total text-center">Action</th>
						</tr>
						
						<?php
						foreach($products as $prod)
						{
							$featured_image = get_post_meta($prod->product_id, 'featured_image');
							$featured_image = get_media_path($featured_image);
							
							// product price
							$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;

							?><tr>
								<td class="image text-center">
									<a href="<?=base_url('products/'.$prod->product_name)?>">
										<img src="<?=$featured_image?>" height="30" width="30">
									</a>
								</td>
								<td class="name">
									<a href="<?=base_url('products/'.$prod->product_name)?>">
										<?=$prod->product_title?>
									</a>
								</td>
								<td class="quantity">In Stock</td>
								<td class="price">Tk <?=number_format($sell_price, 2)?></td>
								<td class="total text-center">
									<a href="javascript:void(0)" class="mr10 add_to_cart" data-product_id="<?=$prod->product_id?>" data-product_price="<?=$sell_price?>" data-product_title="<?=$prod->product_title?>">
										<i class="fa fa-shopping-cart"></i>
									</a>

									<a href="javascript:void(0)" class="remove_wish_list" date-product_id="<?=$prod->product_id?>">
										<i class="tooltip-test font24 fa fa-remove" data-original-title="Remove"></i>
									</a>
								</td>
							</tr><?php
						}
						?>
					</table>
					
					<?php }else{ ?>
					
						<p style="width:100%;max-width:300px;margin:50px auto;font-size:20px;font-weight:600;text-align:center;">
							No available products!
							<br/><br/>
							<a href="<?=base_url()?>" class="btn btn-new full" style="width:100%;">Back To Home</a>
						</p>
					
					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
</section>