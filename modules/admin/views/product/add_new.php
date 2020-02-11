<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <div class="form-group <?= form_error('product_title') ? 'has-error' : '' ?>">
                        <label for="product_title">Title<span class="required">*</span></label>
                        <input type="text" class="form-control the_title" name="product_title" id="product_title"
                               value="<?= set_value('product_title'); ?>">
                    </div>

                    <div class="form-group <?= form_error('product_name') ? 'has-error' : '' ?>">
                        <label for="product_name">Name<span class="required">*</span></label>
                        <?= form_error('product_name', '<p class="required-error">', '</p>') ?>
                        <input type="text" class="form-control the_name" name="product_name" id="product_name"
                               value="<?= set_value('product_name') ?>">
                    </div>

                    <div class="form-group <?= form_error('product_price') ? 'has-error' : '' ?>">
                        <label for="product_price">Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price"
                               value="<?= set_value('product_price'); ?>">
                    </div>

                    <div class="form-group <?= form_error('discount_price') ? 'has-error' : '' ?>">
                        <label for="discount_price">Discount Price</label>
                        <input type="text" class="form-control" name="discount_price" id="discount_price"
                               value="<?= set_value('discount_price'); ?>">
                    </div>

                    <div class="form-group <?= form_error('discount_date_from') ? 'has-error' : '' ?>">
                        <label for="discount_date_from">Discount From</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                            $discount_date_from = set_value('discount_date_from') ? set_value('discount_date_from') : date('m/d/Y');
                            echo form_input(array('name' => 'discount_date_from', 'class' => 'form-control pull-right datepicker', 'id' => 'discount_date_from', 'value' => $discount_date_from));
                            ?>
                        </div>
                    </div>

                    <div class="form-group <?= form_error('discount_date_to') ? 'has-error' : '' ?>">
                        <label for="discount_date_to">Discount From</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                            $discount_date_to = set_value('discount_date_to') ? set_value('discount_date_to') : date('m/d/Y');
                            echo form_input(array('name' => 'discount_date_to', 'class' => 'form-control pull-right datepicker', 'id' => 'discount_date_to', 'value' => $discount_date_to));
                            ?>
                        </div>
                    </div>

                    <div class="form-group <?= form_error('is_live_promo') ? 'has-error' : '' ?>">
                        <label for="is_live_promo">Is Live Promo?</label>
                        <input type="checkbox" name="is_live_promo"
                               value="1" <?php echo set_checkbox('is_live_promo', 1); ?> />
                    </div>
                    <div class="form-group <?=form_error('product_order') ? 'has-error' : ''?>">
						<label for="product_order">Product Position</label>
						<input type="text" name="product_order" value="" class="form-control" />
					</div>
					

                    <div class="form-group <?= form_error('product_availability') ? 'has-error' : '' ?>">
                        <label for="product_availability">Product Availability</label>
                        <?php
                        echo form_dropdown('product_availability', array('In stock' => 'In stock', 'Out of stock' => 'Out of stock', 'Upcoming' => 'Upcoming'), set_value('product_availability'), array('class' => 'form-control'));
                        ?>
                    </div>

                    <div class="form-group <?= form_error('product_type') ? 'has-error' : '' ?>">
                        <label for="product_type">Product Type</label>
                        <?php echo form_dropdown('product_type', array('general' => 'General', 'bestsell' => 'Best Sell', 'home' => 'Home'), set_value('product_type'), array('class' => 'form-control')); ?>
                    </div>

                    <div class="form-group video">
                        <label>YouTube Video Link</label>
                        <input type="text" class="form-control" name="product_video"
                               value="<?= set_value('product_video'); ?>"/>
                    </div>

                    <div class="form-group <?= form_error('product_summary') ? 'has-error' : '' ?>">
                        <label for="product_summary">Summary<span class="required">*</span></label>
						<textarea class="form-control" rows="10" name="product_summary"
                                  id="product_summary"><?= set_value('product_summary'); ?></textarea>
                    </div>
                    <div class="form-group video">
                        <label>Coupon Name</label>

                        <select class="form-control select2" name="coupon_code" id="coupon_code" >
                            <option value="">Select Coupon</option>
                            <?php if($coupons) {
                                foreach ($coupons as $coupon) {

                                ?>
                            <option value="<?php echo $coupon->coupon_id;?>"><?php echo $coupon->coupon_name;?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label>Coupon Price</label>
                        <input type="text" class="form-control" name="coupon_price"
                               value="<?= set_value('coupon_price'); ?>"/>
                    </div>
                    <div class="form-group ">
                        <label>Select Coupon Type</label>
                        <select class="form-control" name="coupon_status">
                            <option value="fixed">Fixed</option>
                            <option value="percent">Percent</option>
                            </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <label for="categories">Categories<span class="required">*</span></label>


                    <div class="form-group categories checkbox <?= form_error('categories') ? 'has-error' : '' ?>">

                        <br/>


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


                        } else {


                            foreach ($category_list_products as $productt) {

                                ?>

                                <li ><label><?php

                                        echo category_name_show($productt->parent_id) ?>
                                    </label></li>
                                <li style="margin-left:50px"><label><input


                                            type="checkbox" name="categories[]"
                                            value="<?php echo $productt->category_id ?> "><?php echo $productt->category_title ?>
                                    </label></li>

                            <?php 	}



                        }
                        ?>
                    </div>

                    <div class="form-group featured-image">
                        <label>Featured Image<span class="required">*</span></label>
                        <input type="file" class="form-control" name="featured_image"/>
                    </div>

                    <div class="form-group">
                        <label>Product Gallary</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="file" class="form-control" name="product_image[]"/>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="file" class="form-control" name="product_image[]"/>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="file" class="form-control" name="product_image[]"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="form-group <?= form_error('product_description') ? 'has-error' : '' ?>">
                <label for="product_description">Description<span class="required">*</span></label>
				<textarea class="form-control" rows="15" name="product_description"
                          id="product_description"><?= set_value('product_description'); ?></textarea>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <label for="product_specification">Specifications</label>
            <?php
            $spkey = set_value('specification_key');
            $spvals = set_value('specification_value');

            if (!empty($spkey) && !empty($spvals)) {
                $ki = 0;
                $oi = 1;
                foreach ($spvals as $spval) {
                    if (!empty($spval)) {
                        echo '<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<input type="text" class="form-control" name="specification_key[]" value="' . $spkey[$ki] . '">
								</div>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="specification_value[]" value="' . $spval . '">
								</div>
							</div>
						</div>';

                        $oi++;
                    }

                    $ki++;
                }

                for ($skf = $oi; $skf <= 30; $skf++) {
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
            } else {
                ?>
                <div class="form-group">
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
                            <input type="text" class="form-control" name="specification_key[]" value="Graphics">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_value[]">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_key[]" value="Display">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_value[]">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_key[]" value="ODD">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_value[]">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_key[]" value="Interface">
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
                            <input type="text" class="form-control" name="specification_key[]" value="Call For Details">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_value[]">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="specification_key[]" value="EMI For 6 Month">
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
            <div class="form-group <?= form_error('seo_title') ? 'has-error' : '' ?>">
                <label for="seo_title">SEO Title</label>
                <input type="text" class="form-control" name="seo_title" id="seo_title"
                       value="<?php echo set_value('seo_title'); ?>">
            </div>

            <div class="form-group <?= form_error('seo_keywords') ? 'has-error' : '' ?>">
                <label for="seo_keywords">SEO Keywords</label>
                <input type="text" class="form-control" name="seo_keywords" id="seo_keywords"
                       value="<?php echo set_value('seo_keywords'); ?>">
            </div>

            <div class="form-group <?= form_error('seo_content') ? 'has-error' : '' ?>">
                <label for="seo_content">SEO Content</label>
				<textarea class="form-control" rows="5" name="seo_content"
                          id="seo_content"><?php echo set_value('seo_content'); ?></textarea>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
