<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('service_title') ? 'has-error' : ''?>">
					<label for="service_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="service_title" id="service_title" value="<?php echo set_value('service_title'); ?>">
				</div>
				
				<div class="form-group <?=form_error('service_name') ? 'has-error' : ''?>">
					<label for="service_name">Name</label>
					<input type="text" class="form-control the_name" name="service_name" id="service_name" value="<?php echo set_value('service_name'); ?>">
				</div>
				
				<div class="form-group <?=form_error('service_summary') ? 'has-error' : ''?>">
					<label for="service_summary">Summary</label>
					<textarea class="form-control" rows="15" name="service_summary" id="service_summary"><?php echo set_value('service_summary'); ?></textarea>
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