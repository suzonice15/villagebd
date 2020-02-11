<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST" action="<?=base_url('admin/options')?>" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group <?=form_error('site_title') ? 'has-error' : ''?>">
							<label for="site_title">Site Title</label>
							<input type="text" class="form-control" name="site_title" id="site_title" value="<?=get_option('site_title')?>">
						</div>
						
						<div class="form-group <?=form_error('logo') ? 'has-error' : ''?>">
							<label for="logo">Logo</label>
							<input type="text" class="form-control" name="logo" id="logo" value="<?=get_option('logo')?>">
						</div>
						
						<div class="form-group">
							<label for="icon">Icon</label>
							<input type="text" class="form-control" name="icon" id="icon" value="<?=get_option('icon')?>">
						</div>
						
						<div class="form-group <?=form_error('phone') ? 'has-error' : ''?>">
							<label for="phone">Phone</label>
							<input type="text" class="form-control" name="phone" id="phone" value="<?=get_option('phone')?>">
						</div>
						
						<div class="form-group <?=form_error('price_alter_message') ? 'has-error' : ''?>">
							<label for="price_alter_message">Price Alter Message</label>
							<input type="text" class="form-control" name="price_alter_message" id="price_alter_message" value="<?=get_option('price_alter_message')?>">
						</div>
						
						<div class="form-group <?=form_error('email') ? 'has-error' : ''?>">
							<label for="email">Email</label>
							<input type="text" class="form-control" name="email" id="email" value="<?=get_option('email')?>">
						</div>
						
						<div class="form-group <?=form_error('flat_shipping_charge') ? 'has-error' : ''?>">
							<label for="flat_shipping_charge">Flat Shipping Charge</label>
							<input type="text" class="form-control" name="flat_shipping_charge" id="flat_shipping_charge" value="<?=get_option('flat_shipping_charge')?>">
						</div>
						
						<div class="form-group <?=form_error('courier_shipping_charge') ? 'has-error' : ''?>">
							<label for="courier_shipping_charge">Courier/Pickup Shipping Charge</label>
							<input type="text" class="form-control" name="courier_shipping_charge" id="courier_shipping_charge" value="<?=get_option('courier_shipping_charge')?>">
						</div>
						
						<div class="form-group <?=form_error('home_cat_section') ? 'has-error' : ''?>">
							<label for="site_title">Home Category Section</label>
							<input type="text" class="form-control" name="home_cat_section" id="home_cat_section" value="<?php echo get_option('home_cat_section'); ?>" placeholder="comma seperated product ids! like: 4,20">
						</div>
						
						<div class="form-group <?=form_error('footer_address1') ? 'has-error' : ''?>">
							<label for="footer_address1">Footer Address 01</label>
							<textarea class="form-control" rows="10" name="footer_address1"><?=get_option('footer_address1')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_address2') ? 'has-error' : ''?>">
							<label for="footer_address2">Footer Address 02</label>
							<textarea class="form-control" rows="10" name="footer_address2"><?=get_option('footer_address2')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_address3') ? 'has-error' : ''?>">
							<label for="footer_address3">Footer Address 03</label>
							<textarea class="form-control" rows="10" name="footer_address3"><?=get_option('footer_address3')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_address4') ? 'has-error' : ''?>">
							<label for="footer_address4">Footer Address 04</label>
							<textarea class="form-control" rows="10" name="footer_address4"><?=get_option('footer_address4')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_address5') ? 'has-error' : ''?>">
							<label for="footer_address5">Footer Address 05</label>
							<textarea class="form-control" rows="10" name="footer_address5"><?=get_option('footer_address5')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_address6') ? 'has-error' : ''?>">
							<label for="footer_address6">Footer Address 06</label>
							<textarea class="form-control" rows="10" name="footer_address6"><?=get_option('footer_address6')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_address7') ? 'has-error' : ''?>">
							<label for="footer_address7">Footer Address 07</label>
							<textarea class="form-control" rows="10" name="footer_address7"><?=get_option('footer_address7')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('footer_menu') ? 'has-error' : ''?>">
							<label for="footer_menu">Footer Menu</label>
							<textarea class="form-control" rows="10" name="footer_menu"><?=get_option('footer_menu')?></textarea>
						</div>
						
						<div class="form-group <?=form_error('copyright') ? 'has-error' : ''?>">
							<label for="copyright">Copyright</label>
							<input type="text" class="form-control" name="copyright" id="copyright" value="<?=get_option('copyright')?>">
						</div>
						
						<div class="form-group <?=form_error('product_book') ? 'has-error' : ''?>">
							<label for="product_book">Product Book PDF Link</label>
							<input type="text" class="form-control" name="product_book" id="product_book" value="<?=get_option('product_book')?>">
						</div>
						
						<div class="form-group <?=form_error('social_fb') ? 'has-error' : ''?>">
							<label for="social_fb">Facebook Link</label>
							<input type="text" class="form-control" name="social_fb" id="social_fb" value="<?=get_option('social_fb')?>">
						</div>
						
						<div class="form-group <?=form_error('social_tw') ? 'has-error' : ''?>">
							<label for="social_tw">Twiter Link</label>
							<input type="text" class="form-control" name="social_tw" id="social_tw" value="<?=get_option('social_tw')?>">
						</div>
						
						<div class="form-group <?=form_error('social_in') ? 'has-error' : ''?>">
							<label for="social_in">LinkedIn Link</label>
							<input type="text" class="form-control" name="social_in" id="social_in" value="<?=get_option('social_in')?>">
						</div>
						
						<div class="form-group <?=form_error('social_gp') ? 'has-error' : ''?>">
							<label for="social_gp">Google+ Link</label>
							<input type="text" class="form-control" name="social_gp" id="social_gp" value="<?=get_option('social_gp')?>">
						</div>
						
						<div class="form-group <?=form_error('social_pn') ? 'has-error' : ''?>">
							<label for="social_pn">Pinterest Link</label>
							<input type="text" class="form-control" name="social_pn" id="social_pn" value="<?=get_option('social_pn')?>">
						</div>
						
						<div class="form-group <?=form_error('social_yt') ? 'has-error' : ''?>">
							<label for="social_yt">Youtube Link</label>
							<input type="text" class="form-control" name="social_yt" id="social_yt" value="<?=get_option('social_yt')?>">
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