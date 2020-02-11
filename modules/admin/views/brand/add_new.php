<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('brand_name') ? 'has-error' : ''?>">
					<label for="brand_name">Name<span class="required">*</span></label>
					<input type="text" class="form-control" name="brand_name" id="brand_name" value="<?php echo set_value('brand_name'); ?>">
				</div>
				
				<div class="form-group featured-image">
					<label>Featured Image</label>
					<input type="file" class="form-control" name="featured_image"/>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>