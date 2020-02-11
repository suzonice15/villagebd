<section id="mpart">
	<section class="container">
		<div class="row">
			<div class="col-sm-12 maincnt mt20">
				<section id="thankyou">
					<?php
					$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

					if(isset($order))
					{
						//echo '<pre>'; print_r($order); echo '</pre>';
						
						?><h1>Thank you. Your order has been received. please check your mail for details and wait for phone call.</h1>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title"><a href="javascript:void(0);" onclick="printFunction()">Print Your Order Details</a>Order Details</h3>
									</div>
									<div class="panel-body">
										<div class="cart-info">
											<table class="table table-striped table-bordered">
												<tr>
													<th colspan="2">Customer Info.</th>
												</tr>
												<tr>
													<td>
														<p><b>Name:</b> <?=$order->billing_name?></p>
														<p><b>Phone:</b> <?=$order->billing_phone?></p>
														<p><b>Email:</b> <?=$order->billing_email?></p>
														<p style="margin-bottom:0">
															<b>Address:</b><br/>
															<?=$order->billing_address?><br/>
															<?=$order->billing_city?>,<br/>
															<?=$order->billing_state?>, Bangladesh
														</p>
													</td>
												</tr>
											</table>

											<table class="table table-striped table-bordered">
												<tr>
													<th class="name">Product</th>
													<th class="price text-right">Price</th>
												</tr>
												<?php
												$product_items = unserialize($order->products);
												//echo '<pre>'; print_r($product_items); echo '</pre>';
												
												foreach($product_items['items'] as $product_id=>$item)
												{
													$featured_image = isset($item['featured_image']) ? $item['featured_image'] : null;
													?><tr>
														<td class="product-item" style="width:50%">
															<a>
																<img src="<?=$featured_image?>" height="30" width="30"/>
															</a>
															<div class="item-name-and-price">
																<div class="item-name">
																	<?=$item['name']?>
																</div>
																<div class="item-price">
																	৳ <?=$item['price']?> x <?=$item['qty']?>
																</div>
															</div>
														</td>
														<td class="text-right" style="width:50%">
															৳ <?=$item['subtotal']?>
														</td>
													</tr><?php
												}
												?>
											</table>
											
											<?php
											$shipping_charge = $order->shipping_charge;
											$shipping_charge = ($shipping_charge!='') ? $shipping_charge : 0;
											?>
									
											<table class="table table-striped table-bordered">
												<tbody>
													<tr>
														<td style="50%">
															<span class="extra bold">Payment method</span>
														</td>
														<td class="text-right" style="width:50%">
															<span class="bold"><?=ucwords(str_replace("_", " ", $order->payment_type))?></span>
														</td>
													</tr>
													<tr>
														<td style="50%">
															<span class="extra bold">Order number</span>
														</td>
														<td class="text-right" style="width:50%">
															<span class="bold"><?=($order->order_id < 10 ? 0 : '').$order->order_id?></span>
														</td>
													</tr>
													<tr>
														<td style="50%">
															<span class="extra bold">Shipping Charge</span>
														</td>
														<td class="text-right">
															<span class="bold">৳ <?=$this->cart->format_number($shipping_charge)?></span>
														</td>
													</tr>

													<?php
													if($order->emi==1)
													{
														?><tr>
															<td style="50%">
																<span class="extra bold">EMI</span>
															</td>
															<td class="text-right">
																<span class="bold">With EMI</span>
															</td>
														</tr><?php
													}
													else
													{
														?><tr>
															<td style="50%">
																<span class="extra bold">EMI Charge</span>
															</td>
															<td class="text-right">
																<span class="bold">Without EMI</span>
															</td>
														</tr><?php
													}
													?>

													<tr>
														<td style="50%">
															<span class="extra bold totalamout">Total</span>
														</td>
														<td class="text-right" style="width:50%">
															<span class="bold totalamout">৳ <?=$order->order_total?></span>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div><?php
					}
					elseif(isset($_GET['directpay']) && $_GET['directpay']=='fail')
					{
						?><h1 class="error">Sorry you have failed to place your order!</h1><?php
					}
					elseif(isset($_GET['directpay']) && $_GET['directpay']=='cancle')
					{
						?><h1 class="error">Sorry order request is cancled!</h1><?php
					}
					else
					{
						?><h1 class="error">Invalid Order Request!</h1><?php
					}
					?>
				</section>
			</div>
		</div>
	</section>
</section>

<script>function printFunction(){ window.print(); }</script>