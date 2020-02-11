<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('service_title') ? 'has-error' : ''?>">
					<label for="service_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="service_title" value="<?=set_value('service_title') ? set_value('service_title') : isset($data_row->service_title) ? $data_row->service_title : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('service_name') ? 'has-error' : ''?>">
					<label for="service_name">Name</label>
					<input type="text" class="form-control the_name" name="service_name" value="<?=set_value('service_name') ? set_value('service_name') : isset($data_row->service_name) ? $data_row->service_name : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('service_summary') ? 'has-error' : ''?>">
					<label for="service_summary">Summary</label>
					<textarea class="form-control" rows="15" name="service_summary" id="service_summary"><?=set_value('service_summary') ? set_value('service_summary') : isset($data_row->service_summary) ? $data_row->service_summary : NULL?></textarea>
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