<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
			<?php
			$date = date("Y-m-d");
			$visitors = get_hitcounters($date);
			?>
			<div class="info-box-content">
				<span class="info-box-text">Today's Visitor</span>
				<span class="info-box-number"><?=count($visitors)?> people<?=count($visitors) > 1 ? 's' : NULL?></span>
			</div>
		</div>
	</div>
	
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Total Product</span>
				<span class="info-box-number"><?php echo get_products_total(); ?> products</span>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Total Customers</span>
				<span class="info-box-number"><?php echo get_users_total('customer'); ?> customers</span>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Latest Inquiries</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table no-margin">
					<thead>
						<tr>
							<th><input type="checkbox" id="checkAll"></th>
							<th>Subject</th>
							<th>Name</th>
							<th>Phone</th>
							<th class="text-right">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT * FROM `inquiry` ORDER BY inquiry_id DESC LIMIT 7";
						$result = get_result($sql);
						if(isset($result))
						{
							$html=NULL;
							foreach($result as $row)
							{
								$class = ($row->status == 'unread') ? 'unread' : 'read';
								$html.='<tr>
									<td>
										<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$row->inquiry_id.'" />
									</td>
									<td>
										<a class="'.$class.'" href="'.base_url().'admin/inquiry/view/'.$row->inquiry_id.'">'.$row->subject.'</a>
									</td>
									<td>
										<a class="'.$class.'" href="'.base_url().'admin/inquiry/view/'.$row->inquiry_id.'">'.$row->name.'</a>
									</td>
									<td>
										<a class="'.$class.'" href="'.base_url().'admin/inquiry/view/'.$row->inquiry_id.'">'.$row->phone.'</a>
									</td>
									<td class="action text-right">
										<a href="'.base_url().'admin/inquiry/view/'.$row->inquiry_id.'">Update</a>
										<a href="'.base_url().'admin/inquiry/delete/'.$row->inquiry_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
									</td>
								</tr>';
							}
							echo $html;
						}
						?>
					</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer clearfix">
				<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Inquiries</a>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Recently Added Products</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				$featured_products = get_featured_products('DESC', 4);
				if(count($featured_products) > 0)
				{
					echo '<ul class="products-list product-list-in-box">';
					
						foreach($featured_products as $prod)
						{
							// product image
                            $image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));

							// product price
							$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
							
							echo '<li class="item">
								<div class="product-img">
									<img src="'.get_photo((isset($image->media_path) ? $image->media_path : null), 'uploads/product/','mini_thumbs').'" alt="'.$prod->product_title.'">
								</div>
								<div class="product-info">
									<a href="'.base_url('products/'.$prod->product_name).'" class="product-title">
										'.$prod->product_title.'
										<span class="label label-warning pull-right">'.$sell_price.'</span>
									</a>
									<br/><a href="'.base_url('products/'.$prod->product_name).'">View</a> | 
									<a href="'.base_url().'admin/product/update/'.$prod->product_id.'">Edit</a>
								</div>
							</li>';
						}
						
					echo '</ul>';
				}
				?>
			</div>
			<div class="box-footer clearfix">
				<a href="<?=base_url('admin/product')?>" class="btn btn-sm btn-default btn-flat pull-right">View All Products</a>
			</div>
		</div>
	</div>
</div>