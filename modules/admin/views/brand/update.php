<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('brand_name') ? 'has-error' : ''?>">
					<label for="brand_name">Name<span class="required">*</span></label>
					<input type="text" class="form-control" name="brand_name" value="<?=set_value('brand_name') ? set_value('brand_name') : isset($data_row->brand_name) ? $data_row->brand_name : NULL?>">
				</div>
				
				<div class="form-group featured-image">
					<label>Featured Image<span class="required">*</span></label>
					<div class="row">
						<div class="col-sm-1">
							<img src="<?=get_media_path($data_row->media_id)?>" height="30">
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