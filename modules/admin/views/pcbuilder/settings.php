<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label>AMD Motherboard IDs</label>
							<input type="text" class="form-control" name="amd_motherboard_ids" value="<?=get_option('amd_motherboard_ids')?>">
						</div>
						<div class="form-group">
							<label>AMD RAM IDs</label>
							<input type="text" class="form-control" name="amd_ram_ids" value="<?=get_option('amd_ram_ids')?>">
						</div>
						<div class="form-group">
							<label>Intel Motherboard IDs</label>
							<input type="text" class="form-control" name="intel_motherboard_ids" value="<?=get_option('intel_motherboard_ids')?>">
						</div>
						<div class="form-group">
							<label>Intel RAM IDs</label>
							<input type="text" class="form-control" name="intel_ram_ids" value="<?=get_option('intel_ram_ids')?>">
						</div>
						<div class="form-group">
							<label>CPU / Processor Category ID</label>
							<input type="text" class="form-control" name="cpu_id" value="<?=get_option('cpu_id')?>">
						</div>
						<div class="components-group">
							<div class="components-inner">
								<?php
								$component_no = 1;

								$pcbuilder_settings = get_option('pcbuilder_settings');
								$pcbuilder_settings = unserialize($pcbuilder_settings);
								
								if(isset($componentes) && sizeof($componentes)>0)
								{
									$pcbuilder_settings = $componentes;
								}
								
								if(is_array($pcbuilder_settings) && sizeof($pcbuilder_settings)>0)
								{
									//echo '<pre>'; print_r($pcbuilder_settings); echo '</pre>';
									
									foreach($pcbuilder_settings as $component)
									{
										$component_name = $component['component_name'];
										$component_id 	= $component['component_id'];
										$required 		= $component['required'];

										?><div class="box box-warning" style="border-color:#f39c12;">
											<div class="box-header">
												<h3 class="box-title"><?=$component_name?></h3>
												<div class="component_closer">x</div>
											</div>
											<div class="box-body">
												<div class="form-group">
													<div class="row">
														<div class="col-sm-4">
															<label>Component Name</label>
															<input type="text" class="form-control" name="component[<?=$component_no?>][component_name]" value="<?=$component_name?>">
														</div>
														<div class="col-sm-4">
															<label>Component ID</label>
															<input type="text" class="form-control" name="component[<?=$component_no?>][component_id]" value="<?=$component_id?>">
														</div>
														<div class="col-sm-4">
															<label>Is Required to Choose <small>0/1</small></label>
															<input type="number" class="form-control" name="component[<?=$component_no?>][required]" value="<?=$required?>" max="1" min="0">
														</div>
													</div>
												</div>
											</div>
										</div><?php
										
										$component_no++;
									}
								}
								?>
							</div>
							<input type="hidden" name="component_no" value="<?=$component_no?>">
							<div class="form-inline">
								<a class="add_another_component" href="javascript:void(0)">Add Another Component </a>
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