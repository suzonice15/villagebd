<?php
/*echo '<pre>'; print_r($prods); echo '</pre>';*/

if(count($products)>0)
{
	$prod=$products;
	foreach($products as $p)
	{
		// product price
		$sell_price = !empty($p->discount_price) ? $p->discount_price : $p->product_price;

		$prods['product_id'][] = $p->product_id;
		$prods['product_title'][] = $p->product_title;
		$prods['product_name'][] = $p->product_name;
		$prods['product_price'][] = $sell_price;
		$prods['product_summary'][] = $p->product_summary;
		$prods['product_description'][] = $p->product_description;
		$prods['product_specification'][] = $p->product_specification;
	}

	$percentage=((100)/(count($products)));
}
?>

<section id="mpart">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?=base_url()?>">Home</a></li>
			<li class="active"><?=$page_title?></li>
		</ul>
		<div class="mt40 comparepage">			 
			<div class="cart-info">

				<?php if(count($products)>0){ ?>

				<table class="table table-striped table-bordered compare">
					<tbody>
						<tr>
							<td class="title tproduct">Product</td>
							<?php
							$i=0; foreach($prods['product_title'] as $ptitle)
							{
								echo '<td class="name" width="'.$percentage.'%">
									<a href="'.base_url('products/'.$prods['product_name'][$i]).'">
										<h3 class="heading4">'.$ptitle.'</h3>
									</a>
								</td>';
								
								$i++;
							}
							?>
						</tr>
						<tr>
							<td class="title timage">Image</td>
							<?php
							foreach($prods['product_id'] as $pid)
							{
								$featured_image = get_post_meta($pid, 'featured_image');
								$featured_image = get_media_path($featured_image);
								
								echo '<td><img src="'.$featured_image.'"></td>';
							}
							?>
						</tr>
						<tr>
							<td class="title tprice">Price</td>
							<?php
							foreach($prods['product_price'] as $pprice)
							{
								echo '<td><b>Tk '.number_format($pprice, 2).'</b></td>';
							}
							?>
						</tr>
						
						<tr class="description">
							<td class="title tspec">Specifications</td>
							<?php
							$pspecifications=null;
							
							foreach($prods['product_specification'] as $specifications)
							{
								$pspecifications = json_decode($specifications);
								
								echo '<td>';
								
								if(count($pspecifications)>0)
								{
									foreach($pspecifications as $key=>$val)
									{
										echo '<p>'.$key.' : '.$val.'</p>';
									}
								}
								
								echo '</td>';
							}
							?>
						</tr>
						
						<tr class="description">
							<td class="title tsummary">Summary</td>
							<?php
							foreach($prods['product_summary'] as $psummary)
							{
								echo '<td>'.$psummary.'</td>';
							}
							?>
						</tr>
						
						<tr>
							<td class="title"></td>
							<?php
							$price_i=0; foreach($prods['product_id'] as $pid)
							{
								echo '<td>
									<a href="javascript:void(0)" class="btn btn-primary add_to_cart" data-product_id="'.$pid.'" data-product_price="'.$prods['product_price'][$price_i].'" data-product_title="'.$prods['product_title'][$price_i].'" style="width:100%;margin-bottom:5px;">
										Add to Cart
									</a>

									<a href="javascript:void(0)" class="btn btn-primary remove_compare" data-product_id="'.$pid.'" style="width:100%;">Remove</a>
								</td>';
								
								$price_i++;
							}
							?>
						</tr>
					</tbody>
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
</section>