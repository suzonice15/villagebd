<div class="row">
	<div class="col-xs-12">
		<form method="POST" id="product_form" action="<?php echo site_url('admin/order/update_order/'.$order->order_id); ?>" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Billing Info</h3>
						</div>
						<div class="box-body">
							<table class="table table-striped table-bordered table-hover">
							<tbody>
								<tr>
									<td>
										<p><b>Name:</b> <?=$order->billing_name?></p>
										<p><b>Phone:</b> <?=$order->billing_phone?></p>
										<p><b>Email:</b> <?=$order->billing_email?></p>
										<p>
											<b>Address:</b><br/>
											<?=$order->billing_address?><br/>
											<?=$order->billing_city?>,<br/>
											<?=$order->billing_state?>, <?=$order->billing_country ? $order->billing_country : 'Bangladesh'?>
										</p>
									</td>
								</tr>
							</tbody>
							</table>
						</div>
					</div>

					<?php
					if(!empty($order->order_note))
					{
						?><div class="box box-success">
							<div class="box-header">
								<h3 class="box-title">Order Notes</h3>
							</div>
							<div class="box-body">
								<p><?=$order->order_note?></p>
							</div>
						</div><?php
					}
					?>
				</div>
				<div class="col-md-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Order Info</h3>
						</div>
						<div class="box-body">
							<table class="table table-striped table-bordered">
								<tr>
									<th class="name text-center">Product</th>
									<th class="image text-center">Image</th>
									<th class="quantity text-center">Qty</th>
									<th class="price text-center">Price</th>
									<th class="total text-right">Sub-Total</th>
								</tr>
								<?php
								$product_items = unserialize($order->products);
								//echo '<pre>'; print_r($product_items); echo '</pre>';
								
								foreach($product_items['items'] as $product_id=>$item)
								{
									$featured_image = isset($item['featured_image']) ? $item['featured_image'] : null;
									?><tr>
										<td class="text-center">
											<?=$item['name']?>
										</td>
										<td class="image text-center">
											<img src="<?=$featured_image?>" height="50" width="50"/>
										</td>
										<td class="text-center">
											<?=$item['qty']?>
										</td>
										<td class="text-center">
											৳ <?=$item['price']?>
										</td>
										<td class="text-right">
											৳ <?=$item['subtotal']?>
										</td>
									</tr><?php
								}
								?>
							</table>
							<table class="table table-striped table-bordered">
								<tbody>											
									<tr>
										<td>
											<span class="extra bold totalamout">Shipping Charge</span>
										</td>
										<?php
										$shipping_charge = $order->shipping_charge;
										$shipping_charge = ($shipping_charge!='') ? $shipping_charge : 0;
										?>
										<td class="text-right">
											<span class="bold totalamout">৳ <?=$shipping_charge?></span>
										</td>
									</tr>

									<?php
									if($order->emi==1)
									{
										?><tr>
											<td>
												<span class="extra bold">EMI Charge</span>
											</td>
											<td class="text-right">
												<span class="bold">With EMI</span>
											</td>
										</tr><?php
									}
									else
									{
										?><tr>
											<td>
												<span class="extra bold">EMI Charge</span>
											</td>
											<td class="text-right">
												<span class="bold">Without EMI</span>
											</td>
										</tr><?php
									}
									?>

									<tr>
										<td>
											<span class="extra bold totalamout">Total</span>
										</td>
										<td class="text-right">
											<span class="bold totalamout">৳ <?=$order->order_total?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span class="extra bold payment_type">Payment Method</span>
										</td>
										<td class="text-right">
											<span class="bold payment_type"><?=str_replace(array('cash_on_delivery', 'directpay'), array('Cash On Delivery', 'Online Payment'), $order->payment_type)?></span>
										</td>
									</tr>

									<?php
									$sslcommerz = unserialize($order->sslcommerz);

									if(is_array($sslcommerz) && sizeof($sslcommerz)>0)
									{
										$card_type = $sslcommerz['card_type'];

										?><tr>
											<td>
												<span class="extra bold totalamout">Card Type</span>
											</td>
											<td class="text-right">
												<span class="bold card_type"><?=$card_type?></span>
											</td>
										</tr><?php
									}

									//echo '<pre>'; print_r($sslcommerz); echo '</pre>';
									?>
									<tr>
											<td>
												<span class="extra bold totalamout">Coupon Code</span>
											</td>
											<td class="text-right">
												<span class="bold card_type"><?=$order->coupon_code?></span>
											</td>
										</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-header">
							<h3 class="box-title">Actions</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="order_status">Order Status</label>
								<?php
								$order_status_options = array(
									'new'			=> 'New', 
									'pending'		=> 'Pending', 
									'processing'	=> 'Processing', 
									'completed'		=> 'Completed'
								);

								$selected_order_status = $order->order_status;

								echo form_dropdown('order_status', $order_status_options, $selected_order_status, array('class'=>'form-control'));
								?>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>