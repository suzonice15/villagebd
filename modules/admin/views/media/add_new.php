<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('media_title') ? 'has-error' : ''?>">
					<label for="media_title">Media Title<span class="required">*</span></label>
					<input type="text" class="form-control" name="media_title" id="media_title" value="<?php echo set_value('media_title'); ?>">
				</div>
				
				<div class="form-group featured-image">
					<label>Media File<span class="required">*</span></label>
					<input type="file" class="form-control" name="featured_image"/>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>