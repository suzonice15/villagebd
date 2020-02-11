<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('news_title') ? 'has-error' : ''?>">
					<label for="news_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="news_title" id="news_title" value="<?php echo set_value('news_title'); ?>">
				</div>
				
				<div class="form-group <?=form_error('news_name') ? 'has-error' : ''?>">
					<label for="news_name">Name</label>
					<input type="text" class="form-control the_name" name="news_name" id="news_name" value="<?php echo set_value('news_name'); ?>">
				</div>
				
				<div class="form-group <?=form_error('news_summary') ? 'has-error' : ''?>">
					<label for="news_summary">Summary</label>
					<textarea class="form-control" rows="15" name="news_summary" id="news_summary"><?php echo set_value('news_summary'); ?></textarea>
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