<section id="mpart">
	<div class="container">
		<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
			You are in: 
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?=base_url()?>" itemprop="item">
					<span itemprop="name">Home</span>
				</a>
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?=base_url('pcbuilder')?>" itemprop="item">
					<span itemprop="name">PC Builder</span>
				</a>
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name"><?=$page_title?></span>
			</li>
		</ul>

		<hr class="break break20">

		<?php
		if(isset($_GET['pc_id']))
		{
			?><div class="pcbuilder-container-box">
				<div class="button-links">
					<div class="left-button pull-left">
						<a class="btn btn-primary" href="<?=base_url('pcbuilder')?>">Build Your Own PC</a>
					</div>
					<div class="right-button pull-right ">
						<a id="buy_now" class="btn btn-primary" href="javascript:void(0);">Buy Now</a>
					</div>
				</div>

				<hr class="break break20">

				<div class="component-table-wrapper">
					<table class="table component-table">
						<?php
						$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));
						//echo '<pre>'; print_r($pcbuilder_settings); echo '</pre>';

						$pc_componentes = array();

						if(isset($saved_pc))
						{
							$pc_componentes = unserialize($saved_pc->components);
						}

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
									$prod = get_product($pc_componentes[$component_slug.'-'.$component_id]);
									if(!empty($prod))
									{
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
									}
								}
								else
								{
									$component_html.='<tr data-slr="'.$slr.'" class="'.$required_cls.'">
										<td class="component"><b>'.$component_name.'</b></td>
										<td class="name"></td>
										<td class="image"></td>
										<td class="price"></td>
									</tr>';
								}

								$slr++;
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
			</div>
			<?php
		}
		else
		{
			$customer_avatar = get_user_meta($this->session->user_id, 'customer_avatar');
			$customer_avatar = $customer_avatar ? $customer_avatar : base_url('images/avtar.jpg');

			?><div class="profile">
				<div class="row">
					<div class="col-sm-3 account-sidebar">
						<div class="innerbox">
							<div class="coverphoto">
								<img class="avatar" src="<?=$customer_avatar?>">
								<div class="name"><?=$this->session->user_name?></div>
							</div>
							<ul class="nav">
								<li>
									<a href="<?=base_url('account')?>">
										<span class="glyphicon glyphicon-cog"></span> My Profile
									</a>
								</li>
								<li>
									<a href="<?=base_url('account/?page=myorders')?>">
										<span class="glyphicon glyphicon-briefcase"></span> My Orders
									</a>
								</li>
								<li>
									<a href="<?=base_url('pcbuilder/savedpc')?>">
										<span class="glyphicon glyphicon-cog"></span> Saved PC
									</a>
								</li>
								<li>
									<a href="<?=base_url('account/?page=changepw')?>">
										<span class="glyphicon glyphicon-qrcode"></span> Change Password
									</a>
								</li>
								<li>
									<a href="<?=base_url('logout')?>">
										<span class="glyphicon glyphicon-log-out"></span> Logout
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-sm-9 account-content">
						<div class="row">
							<div class="col-sm-8">
								<div class="page-header">
									<h1><?=$page_title?></h1>
								</div>
							</div>
						</div>
							
						<div class="innerbox editbox">
							<div class="table-responsive">
								<table class="table table-bpced table-hover">
								<thead>
									<tr>
										<td>PC ID</td>
										<td>Name</td>
										<td>Description</td>
										<td>Date Added</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
									<?php
									if(sizeof($saved_pcs)>0)
									{
										foreach($saved_pcs as $pc)
										{
											echo '<tr>
												<td>#'.$pc->pc_id.'</td>
												<td>'.$pc->name.'</td>
												<td>'.$pc->description.'</td>
												<td>'.$pc->created_time.'</td>
												<td class="text-right action-saved-pc">
													<a href="'.base_url('pcbuilder/savedpc/?pc_id='.$pc->pc_id).'"><i class="fa fa-eye"></i></a>
													<a href="javascript:void(0);" data-pc-id="'.$pc->pc_id.'" class="delete delete-saved-pc"><i class="fa fa-remove"></i></a>
												</td>
											</tr>';
										}
									}
									?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div><?php
		}
		?>
	</div>
</section>

<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery('.delete-saved-pc').on('click', function()
	{
		if(confirm('Are you sure to delete?'))
		{
			var this_added_elem = jQuery(this);
			var pc_id 			= this_added_elem.attr('data-pc-id');

			var ajax_url = base_url+'ajax/delete_saved_pc';
			
			jQuery.ajax({
				type: 'POST',
				data: 
				{
					"pc_id" : pc_id,
				},
				url: ajax_url,
				beforeSend: function()
				{
					this_added_elem.text('wait..');
				},
				success: function(result)
				{
					location.href = location.href;
				}
			});
		}
	});


	jQuery('#buy_now').on('click', function(e)
	{
		e.preventDefault();

		var this_added_elem = jQuery(this);
		var required_empty_elm = 0;
		var data_component = '';

		jQuery('table.component-table tr.required.required-empty').each(function()
		{
			var component = jQuery(this).attr('data-component');

			if(data_component=='')
			{
				data_component = '<div class="alert alert-warning alert-dismissable"><strong>Warning! </strong>Please choose a "'+component+'"<button type="button" class="close" data-dismiss="alert">×</button></div>';
			}

			required_empty_elm++;
		});

		if(required_empty_elm > 0)
		{
			jQuery('.alert-dismissable').remove();

			jQuery('.breadcrumb').after(data_component);
		}
		else
		{
			var ajax_url = base_url+'ajax/add_to_cart_from_pc_builder';
			
			jQuery.ajax({
				type: 'POST',
				data: 
				{
					"cart_from"	: 'savedpc',
					"pc_id"		: '<?=(isset($_GET['pc_id']) ? $_GET['pc_id'] : null)?>',
				},
				url: ajax_url,
				beforeSend: function()
				{
					this_added_elem.html(this_added_elem.text()+'<small>wait...</small>');
				},
				success: function(result)
				{
					this_added_elem.find('small').remove();

					jQuery('html, body').animate({scrollTop:jQuery('header .cartitems').position().top}, 'slow');
					
					var response = JSON.parse(result);
					
					//jQuery('aside#minicart').addClass('active');
					jQuery('aside#minicart .innerbox').html(response.html);
					//setTimeout(function(){ jQuery('aside#minicart').removeClass('active'); }, 5000);

					jQuery('header .cartitems .itemcount span.itemno').text(response.current_cart_item);
					//jQuery('aside#cart .total span.price').text(response.current_cart_total);

					jQuery('header .cartitems a').trigger('click');
				}
			});
		}
	});
});
</script>