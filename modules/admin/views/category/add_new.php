<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('category_title') ? 'has-error' : ''?>">
					<label for="category_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="category_title" value="<?php echo set_value('category_title'); ?>">
				</div>
				
				<div class="form-group <?=form_error('category_name') ? 'has-error' : ''?>">
					<label for="category_name">Name<span class="required">*</span></label>
					<input type="text" class="form-control the_name" name="category_name" value="<?php echo set_value('category_name'); ?>">
				</div>
				
				<div class="form-group <?=form_error('parent_id') ? 'has-error' : ''?>">
					<?php
					$categories = get_categories();
					//echo '<pre>'; print_r($categories); echo '</pre>';
					$option = NULL;
					if(count($categories) > 0)
					{
						foreach($categories as $cat)
						{
							$option.='<option value="'.$cat->category_id.'">'.$cat->category_title.'</option>';
						}
					}
					?>
					<label for="parent_id">Select Parent</label>
					<select class="form-control select2" name="parent_id">
						<option value="0">--- choose ---</option>
						<?php echo $option; ?>
					</select>
				</div>
				
				<div class="form-group <?=form_error('rank') ? 'has-error' : ''?>">
					<label for="rank">Rank<span class="required">*</span></label>
					<input type="number" class="form-control" name="rank" value="<?php echo set_value('rank'); ?>">
				</div>
					<div class="form-group <?=form_error('rank') ? 'has-error' : ''?>">
					<label for="rank">Category Starting Price<span class="required">*</span></label>
					<input type="text" class="form-control the_name" name="category_price" value="">
				</div>
				<div class="form-group <?=form_error('rank') ? 'has-error' : ''?>">
					<label for="rank">Category Icon <span class="required">*</span></label>
					<input type="text" class="form-control the_name" name="category_icon" value="">
				</div>
				<!--<div class="form-group featured-image" hidden>
					<label>Category Icon</label>
					<input type="file" class="form-control" name="featured_image"/>
				</div>-->
				
				<div class="form-group featured-image">
					<label>Category Banner</label>
					<input type="file" class="form-control" name="category_banner"/>
				</div>
				
				<div class="form-group <?=form_error('banner_target_url') ? 'has-error' : ''?>">
					<label for="banner_target_url">Category Banner Target URL</label>
					<input type="text" class="form-control" name="banner_target_url" value="<?php echo set_value('banner_target_url'); ?>">
				</div>
				
				<div class="form-group featured-image">
					<label>Category Banner For Category Page</label>
					<input type="file" class="form-control" name="category_banner2"/>
				</div>
				
				<div class="form-group <?=form_error('banner_target_url2') ? 'has-error' : ''?>">
					<label for="banner_target_url2">Category Banner Target URL</label>
					<input type="text" class="form-control" name="banner_target_url2" value="<?php echo set_value('banner_target_url2'); ?>">
				</div>
				
				<div class="form-group featured-image">
					<label>Category Gallery1</label>
					<input type="file" class="form-control" name="category_gallery1"/>
				</div>
				
				<div class="form-group featured-image">
					<label>Category Gallery2</label>
					<input type="file" class="form-control" name="category_gallery2"/>
				</div>
				
				<div class="form-group featured-image">
					<label>Category Gallery3</label>
					<input type="file" class="form-control" name="category_gallery3"/>
				</div>
				
				<div class="form-group <?=form_error('target_url1') ? 'has-error' : ''?>">
					<label for="target_url1">Gallery Target URL 01</label>
					<input type="text" class="form-control" name="target_url1" value="<?php echo set_value('target_url1'); ?>">
				</div>
				
				<div class="form-group <?=form_error('target_url2') ? 'has-error' : ''?>">
					<label for="target_url2">Gallery Target URL 02</label>
					<input type="text" class="form-control" name="target_url2" value="<?php echo set_value('target_url2'); ?>">
				</div>
				
				<div class="form-group <?=form_error('target_url3') ? 'has-error' : ''?>">
					<label for="target_url3">Gallery Target URL 03</label>
					<input type="text" class="form-control" name="target_url3" value="<?php echo set_value('target_url3'); ?>">
				</div>
						
				<div class="form-group <?=form_error('pcbuilder_category') ? 'has-error' : ''?>">
					<label for="pcbuilder_category">PC Builder Category</label>
					<?php echo form_dropdown('pcbuilder_category', array('no'=>'No', 'yes'=>'Yes'), set_value('pcbuilder_category'), array('class'=>'form-control')); ?>
				</div>
				
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-group <?=form_error('seo_title') ? 'has-error' : ''?>">
							<label for="seo_title">SEO Title</label>
							<input type="text" class="form-control" name="seo_title" id="seo_title" value="<?php echo set_value('seo_title'); ?>">
						</div>

						<div class="form-group <?=form_error('seo_meta_title') ? 'has-error' : ''?>">
							<label for="seo_meta_title">SEO Meta Title</label>
							<input type="text" class="form-control" name="seo_meta_title" id="seo_meta_title" value="<?php echo set_value('seo_meta_title'); ?>">
						</div>

						<div class="form-group <?=form_error('seo_keywords') ? 'has-error' : ''?>">
							<label for="seo_keywords">SEO Keywords</label>
							<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?php echo set_value('seo_keywords'); ?>">
						</div>
				
						<div class="form-group <?=form_error('seo_content') ? 'has-error' : ''?>">
							<label for="seo_content">SEO Content</label>
							<textarea class="form-control" rows="5" name="seo_content" id="seo_content"><?php echo set_value('seo_content'); ?></textarea>
						</div>
				
						<div class="form-group <?=form_error('seo_meta_content') ? 'has-error' : ''?>">
							<label for="seo_meta_content">SEO Meta Content</label>
							<textarea class="form-control" rows="5" name="seo_meta_content" id="seo_meta_content"><?php echo set_value('seo_meta_content'); ?></textarea>
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