<?php
$logo = get_option('logo');

if($_SERVER['HTTP_HOST']=='localhost')
{
	$root_url = $_SERVER['DOCUMENT_ROOT'].'/village-bd.com';

	$logo = $root_url.str_replace('http://localhost/village-bd.com', '', $logo);
}
else
{
	$root_url = $_SERVER['DOCUMENT_ROOT'];

	$logo = $root_url.str_replace('https://www.village-bd.com', '', $logo);
}

$title = $page_title.' | '.get_option('site_title');
?>

<title><?=$title?></title>
<link rel="shortcut icon" href="<?=get_option('icon')?>">

<div class="container">
	<div>
		<img src="<?php echo $logo; ?>" style="display:inline-block;width:auto;height:30px;">
		<div style="display:inline-block;font-size:16px;background:green;color:#fff;border-radius:3px;text-transform:lowercase;padding:0 5px;">PcBilder Items</div>
	</div>

	<hr class="break break20">

	<div class="component-table-wrapper">
		<table class="table component-table">
			<?php
			$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));

			if(sizeof($pcbuilder_settings)>0)
			{
				$component_html='<tr class="component-title">
					<td class="component"><b>Component</b></td>
					<td class="image"><b>Image</b></td>
					<td class="name"><b>Product Name</b></td>
					<td class="price"><b>Price</b></td>
				</tr>';

				$price_total = array();

				foreach($pcbuilder_settings as $component)
				{
					$component_name = $component['component_name'];
					$component_id 	= $component['component_id'];
					$component_slug = strtolower(str_replace(array('_', ' ', '---'), array('-', '-', '-'), $component_name));

					if(isset($pc_componentes[$component_slug.'-'.$component_id]) && !empty($pc_componentes[$component_slug.'-'.$component_id]))
					{
						$prod 			= get_product($pc_componentes[$component_slug.'-'.$component_id]);
						$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
						$product_link 	= base_url($prod->product_name);

						// product price
						$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
					
						$price_total[] 	= $sell_price;

						$component_html.='<tr class="component-detail component-detail-chooses">
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

<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap.min.css')?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('css/font-awesome.min.css')?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('css/style.css')?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('css/custom.css')?>"/>