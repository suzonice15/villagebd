<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('homeslider_title') ? 'has-error' : ''?>">
					<label for="homeslider_title">Slider Title<span class="required">*</span></label>
					<input type="text" class="form-control" name="homeslider_title" id="homeslider_title" value="<?php echo set_value('homeslider_title'); ?>">
				</div>
				
				<div class="form-group <?=form_error('target_url') ? 'has-error' : ''?>">
					<label for="target_url">Target URL</label>
					<input type="text" class="form-control" name="target_url" id="target_url" value="<?php echo set_value('target_url'); ?>">
				</div>
				
				
					<div class="form-group">
					<label>Slider Position<span class="required">*</span></label>
				
							<select name="slider_position" id="slider_position" class="form-control">
							    <option value="main">Main</option>
							    <option value="left">Left</option>
						   <option value="right">Right</option>


							    </select>
					
				</div>
				
				<div class="form-group featured-image <?=form_error('homeslider_banner') ? 'has-error' : ''?>">
					<label>Slider Banner<span class="required">*</span></label>
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="homeslider_banner" value="<?php echo set_value('homeslider_banner'); ?>"/>
						</div>
						<div class="col-sm-6">
							<input type="file" class="form-control" name="featured_image"/>
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