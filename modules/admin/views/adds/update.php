<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('adds_title') ? 'has-error' : ''?>">
					<label for="adds_title">Adds Title<span class="required">*</span></label>
					<input type="text" class="form-control" name="adds_title" id="adds_title" value="<?php if(set_value('adds_title')){ echo set_value('adds_title'); }elseif(isset($row->adds_title)){ echo $row->adds_title; } ?>">
				</div>
				
				<div class="form-group <?=form_error('adds_link') ? 'has-error' : ''?>">
					<label for="adds_link">Adds URL</label>
					<input type="text" class="form-control" name="adds_link" id="adds_link" value="<?php if(set_value('adds_link')){ echo set_value('adds_link'); }elseif(isset($row->adds_link)){ echo $row->adds_link; } ?>">
				</div>
				
				<div class="form-group featured-image <?=form_error('media_file') ? 'has-error' : ''?>">
					<label>Media File<span class="required">*</span></label>
					<input type="file" class="form-control" name="media_file"/>
				</div>
				
				<div class="form-group">
					<label for="adds_type">Select Type</label>
					<?php
					echo form_error('adds_type', '<p class="required-error">', '</p>');
					
					if(set_value('adds_type')) $adds_type = set_value('adds_type');
					elseif($row->adds_type) $adds_type = $row->adds_type;
					else $adds_type = '';
					
					echo form_dropdown('adds_type', array(
						'sidebar' 		=> 'Sidebar',
						'slider' 	=> 'Home Bottom Slider ',
						'cat_sidebar' 	=> 'Category Sidebar',
					), $adds_type, array('class' => 'form-control'));
					?>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
	</div>
</div>