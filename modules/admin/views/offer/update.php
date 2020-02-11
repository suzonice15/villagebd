<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('offer_title') ? 'has-error' : ''?>">
					<label for="offer_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="offer_title" value="<?=set_value('offer_title') ? set_value('offer_title') : isset($data_row->offer_title) ? $data_row->offer_title : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('offer_name') ? 'has-error' : ''?>">
					<label for="offer_name">Name</label>
					<input type="text" class="form-control the_name" name="offer_name" value="<?=set_value('offer_name') ? set_value('offer_name') : isset($data_row->offer_name) ? $data_row->offer_name : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('offer_summary') ? 'has-error' : ''?>">
					<label for="offer_summary">Summary</label>
					<textarea class="form-control" rows="15" name="offer_summary" id="offer_summary"><?=set_value('offer_summary') ? set_value('offer_summary') : isset($data_row->offer_summary) ? $data_row->offer_summary : NULL?></textarea>
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