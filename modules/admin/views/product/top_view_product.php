<div class="box">
	<div class="box-body">
		<form method="POST">
			<div class="result">
				<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><input type="checkbox" id="checkAll"></th>
						<th>Product</th>
						<th>Price</th>
						<th class="text-right">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(!empty($results))
					{
						$html=NULL;
						
						foreach($results as $result)
						{
							$featured_image = get_post_meta($result->product_id, 'featured_image');
							$featured_image = get_media_path($featured_image);
							
							// product price
							$sell_price = !empty($result->discount_price) ? $result->discount_price : $result->product_price;

							$html.='<tr>
								<td>
									<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$result->product_id.'" />
								</td>
								<td>
									<img src="'.$featured_image.'" width="30" height="30"> &nbsp; '.$result->product_title.'
								</td>
								<td>৳ '.$sell_price.'</td>
								<td class="action text-right">
                                    <a href="'.base_url().'admin/product/update/'.$result->product_id.'">Update</a>
                                    <a href="'.base_url().'admin/product/delete/'.$result->product_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
								</td>
							</tr>';
						}
						
						echo $html;
					}
					?>
				</tbody>
				</table>
			</div>
		</form>
	</div>
</div>