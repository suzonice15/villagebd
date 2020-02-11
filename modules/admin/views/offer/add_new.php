<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('offer_title') ? 'has-error' : ''?>">
					<label for="offer_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="offer_title" id="offer_title" value="<?php echo set_value('offer_title'); ?>">
				</div>
				
				<div class="form-group <?=form_error('offer_name') ? 'has-error' : ''?>">
					<label for="offer_name">Name</label>
					<input type="text" class="form-control the_name" name="offer_name" id="offer_name" value="<?php echo set_value('offer_name'); ?>">
				</div>
				
				<div class="form-group <?=form_error('offer_summary') ? 'has-error' : ''?>">
					<label for="offer_summary">Summary</label>
					<textarea class="form-control" rows="15" name="offer_summary" id="offer_summary"><?php echo set_value('offer_summary'); ?></textarea>
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