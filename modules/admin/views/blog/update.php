<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('blog_title') ? 'has-error' : ''?>">
					<label for="blog_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="blog_title" value="<?=set_value('blog_title') ? set_value('blog_title') : isset($data_row->blog_title) ? $data_row->blog_title : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('blog_name') ? 'has-error' : ''?>">
					<label for="blog_name">Name</label>
					<input type="text" class="form-control the_name" name="blog_name" value="<?=set_value('blog_name') ? set_value('blog_name') : isset($data_row->blog_name) ? $data_row->blog_name : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('blog_summary') ? 'has-error' : ''?>">
					<label for="blog_summary">Summary</label>
					<textarea class="form-control" rows="15" name="blog_summary" id="blog_summary"><?=set_value('blog_summary') ? set_value('blog_summary') : isset($data_row->blog_summary) ? $data_row->blog_summary : NULL?></textarea>
				</div>
				
				<div class="form-group featured-image">
					<label>Featured Image<span class="required">*</span></label>
					<div class="row">
						<div class="col-sm-1">
							<img src="<?=get_media_path($data_row->media_id)?>" width="33" height="33">
						</div>
						<div class="col-sm-11">
							<input type="file" class="form-control" name="featured_image">
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>