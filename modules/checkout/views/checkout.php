<?php
$cart_items = $with_emi_subtotal = $without_emi_subtotal = 0;
foreach ($this->cart->contents() as $key=>$cart_item)
{
	$item_id 	= $cart_item['id'];
	$item_qty 	= $cart_item['qty'];

    if(!is_array($cart_item) OR !isset($cart_item['price']) OR ! isset($cart_item['qty'])){ continue; }

    $cart_items += $item_qty;

    // cart subtotal with emi & without emi
	$cartprod 			= get_product($item_id);
	$with_emi_price 	= $cartprod->product_price;
	$without_emi_price 	= !empty($cartprod->discount_price) ? $cartprod->discount_price : $cartprod->product_price;

	$with_emi_subtotal += $with_emi_price * $item_qty;
	$without_emi_subtotal += $without_emi_price * $item_qty;
}
?>

<section id="mpart">
	<div class="container">
		<div class="checkoutpage <?php if(!$this->session->user_id){ echo 'account'; }?> mt20">
			<div class="row">
				<?php
				if(!empty($cart_items))
				{
					$billing_name = $billing_email = $billing_phone = $billing_address = $billing_city = $billing_state = null;

					if($this->session->user_id)
					{
						$billing_name 		= get_user_meta($this->session->user_id, 'billing_name');
						$billing_email 		= get_user_meta($this->session->user_id, 'billing_email');
						$billing_phone 		= get_user_meta($this->session->user_id, 'billing_phone');
						$billing_address 	= get_user_meta($this->session->user_id, 'billing_address');
						$billing_city 		= get_user_meta($this->session->user_id, 'billing_city');
						$billing_state 		= get_user_meta($this->session->user_id, 'billing_state');

						$billing_name 		= (!$billing_phone) ? $user_name : $billing_name;
						$billing_phone 		= (!$billing_phone) ? $user_phone : $billing_phone;
						$billing_email 		= (!$billing_phone) ? $user_email : $billing_email;
					}
					else
					{
						?><div class="col-sm-12">
							<div class="login-suggestion">
								Already have account? <a href="<?=base_url('account/?redirect_url='.base_url('checkout'))?>">Login Now</a>! or  <a href="<?=base_url('account/signup')?>">Register!</a>
							</div>
						</div><?php
					}

					?><form name="checkout" id="checkout" method="post">
						<div class="col-sm-4">
							<div class="checkoutsteptitle">Customer Information <a class="modify">&nbsp;</a></div>
							<div class="checkoutstep">
								<div class="form-group">
									<label for="billing_name"><span class="required">*</span>Name</label>
									<?php echo form_input(array('name'=>'billing_name', 'class'=>'form-control '.(form_error('billing_name') ? 'validation-error' : null), 'id'=>'billing_name', 'value'=>$billing_name)); ?>
								</div>

								<div class="form-group">
									<label for="billing_email"><span class="required">*</span>Email</label>
									<?php echo form_input(array('name'=>'billing_email', 'class'=>'form-control '.(form_error('billing_email') ? 'validation-error' : null), 'id'=>'billing_email', 'value'=>$billing_email)); ?>
								</div>

								<div class="form-group">
									<label for="billing_phone"><span class="required">*</span>Phone</label>
									<?=form_input(array('name'=>'billing_phone', 'class'=>'form-control '.(form_error('billing_phone') ? 'validation-error' : null), 'id'=>'billing_phone', 'value'=>$billing_phone))?>
								</div>

								<div class="form-group">
									<label for="billing_address"><span class="required">*</span>Address <small class="fred">Ex: House B-158, Road 22, Mohakhali DOHS</small></label>
									<?=form_input(array('name'=>'billing_address', 'class'=>'form-control '.(form_error('billing_address') ? 'validation-error' : null), 'id'=>'billing_address', 'value'=>$billing_address))?>
								</div>

								<div class="form-group">
									<label for="billing_city"><span class="required">*</span>City</label>
									<?=form_input(array('name'=>'billing_city', 'class'=>'form-control '.(form_error('billing_city') ? 'validation-error' : null), 'id'=>'billing_city', 'value'=>$billing_city))?>
								</div>

								<div class="form-group">
									<label for="billing_state"><span class="required">*</span>Division</label>
									<?php											
									echo form_dropdown('billing_state', array(
										'Dhaka' 		=> 'Dhaka',
										'Chittagong' 	=> 'Chittagong',
										'Barisal' 		=> 'Barisal',
										'Khulna' 		=> 'Khulna',
										'Rajshahi' 		=> 'Rajshahi',
										'Sylhet' 		=> 'Sylhet',
										'Rangpur' 		=> 'Rangpur',
									), $billing_state, array('class'=>'form-control'));
									?>
								</div>

								<div class="form-group mb0">
									<label for="order_note">Order Notes</label>
									<?=form_input(array('name'=>'order_note', 'class'=>'form-control', 'id'=>'order_note', 'value'=>set_value('order_note')))?>
								</div>
							</div>
						</div>
							
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-6">
									<div class="checkoutsteptitle">Payment Method <a class="modify">&nbsp;</a></div>
									<div class="checkoutstep payment_type">
										<div class="form-group mb0 text-center">
											<!-- <label>
												<?php //echo form_input(array('type'=>'radio', 'name'=>'payment_type', 'value'=>'cash_on_delivery', 'checked'=>'checked')); ?>
												<span>Cash On Delivery</span>
											</label> -->
											<label>
												<?php echo form_input(array('type'=>'radio', 'name'=>'payment_type', 'value'=>'directpay', 'checked'=>'checked')); ?>
												<span>Online Payment</span>
											</label>
										</div>
										<div class="accepted-logo">
											<h5>We Accepted:</h5>
											<img class="logo logo-visa" src="<?=base_url('images/card-logo.png')?>">
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="checkoutsteptitle">Delivery Method <a class="modify">&nbsp;</a></div>
									<div class="checkoutstep shipping_charge">
										<div class="form-group mb0">
											<label>
												<?php
												$flat_shipping_charge = get_option('flat_shipping_charge');
												$flat_shipping_charge = $flat_shipping_charge ? $flat_shipping_charge : 0;
												?>

												<?php echo form_input(array('type'=>'radio', 'name'=>'shipping_charge', 'value'=>$flat_shipping_charge, 'checked'=>'checked')); ?>
												<span>Dhaka City & Chittagong City <?=formatted_price($flat_shipping_charge, false)?></span>
											</label>

											<label>
												<?php
												$courier_shipping_charge = get_option('courier_shipping_charge');
												$courier_shipping_charge = $courier_shipping_charge ? $courier_shipping_charge : 0;
												?>

												<?php echo form_input(array('type'=>'radio', 'name'=>'shipping_charge', 'value'=>$courier_shipping_charge)); ?>
												<span>Out Of Dhaka & Chittagong City  <?=formatted_price($courier_shipping_charge, false)?></span>
											</label>

											<hr class="break break5">

											<label class="with-emi <?php echo form_error('emi') ? 'validation-error' : null; ?>">
												<?php echo form_input(array('type'=>'radio', 'name'=>'emi', 'value'=>'with_emi')); ?>
												<span>With EMI</span>
											</label>
											<label class="without-emi <?php echo form_error('emi') ? 'validation-error' : null; ?>">
												<?php echo form_input(array('type'=>'radio', 'name'=>'emi', 'value'=>'without_emi')); ?>
												<span>Without EMI</span>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="checkoutsteptitle mt30">Order Review <a class="modify">&nbsp;</a></div>
							<div class="checkoutstep">
								<div class="cart-info">
									<table class="table table-striped table-bordered">
										<tr>
											<th class="name">Product</th>
											<th class="total text-right" width="20%">Price</th>
										</tr>
										
										<?php $i = 1?>
										
										<?php foreach($this->cart->contents() as $items) : ?>
										
										<?php
										$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $items['id']));
										$featured_image_path = get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_thumbs');
										?>

										<tr>
											<td class="product-item">
												<a>
													<img src="<?php echo $featured_image_path; ?>" height="30" width="30"/>
													
													<?=form_hidden('products[items]['.$items['id'].'][featured_image]', $featured_image_path)?>
												</a>
												<div class="item-name-and-price">
													<div class="item-name">
														<?=get_product_title($items['id'])?>
													</div>
													
													<div class="item-price">
														৳ <?=$this->cart->format_number($items['price'])?> x <?=$items['qty']?>
													</div>
													
													<?=form_hidden('products[items]['.$items['id'].'][qty]', $items['qty'])?>
													
													<?=form_hidden('products[items]['.$items['id'].'][price]', $this->cart->format_number($items['price']))?>
												</div>
												
												<?=form_hidden('products[items]['.$items['id'].'][name]', get_product_title($items['id']))?>
											</td>
											<td class="text-right">
												৳ <?=$this->cart->format_number($items['subtotal'])?>
												
												<?=form_hidden('products[items]['.$items['id'].'][subtotal]', $this->cart->format_number($items['subtotal']))?>
											</td>
										</tr>
										<input type="hidden"    class="coupon_id_product" value="<?php echo $items['id'] ?>">
											<input type="hidden"    class="coupon_id_product_quantity" value="<?php echo $items['qty'] ?>">

										<?php $i++?>

										<?php endforeach; ?>

										<input type="hidden" id="with_emi_subtotal" value="<?php echo $with_emi_subtotal; ?>">
										<input type="hidden" id="without_emi_subtotal" value="<?php echo $without_emi_subtotal; ?>">
								

									</table>
									
									<?php
									$order_total = $this->cart->total();
									$order_total = ($order_total) + ($flat_shipping_charge);
									$order_subtotal_emi_charge=$order_total-$with_emi_subtotal;
							//	echo $order_subtotal_emi_charge;
									?>
								<input type="hidden" id="order_subtotal_emi_charge" value="<?php echo $order_subtotal_emi_charge; ?>">
							

									
									<table class="table table-striped table-bordered mb0">
										<tbody>
											<tr>
												<td><span class="extra bold ">Sub-Total</span></td>
												<td class="text-right sub-total-price"><span class="bold">৳ <span class="sub-total-amout-in-text"><?=$this->cart->format_number($this->cart->total())?></span></span></td>
											</tr>
											<tr>
												<td><span class="extra bold">Shipping Charge</span></td>
												<td class="text-right">
													<span class="bold shipping-charge">৳ <span class="shipping-charge-in-text"><?=$this->cart->format_number($flat_shipping_charge)?></span></span>
												</td>
											</tr>
											
											
											
											<tr>
												<td><span class="extra bold">Coupon Code</span></td>
												<td class="text-right">
													<span class="bold shipping-charge">৳ <span class="coupon-charge-in-text"></span></span>
												</td>
											</tr>
											
											
											
											
											
											
<!-- 											<tr class="emi-box" style="display:none;">
												<td><span class="extra bold">EMI Charge</span></td>
												<td class="text-right ">7%</td>
											</tr> -->
											<tr>
												<td>
													<span class="extra bold totalamout">Total</span>
														<input type="hidden" name="active_emi" id="active_emi" value="1">
												</td>
												<td class="text-right">
													<span class="bold totalamout">৳ <span class="total-amout-in-text"><?=$this->cart->format_number($order_total)?></span></span>
												
													<?=form_hidden('order_total', $this->cart->format_number($order_total))?>

													<?=form_hidden('order_sub_total', $this->cart->total())?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
						
						
						
						<div class="col-md-12">
                                <h2></h2>
                               
                                <div class="checkoutsteptitle">Promo Code <a class="modify">&nbsp;</a></div>
                                <div class="checkoutstep">
                                <div class="row">
                                    
                                <form name="checkout" id="checkout" method="post">
                                    <div class="col-md-6">
                                    <label for="email2" class="text-success">Apply Coupon Code </label>
                                        <input type="text" id="coupon_code" class="form-control mb-2 mr-md-4" id="email2" placeholder="Enter Coupon Code" name="coupon_code">
                                        <p  style="color:red" id="coupon_error" ></p>
                                         	<input type="hidden"    id="coupon_id_check" value="0">
                                    
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                   <input type="button" style="margin-top: 5px;" class="btn btn-default" id="coupon_submit" name="submit" value="Submit">  
</form>
                                        
                                      
    
                                    </div>
                                </form>
                                </div>
                                
                                    
                            </div> 
							
							
							<div class="checkout-box order-confirmation mt30">
								<p>
									<label class="<?php echo form_error('terms_and_conditions') ? 'validation-error' : null; ?>">
										<input type="checkbox" name="terms_and_conditions" value="1" <?php echo set_value('terms_and_conditions')==1 ? 'checked' : null; ?>>
										I have read and agree to the <a href="<?=base_url('terms-and-conditions')?>">Terms &amp; Conditions</a>
									</label>
								</p>
								<div class="submit-btns">
									<input type="submit" class="btn btn-default" value="Confirm Order">
									<a href="<?=base_url()?>" class="btn btn-primary mr10">Continue Shopping</a>
								</div>
							</div>
						</div>
					</form><?php
				}
				else
				{
					?><div class="col-sm-12">
						<div class="no-product-checkout">
							<hr class="break10"/>
							<center>
								<h3 style="color:#d00;">
									You have no product on checkout.<br/><br/>
									<a class="btn btn-default" href="<?php echo base_url(); ?>">Back to Home</a>
								</h3>
							</center>
							<hr class="break20"/>
						</div>
					</div><?php
				}
				?>
			</div>
		</div>
	</div>
</section>


<script>
$(document).on('click','#coupon_submit',function(){
   var coupon_code= $('#coupon_code').val();

   var product_ids = [];
      var quantitys = [];

                  
                 
				   $.each($(".coupon_id_product"), function () {
                      
                        product_ids.push($(this).val());
                    });

                    product_ids = product_ids.join(",");
                       $.each($(".coupon_id_product_quantity"), function () {
                      
                        quantitys.push($(this).val());
                    });

                    quantitys = quantitys.join(",");
                  
                    
                   
                    $.ajax({
                        type: 'POST',
                        data: {
                            "product_ids": product_ids,
                             "coupon_code": coupon_code,
                             "quantitys":quantitys
                        },
                        url: "<?php echo base_url();?>checkout/coupon_check",
                        success: function (result) {
                            if(result == parseInt(result, 10)){
                                
                                 var coupon_id_check= $('#coupon_id_check').val();
                                 if(coupon_id_check==0){
                                     $('#coupon_id_check').val(1);
                               var total_copunprice=parseFloat(result);
                               var total_product_price=$('input[name=order_total]').val();
                                total_product_price= parseFloat(total_product_price.replace(/,/g, ''));
                              var total=parseFloat(total_product_price) +total_copunprice;
                             
                                  jQuery('.cart-info table .shipping-charge .coupon-charge-in-text').text(total_copunprice.toFixed(2));
                                   jQuery('.cart-info table .totalamout .total-amout-in-text').text(total.toFixed(2));
        jQuery('.cart-info table input[name=order_total]').val(total.toFixed(2));
        if($.isNumeric(result)){
            
        } else { 
         $('#coupon_error').text(result);
        }
         
                            } 
                            }
                            else { 
                         
                            $('#coupon_error').text(result);
                            }
                           
                           
                        }
                    });
    
});

</script>