<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('blog_title') ? 'has-error' : ''?>">
					<label for="blog_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="blog_title" id="blog_title" value="<?php echo set_value('blog_title'); ?>">
				</div>
				
				<div class="form-group <?=form_error('blog_name') ? 'has-error' : ''?>">
					<label for="blog_name">Name</label>
					<input type="text" class="form-control the_name" name="blog_name" id="blog_name" value="<?php echo set_value('blog_name'); ?>">
				</div>
				
				<div class="form-group <?=form_error('blog_summary') ? 'has-error' : ''?>">
					<label for="blog_summary">Summary</label>
					<textarea class="form-control" rows="15" name="blog_summary" id="blog_summary"><?php echo set_value('blog_summary'); ?></textarea>
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