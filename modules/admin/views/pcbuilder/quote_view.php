<?php
$user_data = get_row('users', 'user_id', $quote->user_id);

$user_name = $user_email = $user_phone = null;

if($user_data)
{
	$user_name 	= $user_data->user_name;
	$user_email = $user_data->user_email;
	$user_phone = $user_data->user_phone;
}

$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));
//echo '<pre>'; print_r($pcbuilder_settings); echo '</pre>';
?>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST">
					<div class="box">
						<div class="box-body">
							<div class="result view">
								<p><b>Name:</b> <?=$user_name?></p>
								<p><b>Email:</b> <?=$user_email?></p>
								<p><b>Phone:</b> <?=$user_phone?></p>
							</div>
						</div>
					</div>

					<div class="result">
						<table class="table component-table">
							<?php
							$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));
							//echo '<pre>'; print_r($pcbuilder_settings); echo '</pre>';

							$pc_componentes = unserialize($quote->components);

							if(sizeof($pcbuilder_settings)>0)
							{
								$component_html='<tr class="component-title">
									<td class="component"><b>Component</b></td>
									<td class="image"><b>Image</b></td>
									<td class="name"><b>Product Name</b></td>
									<td class="price"><b>Price</b></td>
								</tr>';

								$slr = 1;

								$price_total = array();

								foreach($pcbuilder_settings as $component)
								{
									$component_name = $component['component_name'];
									$component_id 	= $component['component_id'];
									$required 		= $component['required'];
									$required_cls 	= $required==1 ? 'required' : null;
									$component_slug = strtolower(str_replace(array('_', ' ', '---'), array('-', '-', '-'), $component_name));

									if(isset($pc_componentes[$component_slug.'-'.$component_id]) && !empty($pc_componentes[$component_slug.'-'.$component_id]))
									{
										$prod 			= get_product($pc_componentes[$component_slug.'-'.$component_id]);
										$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
										$product_link 	= base_url($prod->product_name);
									
										// product price
										$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;

										$price_total[] 	= $sell_price;

										$component_html.='<tr data-slr="'.$slr.'" class="component-detail component-detail-chooses '.$required_cls.'">
											<td class="component component-td">'.$component_name.'</td>
											<td class="image image-td image-td-chooses">
												<div class="image choose-images">
													<a target="_blank" href="'.$product_link.'">
														<img src="'.get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_thumbs').'" class="img-responsive" width="60" height="60">
													</a>
												</div>
											</td>
											<td class="name name-td name-td-chooses">'.$prod->product_title.'</td>
											<td class="price price-td price-td-chooses">
												<div class="price">'.formatted_price($sell_price).'</div>
											</td>
										</tr>';
										
										$slr++;
									}
								}

								$component_html.='<tr class="total-amount">
									<td colspan="3"></td>
									<td class="amount"><b>Total: </b>'.(array_sum($price_total) > 0 ? formatted_price(array_sum($price_total)) : 0).'</td>
								</tr>';

								echo $component_html;
							}
							?>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>