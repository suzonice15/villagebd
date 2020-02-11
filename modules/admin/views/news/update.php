<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('news_title') ? 'has-error' : ''?>">
					<label for="news_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="news_title" value="<?=set_value('news_title') ? set_value('news_title') : isset($data_row->news_title) ? $data_row->news_title : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('news_name') ? 'has-error' : ''?>">
					<label for="news_name">Name</label>
					<input type="text" class="form-control the_name" name="news_name" value="<?=set_value('news_name') ? set_value('news_name') : isset($data_row->news_name) ? $data_row->news_name : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('news_summary') ? 'has-error' : ''?>">
					<label for="news_summary">Summary</label>
					<textarea class="form-control" rows="15" name="news_summary" id="news_summary"><?=set_value('news_summary') ? set_value('news_summary') : isset($data_row->news_summary) ? $data_row->news_summary : NULL?></textarea>
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