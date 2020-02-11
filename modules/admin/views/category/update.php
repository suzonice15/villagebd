<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group <?=form_error('category_title') ? 'has-error' : ''?>">
					<label for="category_title">Title<span class="required">*</span></label>
					<input type="text" class="form-control the_title" name="category_title" value="<?=set_value('category_title') ? set_value('category_title') : isset($cat_row->category_title) ? $cat_row->category_title : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('category_name') ? 'has-error' : ''?>">
					<label for="category_name">Name<span class="required">*</span></label>
					<input type="text" class="form-control the_name" name="category_name" value="<?=set_value('category_name') ? set_value('category_name') : isset($cat_row->category_name) ? $cat_row->category_name : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('parent_id') ? 'has-error' : ''?>">
					<?php
					$categories = get_categories();
					//echo '<pre>'; print_r($categories); echo '</pre>';
					$option = NULL;
					foreach($categories as $cat)
					{
						if(set_value('parent_id') == $cat->category_id){ $selected='selected'; }elseif(isset($cat_row->parent_id) && $cat_row->parent_id == $cat->category_id){ $selected='selected'; }else{ $selected=NULL; }
						
						
						$option.='<option value="'.$cat->category_id.'" '.$selected.'>'.$cat->category_title.'</option>';
					}
					?>
					<label for="category_name">Select Parent</label>
					<select class="form-control select2" name="parent_id">
						<option value="0">--- choose ---</option>
						<?php echo $option; ?>
					</select>
				</div>
				
				<div class="form-group <?=form_error('rank') ? 'has-error' : ''?>">
					<label for="rank">Rank<span class="required">*</span></label>
					<input type="number" class="form-control the_name" name="rank" value="<?=set_value('rank') ? set_value('rank') : isset($cat_row->rank) ? $cat_row->rank : NULL?>">
				</div>
				
					<div class="form-group <?=form_error('rank') ? 'has-error' : ''?>">
					<label for="rank">Category Starting Price<span class="required">*</span></label>
					<input type="text" class="form-control the_name" name="category_price" value="<?=set_value('category_price') ? set_value('category_price') : isset($cat_row->category_price) ? $cat_row->category_price : NULL?>">
				</div>
				<div class="form-group <?=form_error('rank') ? 'has-error' : ''?>">
					<label for="rank">Category Icon <span class="required">*</span></label>
					<input type="text" class="form-control the_name" name="category_icon" value="<?=set_value('category_icon') ? set_value('category_icon') : isset($cat_row->category_icon) ? $cat_row->category_icon : NULL?>">
				</div>
				
				
		
		
				<div class="form-group featured-image" hidden>
					<label>Category Icon</label>
					<?php
					$featured_image = get_media_path($cat_row->media_id);
					if(!empty($featured_image))
					{
						?><div class="row">
							<div class="col-sm-1">
								<img src="<?=$featured_image?>" width="33" height="33">
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="featured_image">
							</div>
						</div><?php
					}
					else
					{
						?><input type="file" class="form-control" name="featured_image"><?php
					}
					?>
				</div>
		
				<div class="form-group featured-image">
					<label>Category Banner</label>
					<?php
					$category_banner = get_media_path($cat_row->category_banner);
					if(!empty($category_banner))
					{
						?><div class="row">
							<div class="col-sm-1">
								<img src="<?=$category_banner?>" width="33" height="33">
								<a href="javascript:void(0)" class="remove_category_gallery_img" data-category_id="<?=$cat_row->category_id?>">Remove</a>
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="category_banner">
							</div>
						</div><?php
					}
					else
					{
						?><input type="file" class="form-control" name="category_banner"><?php
					}
					?>
				</div>
				
				<div class="form-group <?=form_error('banner_target_url') ? 'has-error' : ''?>">
					<label for="banner_target_url">Category Banner Target URL</label>
					<input type="text" class="form-control" name="banner_target_url" value="<?=set_value('banner_target_url') ? set_value('banner_target_url') : isset($cat_row->banner_target_url) ? $cat_row->banner_target_url : NULL?>">
				</div>
		
				<div class="form-group featured-image">
					<label>Category Banner For Category Page</label>
					<?php
					$category_banner2 = get_media_path($cat_row->category_banner2);
					if(!empty($category_banner2))
					{
						?><div class="row">
							<div class="col-sm-1">
								<img src="<?=$category_banner2?>" width="33" height="33">
								<a href="javascript:void(0)" class="remove_category_gallery_img" data-category_id="<?=$cat_row->category_id?>">Remove</a>
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="category_banner2">
							</div>
						</div><?php
					}
					else
					{
						?><input type="file" class="form-control" name="category_banner2"><?php
					}
					?>
				</div>
				
				<div class="form-group <?=form_error('banner_target_url2') ? 'has-error' : ''?>">
					<label for="banner_target_url2">Category Banner Target URL</label>
					<input type="text" class="form-control" name="banner_target_url2" value="<?=set_value('banner_target_url2') ? set_value('banner_target_url2') : isset($cat_row->banner_target_url2) ? $cat_row->banner_target_url2 : NULL?>">
				</div>
		
				<div class="form-group featured-image">
					<label>Category Gallery1</label>
					<?php
					$category_gallery1 = get_media_path($cat_row->category_gallery1);
					if(!empty($category_gallery1))
					{
						?><div class="row">
							<div class="col-sm-1">
								<img src="<?=$category_gallery1?>" width="33" height="33">
								<a href="javascript:void(0)" class="remove_category_gallery_img" data-category_id="<?=$cat_row->category_id?>" data-gallery_img="1">Remove</a>
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="category_gallery1">
							</div>
						</div><?php
					}
					else
					{
						?><input type="file" class="form-control" name="category_gallery1"><?php
					}
					?>
				</div>
		
				<div class="form-group featured-image">
					<label>Category Gallery2</label>
					<?php
					$category_gallery2 = get_media_path($cat_row->category_gallery2);
					if(!empty($category_gallery2))
					{
						?><div class="row">
							<div class="col-sm-1">
								<img src="<?=$category_gallery2?>" width="33" height="33">
								<a href="javascript:void(0)" class="remove_category_gallery_img" data-category_id="<?=$cat_row->category_id?>" data-gallery_img="2">Remove</a>
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="category_gallery2">
							</div>
						</div><?php
					}
					else
					{
						?><input type="file" class="form-control" name="category_gallery2"><?php
					}
					?>
				</div>
		
				<div class="form-group featured-image">
					<label>Category Gallery3</label>
					<?php
					$category_gallery3 = get_media_path($cat_row->category_gallery3);
					if(!empty($category_gallery3))
					{
						?><div class="row">
							<div class="col-sm-1">
								<img src="<?=$category_gallery3?>" width="33" height="33">
								<a href="javascript:void(0)" class="remove_category_gallery_img" data-category_id="<?=$cat_row->category_id?>" data-gallery_img="3">Remove</a>
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="category_gallery3">
							</div>
						</div><?php
					}
					else
					{
						?><input type="file" class="form-control" name="category_gallery3"><?php
					}
					?>
				</div>
				
				<div class="form-group <?=form_error('target_url1') ? 'has-error' : ''?>">
					<label for="target_url1">Gallery Target URL 01</label>
					<input type="text" class="form-control" name="target_url1" value="<?=set_value('target_url1') ? set_value('target_url1') : isset($cat_row->target_url1) ? $cat_row->target_url1 : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('target_url2') ? 'has-error' : ''?>">
					<label for="target_url2">Gallery Target URL 02</label>
					<input type="text" class="form-control" name="target_url2" value="<?=set_value('target_url2') ? set_value('target_url2') : isset($cat_row->target_url2) ? $cat_row->target_url2 : NULL?>">
				</div>
				
				<div class="form-group <?=form_error('target_url3') ? 'has-error' : ''?>">
					<label for="target_url3">Gallery Target URL 03</label>
					<input type="text" class="form-control" name="target_url3" value="<?=set_value('target_url3') ? set_value('target_url3') : isset($cat_row->target_url3) ? $cat_row->target_url3 : NULL?>">
				</div>
						
				<div class="form-group <?=form_error('pcbuilder_category') ? 'has-error' : ''?>">
					<label for="pcbuilder_category">PC Builder Category</label>
					<?php
					if(set_value('pcbuilder_category')) $pcbuilder_category = set_value('pcbuilder_category');
					elseif($cat_row->pcbuilder_category) $pcbuilder_category = $cat_row->pcbuilder_category;
					else $pcbuilder_category = '';
					
					echo form_dropdown('pcbuilder_category', array('no'=>'No', 'yes'=>'Yes'), $pcbuilder_category, array('class'=>'form-control'));
					?>
				</div>
				
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-group <?=form_error('seo_title') ? 'has-error' : ''?>">
							<label for="seo_title">SEO Title</label>
							<input type="text" class="form-control" name="seo_title" id="seo_title" value="<?php if(set_value('seo_title')){ echo set_value('seo_title'); }else{ echo $cat_row->seo_title; } ?>">
						</div>

						<div class="form-group <?=form_error('seo_meta_title') ? 'has-error' : ''?>">
							<label for="seo_meta_title">SEO Meta Title</label>
							<input type="text" class="form-control" name="seo_meta_title" id="seo_meta_title" value="<?php if(set_value('seo_meta_title')){ echo set_value('seo_meta_title'); }else{ echo $cat_row->seo_meta_title; } ?>">
						</div>

						<div class="form-group <?=form_error('seo_keywords') ? 'has-error' : ''?>">
							<label for="seo_keywords">SEO Keywords</label>
							<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?php if(set_value('seo_keywords')){ echo set_value('seo_keywords'); }else{ echo $cat_row->seo_keywords; } ?>">
						</div>
				
						<div class="form-group <?=form_error('seo_content') ? 'has-error' : ''?>">
							<label for="seo_content">SEO Content</label>
							<textarea class="form-control" rows="5" name="seo_content" id="seo_content"><?php if(set_value('seo_content')){ echo set_value('seo_content'); }else{ echo $cat_row->seo_content; } ?></textarea>
						</div>
				
						<div class="form-group <?=form_error('seo_meta_content') ? 'has-error' : ''?>">
							<label for="seo_meta_content">SEO Meta Content</label>
							<textarea class="form-control" rows="5" name="seo_meta_content" id="seo_meta_content"><?php if(set_value('seo_meta_content')){ echo set_value('seo_meta_content'); }else{ echo $cat_row->seo_meta_content; } ?></textarea>
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