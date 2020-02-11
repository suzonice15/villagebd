<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-group <?=form_error('post_title') ? 'has-error' : ''?>">
							<label for="post_title">Page Title<span class="required">*</span></label>
							<input type="text" class="form-control" name="post_title" id="post_title" value="<?php if(set_value('post_title')){ echo set_value('post_title'); }elseif(isset($page->post_title)){ echo $page->post_title; } ?>">
						</div>
						
						<div class="form-group <?=form_error('post_name') ? 'has-error' : ''?>">
							<label for="post_name">Pale Link<span class="required">*</span></label>
							<input type="text" class="form-control" name="post_name" id="post_name" value="<?php if(set_value('post_name')){ echo set_value('post_name'); }elseif(isset($page->post_name)){ echo $page->post_name; } ?>">
						</div>
				
						<div class="form-group <?=form_error('post_content') ? 'has-error' : ''?>">
							<label for="post_content">Page Content<span class="required">*</span></label>
							<textarea class="textarea form-control" rows="15" name="post_content" id="post_content"><?php if(set_value('post_content')){ echo set_value('post_content'); }elseif(isset($page->post_content)){ echo $page->post_content; } ?></textarea>
						</div>
				
						<div class="form-group <?=form_error('post_excerpt') ? 'has-error' : ''?>">
							<label for="post_excerpt">Page Excerpt</label>
							<textarea class="textarea form-control" rows="5" name="post_excerpt" id="post_excerpt"><?php if(set_value('post_excerpt')){ echo set_value('post_excerpt'); }elseif(isset($page->post_excerpt)){ echo $page->post_excerpt; } ?></textarea>
						</div>
					</div>
				</div>
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-group <?=form_error('template') ? 'has-error' : ''?>">
							<label for="template">Select Template</label>
							<?php
							$template_option = array(
								'default' 		=> 'Default',
								'full_width' 	=> 'Full Width',
								'contact' 		=> 'Contact',
								'trackorder' 	=> 'Track Order',
								'career' 		=> 'Career'
							);
							
							$selected_template = set_value('template') ? set_value('template') : get_post_meta($page->post_id, 'template');
							
							echo form_dropdown('template', $template_option, $selected_template, array('class'=>'form-control', 'id'=>'template'));
							?>
						</div>
					</div>
				</div>
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-group <?=form_error('seo_title') ? 'has-error' : ''?>">
							<label for="seo_title">SEO Title</label>
							<input type="text" class="form-control" name="seo_title" id="seo_title" value="<?php if(set_value('seo_title')){ echo set_value('seo_title'); }else{ echo get_post_meta($page->post_id, 'seo_title'); } ?>">
						</div>

						<div class="form-group <?=form_error('seo_keywords') ? 'has-error' : ''?>">
							<label for="seo_keywords">SEO Keywords</label>
							<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?php if(set_value('seo_keywords')){ echo set_value('seo_keywords'); }else{ echo get_post_meta($page->post_id, 'seo_keywords'); } ?>">
						</div>
				
						<div class="form-group <?=form_error('seo_content') ? 'has-error' : ''?>">
							<label for="seo_content">SEO Content</label>
							<textarea class="textarea form-control" rows="5" name="seo_content" id="seo_content"><?php if(set_value('seo_content')){ echo set_value('seo_content'); }else{ echo get_post_meta($page->post_id, 'seo_content'); } ?></textarea>
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