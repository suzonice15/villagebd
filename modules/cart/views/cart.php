<section id="mpart">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?=base_url()?>">Home</a></li>
			<li class="active">Shopping Cart</li>
		</ul>
		<div class="cartpage">
			<h1 class="pagetitle mt40">Shopping Cart</h1>
			<div class="row mt40">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt40column">
					<div class="cart-info">
						<form method="POST" action="<?=base_url('cart/update_cart')?>">
							<table class="table table-striped table-bordered">
								<tr>
									<th class="action text-center"></th>
									<th class="name text-center">Product</th>
									<th class="image text-center">Image</th>
									<th class="quantity text-center">Qty</th>
									<th class="price text-center">Price</th>
									<th class="total text-right">Sub-Total</th>
								</tr>
								
								<?php $i = 1?>
								
								<?php foreach($this->cart->contents() as $items) : ?>
								
								<?=form_hidden($i.'[rowid]', $items['rowid'])?>
								
								<?php
								$featured_image=get_post_meta($items['id'], 'featured_image');
								$featured_image=get_media_path($featured_image);
								?>

								<tr>
									<td class="total text-center">
										<a class="remove_from_cart" data-rowid="<?=$items['rowid']?>"><i class="tooltip-test font24 fa fa-remove"></i></a>
									</td>
									<td class="text-center">
										<?=get_product_title($items['id'])?>

										<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

										<p>
											<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

													<strong><?=$option_name?>:</strong> <?=$option_value?><br />

											<?php endforeach?>
										</p>

										<?php endif?>

									</td>
									<td class="image text-center">
										<a>
											<img src="<?=$featured_image?>" height="30" width="30"/>
										</a>
									</td>
									<td class="text-center"><?=form_input(array('name'=>$i.'[qty]', 'value'=>$items['qty'], 'maxlength'=>'3', 'size'=>'5'))?></td>
									<td class="text-center"><?=$this->cart->format_number($items['price'])?></td>
									<td class="text-right">Tk <?=$this->cart->format_number($items['subtotal'])?></td>
								</tr>

								<?php $i++?>

								<?php endforeach?>

								<tr>
									<td colspan="4" class="update-cart">
										<a class="btn btn-primary" href="<?=base_url('checkout')?>">Checkout</a>
										<input type="submit" value="Update your Cart">
									</td>
									<td class="text-center"><strong>Total</strong></td>
									<td class="cart-total text-right">Tk <?=$this->cart->format_number($this->cart->total())?></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>