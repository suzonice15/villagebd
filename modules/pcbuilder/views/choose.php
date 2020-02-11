<?php
$filter_category	= isset($_GET['filter_category']) ? $_GET['filter_category'] : null;
$filter_name 		= isset($_GET['filter_name']) ? $_GET['filter_name'] : null;

$component_slug 	= strtolower(str_replace(array('_', ' ', '---'), array('-', '-', '-'), $component_name));

$subcategories 		= get_subcategories($component_id);

$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));
// echo '<pre>component_name: '; print_r($component_name); echo '</pre>';
// echo '<pre>component_slug: '; print_r($component_slug); echo '</pre>';
// echo '<pre>component_id: '; print_r($subcategories); echo '</pre>';
?>

<section id="mpart">
	<div class="container">
		<ul class="breadcrumb" ">
			you are in: 
			<li >
				<a href="<?=base_url()?>" >
					<span >Home</span>
				</a>
			</li>
			<li>
				<a href="<?=base_url('pcbuilder')?>" >
					<span >PC Builder</span>
				</a>
			</li>
			<li >
				<span ><?=$page_title?></span>
			</li>
		</ul>

		<div class="pcbuilder-container-box">
			<div class="button-links">
				<div class="row">
					<div class="col-sm-9">
						<div class="row">
							<div class="col-sm-1">
								<a class="btn btn-primary" href="<?=base_url('pcbuilder')?>">Back</a>
							</div>
							<div class="col-sm-9">
								<div class="row">
									<?php
									if(sizeof($subcategories)>0)
									{
										?><div class="col-sm-6">
											<select id="filter_category" class="form-control form-control-search">
												<option value="">Categories</option>
												<?php
												foreach($subcategories as $subcat)
												{
													if($component_slug=='motherboard')
													{
														$pc_builder_processor = $this->session->userdata('pc_builder_processor');

														if($pc_builder_processor=='amd')
														{
															$amd_motherboard_ids = get_option('amd_motherboard_ids');
															$amd_motherboard_ids = explode(',', $amd_motherboard_ids);

															if(in_array($subcat->category_id, $amd_motherboard_ids))
															{
																echo $subcat->category_id.'---<br>';
																echo '<option value="'.$subcat->category_id.'" '.($filter_category==$subcat->category_id ? 'selected' : null).'>'.$subcat->category_title.'</option>';
															}
														}
														else
														{
															$intel_motherboard_ids = get_option('intel_motherboard_ids');
															$intel_motherboard_ids = explode(',', $intel_motherboard_ids);

															if(in_array($subcat->category_id, $intel_motherboard_ids))
															{
																echo '<option value="'.$subcat->category_id.'" '.($filter_category==$subcat->category_id ? 'selected' : null).'>'.$subcat->category_title.'</option>';
															}
														}
													}
													elseif($component_slug=='ram-1' || $component_slug=='ram-1')
													{
														$pc_builder_processor = $this->session->userdata('pc_builder_processor');

														if($pc_builder_processor=='amd')
														{
															$amd_ram_ids = get_option('amd_ram_ids');
															$amd_ram_ids = explode(',', $amd_ram_ids);

															if(in_array($subcat->category_id, $amd_ram_ids))
															{
																echo '<option value="'.$subcat->category_id.'" '.($filter_category==$subcat->category_id ? 'selected' : null).'>'.$subcat->category_title.'</option>';
															}
														}
														else
														{
															$intel_ram_ids = get_option('intel_ram_ids');
															$intel_ram_ids = explode(',', $intel_ram_ids);

															if(in_array($subcat->category_id, $intel_ram_ids))
															{
																echo '<option value="'.$subcat->category_id.'" '.($filter_category==$subcat->category_id ? 'selected' : null).'>'.$subcat->category_title.'</option>';
															}
														}
													}
													else
													{
														echo '<option value="'.$subcat->category_id.'" '.($filter_category==$subcat->category_id ? 'selected' : null).'>'.$subcat->category_title.'</option>';
													}
												}
												?>
											</select>
										</div><?php
									}
									?>
									<div class="col-sm-6">
										<div class="input-group input-group-search">
											<input type="text" id="filter_name" class="form-control" value="<?=$filter_name?>" placeholder="Search">
											<span class="input-group-btn">
												<button type="button" id="filter_name_btn" class="btn btn-default btn-lg btn-search"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<form id="sortby" class="form-inline pull-right">
							Sort By :
							<?php
							$sortby = 'price_asc';
							if(isset($_COOKIE['sortby'])){ $sortby = $_COOKIE['sortby']; }
							?>
							<select class="span2">
								<option value="default" <?=$sortby=='default'?'selected':null?>>Default</option>
								<option value="name_asc" <?=$sortby=='name_asc'?'selected':null?>>Name A-Z</option>
								<option value="name_desc" <?=$sortby=='name_desc'?'selected':null?>>Name Z-A</option>
								<option value="price_asc" <?=$sortby=='price_asc'?'selected':null?>>Pirce Low to High</option>
								<option value="price_desc" <?=$sortby=='price_desc'?'selected':null?>>Pirce High to Low</option>
								<option value="rating_desc" <?=$sortby=='rating_desc'?'selected':null?>>Rating High to Low</option>
							</select>
						</form>
					</div>
				</div>
			</div>

			<hr class="break break20">

			<div class="component-table-wrapper">
				<table class="table component-table">
					<tbody class="pcbuilder-tbody">
						<tr class="component-title">
							<td class="image-col"><b>Image</b></td>
							<td class="name-col"><b>Product Name</b></td>
							<td class="price-col"><b>Price</b></td>
							<td class="action-col"><b>Action</b></td>
						</tr>

						<?php
						if(count($products)>0)
						{
							$component_detail=null;

							foreach($products as $prod)
							{
								$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
								$product_link 	= base_url($prod->product_name);

								$product_availability = $prod->product_availability ? $prod->product_availability : 'In Stock';
								$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));

								// product price
								$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;

		                        $component_detail.='<tr class="component-detail">
		                        	<td class="image-col image-col-ada">
		                        		<div class="image">
		                        			<a target="_blank" href="'.$product_link.'">
		                        				<img src="'.get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_thumbs').'" alt="'.$prod->product_title.'" class="img-responsive" width="60">
		                        			</a>
		                        		</div>
		                        	</td>
		                        	<td class="name-col name-col-ada">'.$prod->product_title.'</td>
		                        	<td class="price-col price-col-ada">
		                        		<div class="price">'.formatted_price($sell_price).'</div>
		                        	</td>
		                        	<td class="action-col action-col-ada">
		                        		<a href="javascript:void(0);" class="add-to-pcbuilder" data-go-to="'.base_url('pcbuilder').'" data-component-slug="'.$component_slug.'" data-component-id="'.$component_id.'" data-product-id="'.$prod->product_id.'">Add</a>
		                        	</td>
		                        </tr>';
		                    }

		                    echo $component_detail;
						}
						?>
                    </tbody>
                </table>
							
				<div class="mt40 clearfix">
					<?=$pagination?>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery('.add-to-pcbuilder').on('click', function()
		{
			var this_added_elem = jQuery(this);
			var product_id 		= this_added_elem.attr('data-product-id');
			var component_slug 	= this_added_elem.attr('data-component-slug');
			var component_id 	= this_added_elem.attr('data-component-id');
			var go_to 			= this_added_elem.attr('data-go-to');

			var ajax_url = base_url+'ajax/add_to_pc_builder';
			
			jQuery.ajax({
				type: 'POST',
				data: 
				{
					"product_id" 		: product_id,
					"component_slug" 	: component_slug,
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
					location.href = go_to;
				}
			});
		});

		jQuery('#filter_category').change(function()
		{
			var filter_category 		= jQuery('#filter_category').val();
			var current_location 	= location.href;

			if(current_location.indexOf('?')>0)
			{
				if(current_location.indexOf('filter_category=')>0)
				{
					var current_url = current_location.split('filter_category=');
					current_url 	= current_url[0];

					location.href = current_url+'filter_category='+filter_category;
				}
				else
				{
					location.href = current_location+'&filter_category='+filter_category;
				}
			}
			else
			{
				location.href = current_location+'?filter_category='+filter_category;
			}
		});

		jQuery('#filter_name_btn').on('click', function()
		{
			var filter_name 		= jQuery('#filter_name').val();
			var current_location 	= location.href;

			if(current_location.indexOf('?')>0)
			{
				if(current_location.indexOf('filter_name=')>0)
				{
					var current_url = current_location.split('filter_name=');
					current_url 	= current_url[0];

					location.href = current_url+'filter_name='+filter_name;
				}
				else
				{
					location.href = current_location+'&filter_name='+filter_name;
				}
			}
			else
			{
				location.href = current_location+'?filter_name='+filter_name;
			}
		});

		jQuery('#sortby').change(function()
		{
			var sortby = jQuery(this).find('option:selected').val();
			jQuery.cookie("sortby", sortby, {expires:1, path:'/'});
			location.href = location.href;
		});
	});
</script>