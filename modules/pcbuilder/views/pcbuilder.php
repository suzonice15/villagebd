<?php
$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));
//echo '<pre>'; print_r($pcbuilder_settings); echo '</pre>';


$pcbuilder = array();

if($this->session->userdata('pcbuilder'))
{
	$pcbuilder = $this->session->userdata('pcbuilder');
}

//echo '<pre>'; print_r($pcbuilder); echo '</pre>';
?>


<section id="mpart">
	<div class="container">
		<ul class="breadcrumb" >
			you are in: 
			<li >
				<a href="<?=base_url()?>" >
					<span itemprop="name">Home</span>
				</a>
			</li>
			<li >
				<span ><?=$page_title?></span>
			</li>
		</ul>

		<?php
		if(isset($_GET['ref']) && $_GET['ref']=='quote')
		{
			if(isset($_GET['message']) && $_GET['message']=='success')
			{
				?><div class="alert alert-success alert-dismissable">
					<strong>Success! </strong>
					Your quotation request has been submitted successfully. We will send a quotation to "<?=$user_email?>"
					<a href="<?=base_url('pcbuilder')?>" class="close" data-dismiss="alert">×</a>
				</div><?php
			}
			elseif(isset($_GET['message']) && $_GET['message']=='false')
			{
				?><div class="alert alert-danger alert-dismissable">
					<strong>Failed! </strong>
					Your quotation request failed to submit! Please try again later.
					<a href="<?=base_url('pcbuilder')?>" class="close" data-dismiss="alert">×</a>
				</div><?php
			}
			elseif(isset($_GET['message']) && $_GET['message']=='field-empty')
			{
				?><div class="alert alert-warning alert-dismissable">
					<strong>Warning! </strong>
					Please choose a "<?=isset($_GET['field']) ? $_GET['field'] : null?>"
					<a href="<?=base_url('pcbuilder')?>" class="close" data-dismiss="alert">×</a>
				</div><?php
			}
		}
		?>

		<div class="pcbuilder-container-box">
			<div class="button-links">
				<div class="left-button pull-left">
					<?php
					if($this->session->userdata('loggedin'))
					{
						?><a id="qet_a_quote" class="btn btn-primary loggedin" href="<?=base_url('pcbuilder/quote')?>">Get a Quote</a><?php
					}
					else
					{
						?><a id="qet_a_quote" class="btn btn-primary" href="<?=base_url('account/?redirect_url='.base_url('pcbuilder/quote'))?>">Get a Quote</a><?php
					}
					?>
				</div>
				<div class="right-button pull-right ">
					<a id="buy_now" class="btn btn-primary" href="javascript:void(0);">Buy Now</a>
					<a id="save_pc" class="btn btn-primary" href="<?=base_url('pcbuilder/save')?>">Save</a>
					<a id="download" class="btn btn-primary" href="<?=base_url('pcbuilder/makepdf')?>" target="_blank">Download</a>
				</div>
			</div>

			<hr class="break break20">

			<div class="component-table-wrapper">
				<table class="table component-table">
					<?php
					if(sizeof($pcbuilder_settings)>0)
					{
						$component_html='<tr class="component-title">
							<td class="component"><b>Component</b></td>
							<td class="image"><b>Image</b></td>
							<td class="name"><b>Product Name</b></td>
							<td class="price"><b>Price</b></td>
							<td class="action"><b>Action</b></td>
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

							if(isset($pcbuilder[$component_slug.'-'.$component_id]) && !empty($pcbuilder[$component_slug.'-'.$component_id]))
							{
								$prod 			= get_product($pcbuilder[$component_slug.'-'.$component_id]);
								$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
								$product_link 	= base_url($prod->product_name);

								// product price
								$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;

								$price_total[] 	= $sell_price;

								$component_html.='<tr data-slr="'.$slr.'" data-component="'.$component_name.'" class="component-detail component-detail-chooses '.$required_cls.' required-filled">
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
									<td class="action action-choose choose">
										<span><a href="javascript:void(0);" class="remove-from-pcbuilder" data-component-slug="'.$component_slug.'" data-component-id="'.$component_id.'">Remove</a></span>
										<span><a class="choose-component change-component" href="'.base_url('pcbuilder/choose/'.$component_id.'/1').'">Choose</a></span>
									</td>
								</tr>';
							}
							else
							{
								$component_html.='<tr data-slr="'.$slr.'" data-component="'.$component_name.'" class="'.$required_cls.' required-empty">
									<td class="component"><b>'.$component_name.'</b></td>
									<td class="name"></td>
									<td class="image"></td>
									<td class="price"></td>
									<td class="action action-choose">
										<a class="choose-component" href="'.base_url('pcbuilder/choose/'.$component_id.'/1').'">Choose</a>
									</td>
								</tr>';
							}

							$slr++;
						}

						$component_html.='<tr class="total-amount">
							<td colspan="3"></td>
							<td class="amount"><b>Total: </b>'.(array_sum($price_total) > 0 ? formatted_price(array_sum($price_total)) : 0).'</td>
							<td></td>
						</tr>';

						echo $component_html;
					}
					?>
				</table>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery('.remove-from-pcbuilder').on('click', function()
	{
		var this_added_elem = jQuery(this);
		var component_slug 	= this_added_elem.attr('data-component-slug');
		var component_id 	= this_added_elem.attr('data-component-id');

		var ajax_url = base_url+'ajax/remove_from_pc_builder';
		
		jQuery.ajax({
			type: 'POST',
			data: 
			{
				"component_slug"	: component_slug,
				"component_id" 		: component_id,
			},
			url: ajax_url,
			beforeSend: function()
			{
				this_added_elem.parent().text('wait..');
				this_added_elem.remove();
			},
			success: function(result)
			{
				location.href = location.href;
			}
		});
	});


	jQuery('.choose-component').on('click', function(e)
	{
		e.preventDefault();

		var this_elem_slr = jQuery(this).parents('tr').attr('data-slr');

		var required_empty_elm = 0;
		var data_component = '';

		jQuery('table.component-table tr.required.required-empty').each(function()
		{
			var this_slr = jQuery(this).attr('data-slr');

			if(parseInt(this_slr) < parseInt(this_elem_slr))
			{
				var component = jQuery(this).attr('data-component');

				if(data_component=='')
				{
					data_component = '<div class="alert alert-warning alert-dismissable"><strong>Warning! </strong>Please choose a "'+component+'"<button type="button" class="close" data-dismiss="alert">×</button></div>';
				}
				
				required_empty_elm++;
			}
		});

		if(required_empty_elm > 0)
		{
			jQuery('.alert-dismissable').remove();

			jQuery('.breadcrumb').after(data_component);
			
			jQuery('html, body').animate({
				scrollTop: 0
			}, 500);
		}
		else
		{
			location.href = jQuery(this).attr('href');	
		}
	});


	jQuery('#qet_a_quote').on('click', function(e)
	{
		e.preventDefault();

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
			location.href = jQuery(this).attr('href');	
		}
	});


	jQuery('#save_pc').on('click', function(e)
	{
		e.preventDefault();

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
			location.href = jQuery(this).attr('href');	
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
					"cart_from"	: 'pcbuilder',
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


	jQuery('#download').on('click', function(e)
	{
		e.preventDefault();

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
			window.open(jQuery(this).attr('href'));
		}
	});
});
</script>