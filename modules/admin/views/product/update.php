<form method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-6">
			<div class="box">
				<div class="box-body">
					<div class="form-group <?=form_error('product_title') ? 'has-error' : ''?>">
						<label for="product_title">Title<span class="required">*</span></label>
						<input type="text" class="form-control the_title" name="product_title" id="product_title" value="<?php if(set_value('product_title')){ echo set_value('product_title'); }elseif(isset($prod_row->product_title)){ echo $prod_row->product_title; } ?>">
					</div>
					
					<div class="form-group <?=form_error('product_name') ? 'has-error' : ''?>">
						<label for="product_name">Name<span class="required">*</span></label>
						<input type="text" class="form-control the_name" name="product_name" id="product_name" value="<?php if(set_value('product_name')){ echo set_value('product_name'); }elseif(isset($prod_row->product_name)){ echo $prod_row->product_name; } ?>">
					</div>
					
					<div class="form-group <?=form_error('product_price') ? 'has-error' : ''?>">
						<label for="product_price">Price</label>
						<input type="text" class="form-control" name="product_price" id="product_price" value="<?php if(set_value('product_price')){ echo set_value('product_price'); }elseif(isset($prod_row->product_price)){ echo $prod_row->product_price; } ?>">
					</div>
					
					<div class="form-group <?=form_error('discount_price') ? 'has-error' : ''?>">
						<label for="discount_price">Discount Price</label>
						<input type="text" class="form-control" name="discount_price" id="discount_price" value="<?php if(set_value('discount_price')){ echo set_value('discount_price'); }elseif(isset($prod_row->discount_price)){ echo $prod_row->discount_price; } ?>">
					</div>

					<div class="form-group <?=form_error('discount_date_from') ? 'has-error' : ''?>">
						<label for="discount_date_from">Discount From</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<?php
							$discount_date_from = !empty($prod_row->discount_price) ? (set_value('discount_date_from') ? set_value('discount_date_from') : date('m/d/Y', strtotime($prod_row->discount_date_from))) : date('m/d/Y');
							echo form_input(array('name'=>'discount_date_from', 'class'=>'form-control pull-right datepicker', 'id'=>'discount_date_from', 'value'=>$discount_date_from));
							?>
						</div>
					</div>

					<div class="form-group <?=form_error('discount_date_to') ? 'has-error' : ''?>">
						<label for="discount_date_to">Discount From</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<?php
							$discount_date_to = !empty($prod_row->discount_price) ? (set_value('discount_date_to') ? set_value('discount_date_to') : date('m/d/Y', strtotime($prod_row->discount_date_to))) : date('m/d/Y');
							echo form_input(array('name'=>'discount_date_to', 'class'=>'form-control pull-right datepicker', 'id'=>'discount_date_to', 'value'=>$discount_date_to));
							?>
						</div>
					</div>
					
					<div class="form-group <?=form_error('is_live_promo') ? 'has-error' : ''?>">
						<label for="is_live_promo">Is Live Promo?</label>
						<input type="checkbox" name="is_live_promo" value="1" <?php echo $prod_row->is_live_promo == 1 ? 'checked' : null; ?> />
					</div>
						<div class="form-group <?=form_error('product_order') ? 'has-error' : ''?>">
						<label for="product_order">Product Position</label>
						<input type="text" name="product_order" class="form-control" value="<?php echo $prod_row->product_order;?>" />
					</div>
					
					<div class="form-group <?=form_error('product_availability') ? 'has-error' : ''?>">
						<label for="product_availability">Product Availability</label>
						<?php  echo form_dropdown('product_availability', array('In stock'=>'In stock', 'Out of stock'=>'Out of stock', 'Upcoming'=>'Upcoming'), $prod_row->product_availability, array('class'=>'form-control')); ?>
					</div>
					
					<div class="form-group <?=form_error('product_type') ? 'has-error' : ''?>">
						<label for="product_type">Product Type</label>
						<?php
						if(set_value('product_type')) $product_type = set_value('product_type');
						elseif($prod_row->product_type) $product_type = $prod_row->product_type;
						else $product_type = '';
						
						echo form_dropdown('product_type', array('general'=>'General', 'bestsell'=>'Best Sell', 'home'=>'Home'), $product_type, array('class'=>'form-control'));
						?>
					</div>
			
					<div class="form-group video <?=form_error('product_video') ? 'has-error' : ''?>">
						<label>YouTube Video Link</label>
						<input type="text" class="form-control" name="product_video" value="<?php if(set_value('product_video')){ echo set_value('product_video'); }elseif(isset($prod_row->product_video)){ echo $prod_row->product_video; } ?>">
					</div>
			
					<div class="form-group <?=form_error('product_summary') ? 'has-error' : ''?>">
						<label for="product_summary">Summary<span class="required">*</span></label>
						<textarea class="form-control" rows="10" name="product_summary" id="product_summary"><?php if(set_value('product_summary')){ echo set_value('product_summary'); }elseif(isset($prod_row->product_summary)){ echo $prod_row->product_summary; } ?></textarea>
					</div>
					
					   <div class="form-group ">
                        <label>Coupon Name</label>

                        <select class="form-control select2" name="coupon_code">
                            <option value="">Select Coupon</option>
                            <?php if($coupons) {
                                foreach ($coupons as $coupon) {

                                ?>
                            <option <?php if($prod_row->coupon_code==$coupon->coupon_id) { echo 'selected';}  ?> value="<?php echo $coupon->coupon_id;?>"><?php echo $coupon->coupon_name;?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label>Coupon Price</label>
                        <input type="text" class="form-control" name="coupon_price"
                               value="<?= $prod_row->coupon_price; ?>"/>
                    </div>
                    <div class="form-group ">
                        <label>Select Coupon Type</label>
                        <select class="form-control" name="coupon_status">
                            <option value="fixed">Fixed</option>
                            <option <?php if($prod_row->coupon_status=='percent') { echo 'selected'; }  ?> value="percent">Percent</option>
                            </select>
                    </div>
               
				</div>
			</div>
		</div>
		
		<div class="col-sm-6">
			<div class="box">
				<div class="box-body">
					<label for="categories">Categories<span class="required">*</span></label>
					<div class="form-group categories checkbox">
						<?php
						$categories = array('categories' => array(),'parent_cats' => array());
						
						if(isset($category_list))
						{
							foreach($category_list as $cat)
							{
								$categories['categories'][$cat->category_id] = $cat;
								
								$categories['parent_cats'][$cat->parent_id][] = $cat->category_id;
							}
							
							echo nested_category_checkbox_list(0, $categories, $product_terms);
						}
						?>
					</div>
				
					<?php
					// product image
					$image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod_row->product_id));

					// gallery images
					$gallery = array();
					$gallery_images = $this->global_model->get('media', array('status' => 1, 'media_type' => 'product_gallery', 'relation_id' => $prod_row->product_id));
					?>
		
					<div class="form-group featured-image">
						<label>Featured Image<span class="required">*</span></label>
						<div class="row">
							<div class="col-sm-1">
								<img src="<?php echo get_photo((isset($image->media_path) ? $image->media_path : null), 'uploads/product/','mini_thumbs'); ?>" width="33" height="33">
							</div>
							<div class="col-sm-11">
								<input type="file" class="form-control" name="featured_image">
							</div>
						</div>
					</div>
				
					<div class="form-group">
						<label>Product Gallary</label>
						<?php
						$gi = 0;

						if(!empty($gallery_images))
						{
							foreach($gallery_images as $media)
							{
								?><div class="row">
									<div class="col-sm-1">
										<img src="<?php echo get_photo((isset($media->media_path) ? $media->media_path : null), 'uploads/product/','mini_thumbs'); ?>" width="33" height="33">
										<a href="<?php echo site_url('admin/product/remove_gallery_img/'.$prod_row->product_id.'/'.$media->media_id); ?>" onclick="return confirm('Are you sure to remove?')">Remove</a>
									</div>
									<div class="col-sm-11">
										<input type="file" class="form-control" name="product_image[]">
									</div>
								</div>
								<br><?php

								$gi++;
							}
						}

						if($gi < 3)
						{
							for($i=$gi; $i < 3; $i++)
							{
								?><div class="row">
									<div class="col-sm-12">
										<input type="file" class="form-control" name="product_image[]">
									</div>
								</div>
								<br><?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="box">
		<div class="box-body">
			<div class="form-group <?=form_error('product_description') ? 'has-error' : ''?>">
				<label for="product_description">Description<span class="required">*</span></label>
				<textarea class="form-control" rows="15" name="product_description" id="product_description"><?php if(set_value('product_description')){ echo set_value('product_description'); }elseif(isset($prod_row->product_description)){ echo $prod_row->product_description; } ?></textarea>
			</div>
		</div>
	</div>
	
	<div class="box">
		<div class="box-body">
			<label for="product_specification">Specifications</label>
			<?php
			if(set_value('specification_key') && set_value('specification_value'))
			{
				$spkey = set_value('specification_key');
				$spvals = set_value('specification_value');
			}
			elseif(isset($prod_row->product_description))
			{
				$product_specification = json_decode($prod_row->product_specification);
				
				if(count($product_specification)>0)
				{
					foreach($product_specification as $key=>$val)
					{
						$spkey[] = $key;
						$spvals[] = $val;
					}
				}
			}
			
			if(!empty($spkey) && !empty($spvals))
			{
				$ki=0; $oi=1; foreach($spvals as $spval)
				{
					if(!empty($spval))
					{
						echo '<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<input type="text" class="form-control" name="specification_key[]" value="'.$spkey[$ki].'">
								</div>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="specification_value[]" value="'.$spval.'">
								</div>
							</div>
						</div>';
						
						$oi++;
					}
					
					$ki++;
				}
				
				for($skf=$oi;$skf<=30;$skf++)
				{
					echo '<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<input type="text" class="form-control" name="specification_key[]">
							</div>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="specification_value[]">
							</div>
						</div>
					</div>';
				}
			}
			else
			{
				?><div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Brand">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Model">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Processor">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Clock Speed">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Cache">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Display Size">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Display Type">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="RAM">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="RAM Type">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Storage">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Graphics Chipset">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Graphics Memory">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Optical Device">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Display Port">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Audio Port">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="USB Port">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Battery">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Backup Time">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Operating System">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Weight">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Others">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Color">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]" value="Warranty">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_key[]">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="specification_value[]">
						</div>
					</div>
				</div><?php
			}
			?>
		</div>
	</div>

	<div class="box box-primary">
		<div class="box-body">
			<div class="form-group <?=form_error('seo_title') ? 'has-error' : ''?>">
				<label for="seo_title">SEO Title</label>
				<input type="text" class="form-control" name="seo_title" id="seo_title" value="<?php echo $prod_row->seo_title; ?>">
			</div>

			<div class="form-group <?=form_error('seo_keywords') ? 'has-error' : ''?>">
				<label for="seo_keywords">SEO Keywords</label>
				<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?php echo $prod_row->seo_keywords; ?>">
			</div>

			<div class="form-group <?=form_error('seo_content') ? 'has-error' : ''?>">
				<label for="seo_content">SEO Content</label>
				<textarea class="form-control" rows="5" name="seo_content" id="seo_content"><?php echo $prod_row->seo_content; ?></textarea>
			</div>
		</div>
	</div>

	<div class="box-footer">
		<input type="hidden" name="cat_url" value="<?php if(set_value('cat_url')){ echo set_value('cat_url'); }elseif(isset($_GET['cat_url'])){ echo $_GET['cat_url']; }elseif(isset($cat_url)){ echo $cat_url; } ?>">
		<button type="submit" class="btn btn-primary">Update</button>
	</div>
</form>