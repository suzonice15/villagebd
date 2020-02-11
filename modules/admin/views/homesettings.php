<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST" action="<?=base_url('admin/homesettings')?>" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group <?=form_error('home_cat_section') ? 'has-error' : ''?>">
							<label for="site_title">Home Category Section</label>
							<input type="text" class="form-control" name="home_cat_section" id="home_cat_section" value="<?php echo get_option('home_cat_section'); ?>" placeholder="comma seperated product ids! like: 4,20">
						</div>

						<div class="form-group <?=form_error('new_offer_banner') ? 'has-error' : ''?>">
							<label for="new_offer_banner">New Offer Banner</label>
							<input type="text" class="form-control" name="new_offer_banner" id="new_offer_banner" value="<?=get_option('new_offer_banner')?>">
						</div>

						<div class="form-group <?=form_error('new_offer_url') ? 'has-error' : ''?>">
							<label for="new_offer_url">New Offer URL</label>
							<input type="text" class="form-control" name="new_offer_url" id="new_offer_url" value="<?=get_option('new_offer_url')?>">
						</div>

						<div class="form-group <?=form_error('weekly_offer_banner') ? 'has-error' : ''?>">
							<label for="weekly_offer_banner">Weekly Offer Banner</label>
							<input type="text" class="form-control" name="weekly_offer_banner" id="weekly_offer_banner" value="<?=get_option('weekly_offer_banner')?>">
						</div>

						<div class="form-group <?=form_error('weekly_offer_url') ? 'has-error' : ''?>">
							<label for="weekly_offer_url">Weekly Offer URL</label>
							<input type="text" class="form-control" name="weekly_offer_url" id="weekly_offer_url" value="<?=get_option('weekly_offer_url')?>">
						</div>

						<div class="form-group <?=form_error('live_shopping_status') ? 'has-error' : ''?>">
							<label for="live_shopping_status">Live Shopping Status</label>
							<select name="live_shopping_status" class="form-control">
								<option value="enable" <?php echo get_option('live_shopping_status') == 'enable' ? 'selected' : ''; ?>>Enable</option>
								<option value="disable" <?php echo get_option('live_shopping_status') == 'disable' ? 'selected' : ''; ?>>Disable</option>
							</select>
						</div>

						<div class="form-group <?=form_error('live_shopping_start_time') ? 'has-error' : ''?>">
							<label for="live_shopping_start_time">Live Shopping Start Time</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<?php echo form_input(array('name'=>'live_shopping_start_time', 'class'=>'datetimepicker form-control pull-right', 'id'=>'live_shopping_start_time', 'value'=>get_option('live_shopping_start_time'), 'placeholder' => '00/00/0000 00:00 AM')); ?>
							</div>
						</div>

						<div class="form-group <?=form_error('live_shopping_end_time') ? 'has-error' : ''?>">
							<label for="live_shopping_end_time">Live Shopping End Time</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<?php echo form_input(array('name'=>'live_shopping_end_time', 'class'=>'datetimepicker form-control pull-right', 'id'=>'live_shopping_end_time', 'value'=>get_option('live_shopping_end_time'), 'placeholder' => '00/00/0000 00:00 AM')); ?>
							</div>
						</div>

						<div class="form-group <?=form_error('live_shopping_banner') ? 'has-error' : ''?>">
							<label for="live_shopping_banner">Live Shopping Banner</label>
							<input type="text" class="form-control" name="live_shopping_banner" id="live_shopping_banner" value="<?=get_option('live_shopping_banner')?>">
						</div>

						<div class="form-group <?=form_error('live_shopping_url') ? 'has-error' : ''?>">
							<label for="live_shopping_url">Live Shopping URL</label>
							<input type="text" class="form-control" name="live_shopping_url" id="live_shopping_url" value="<?=get_option('live_shopping_url')?>">
						</div>
						
						<div class="form-group <?=form_error('home_seo_title') ? 'has-error' : ''?>">
							<label for="home_seo_title">Home Page SEO Title</label>
							<input type="text" class="form-control" name="home_seo_title" id="home_seo_title" value="<?=get_option('home_seo_title')?>">
						</div>

						<div class="form-group <?=form_error('home_seo_keywords') ? 'has-error' : ''?>">
							<label for="home_seo_keywords">Home Page SEO Keywords</label>
							<input type="text" class="form-control" name="home_seo_keywords" id="home_seo_keywords" value="<?=get_option('home_seo_keywords')?>">
						</div>
						
						<div class="form-group <?=form_error('home_seo_content') ? 'has-error' : ''?>">
							<label for="home_seo_content">Home Page SEO Content</label>
							<textarea class="form-control" rows="5" name="home_seo_content"><?=get_option('home_seo_content')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('home_about_title') ? 'has-error' : ''?>">
							<label for="home_about_title">Home Page About Title</label>
							<input type="text" class="form-control" name="home_about_title" id="home_about_title" value="<?=get_option('home_about_title')?>">
						</div>
						
						<div class="form-group <?=form_error('home_about_content') ? 'has-error' : ''?>">
							<label for="home_about_content">Home Page About Content</label>
							<textarea class="form-control" rows="5" name="home_about_content"><?=get_option('home_about_content')?></textarea>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>