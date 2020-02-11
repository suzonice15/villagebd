<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="mapping-group">
							<div class="mapping-inner">
								<?php
								if(sizeof($cpu_products)>0)
								{
									foreach($cpu_products as $prod)
									{
										?><div class="box box-warning" style="border-color:#f39c12;">
											<div class="box-header">
												<h3 class="box-title"><?=$prod->product_title?></h3>
											</div>
											<div class="box-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>AMD Motherboard IDs</label>
															<input type="text" class="form-control" name="product_mapping_amd_motherboard_ids_<?=$prod->product_id?>" value="<?php echo get_option('product_mapping_amd_motherboard_ids_'.$prod->product_id); ?>">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>AMD RAM IDs</label>
															<input type="text" class="form-control" name="product_mapping_amd_ram_ids_<?=$prod->product_id?>" value="<?php echo get_option('product_mapping_amd_ram_ids_'.$prod->product_id); ?>">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>Intel Motherboard IDs</label>
															<input type="text" class="form-control" name="product_mapping_intel_motherboard_ids_<?=$prod->product_id?>" value="<?php echo get_option('product_mapping_intel_motherboard_ids_'.$prod->product_id); ?>">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Intel RAM IDs</label>
															<input type="text" class="form-control" name="product_mapping_intel_ram_ids_<?=$prod->product_id?>" value="<?php echo get_option('product_mapping_intel_ram_ids_'.$prod->product_id); ?>">
														</div>
													</div>
												</div>
											</div>
										</div><?php
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>