<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-xs-6">
					<div class="box">
						<div class="box-body">
							<div class="box-body">
								<div class="form-group <?=form_error('user_name') ? 'has-error' : ''?>">
									<label for="user_name">Name<span class="required">*</span></label>
									<input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo set_value('user_name'); ?>">
								</div>
								
								<div class="form-group <?=form_error('user_email') ? 'has-error' : ''?>">
									<label for="user_email">Email<span class="required">*</span></label>
									<input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo set_value('user_email'); ?>">
								</div>
								
								<div class="form-group <?=form_error('user_type') ? 'has-error' : ''?>">
									<label for="user_type">Role<span class="required">*</span></label>
									<?php
									$user_types = get_user_roles();
									
									unset($user_types['super-admin']);

									if($this->session->user_type == 'super-admin')
									{
										$user_types['super-admin'] = 'Super Admin';
									}
									
									$selected_type = set_value('user_type') ? set_value('user_type') : null;
									
									echo form_dropdown('user_type', get_user_roles(), $selected_type, array('class'=>'form-control', 'id' => 'user_type'));
									?>
								</div>
								
								<div class="form-group <?=form_error('user_pass') ? 'has-error' : ''?>">
									<label for="user_pass">Password<span class="required">*</span></label>
									<input type="password" class="form-control" name="user_pass" id="user_pass" value="<?php echo set_value('user_pass'); ?>">
								</div>
							</div>

							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 product-manager-category-assign-box" style="display: none;">
					<div class="box">
						<div class="box-body">
							<label for="categories">Assign Categories</label>
							<div class="form-group categories checkbox <?=form_error('categories') ? 'has-error' : ''?>">
								<ul>
									<?php
									$category = array('categories' => array(), 'parent_cats' => array());

									$result = get_result("SELECT * FROM `category` WHERE `status` = 1");
									
									if(isset($result))
									{
										foreach($result as $row)
										{
											$category['categories'][$row->category_id] = $row;
											
											$category['parent_cats'][$row->parent_id][] = $row->category_id;
										}
										
										echo nested_category_checkbox_list(0, $category, array());
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery('#user_type').on('change', function()
		{
			var user_type = jQuery(this).val();

			if(user_type == 'product-manager')
			{
				jQuery('.product-manager-category-assign-box').show();
			}
			else
			{
				jQuery('.product-manager-category-assign-box').hide();
			}
		});
	});
</script>