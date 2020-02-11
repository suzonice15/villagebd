

<div class="row">
    <div class="col-md-12">
        
       <div class="col-md-3">
               <form action="" method="get">
                 <!--
              <div class="form-group">
                <label>Category</label>
                
                <select id="category_id_byselect" name="category_id" class="form-control select2" >
                    
                    
                  <option value="">select category</option>
                  <?php   $allcategory= get_result("select category_id,parent_id,category_title from category  order by parent_id ASC");
								   
						  foreach($allcategory as $cat){
						        


						     ?>
                  <option value="<?php echo  $cat->category_id;?>" ><?php echo  $cat->category_title; ?> </option>
                  <?php } ?>
                </select>
              </div>
              
              -->
                 </div>
        <div class="subsubsub_wrapper">
            <div class="float-right search-box">
               
                    <input class="form-control search_field" type="search" name="query" value="<?php echo $this->input->get('query'); ?>" />
                    <button type="submit" class="btn admin_cus_btn search_field_btn">Search Product</button>
               
            </div>
        </div>
 </form>
        <div class="clearfix"></div>

        <form action="<?php echo site_url('product/bulk_action'); ?>" method="post">
            <div class="tablenav top">
                <div class="float-left bulkactions_wrapper">
                    <div class="alignleft actions bulkactions">
                        <select class="form-control search_field" name="action" id="">
                            <option value="-1">Bulk Actions</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" name="submit" value="submit" class="btn admin_cus_btn search_field_btn">Apply</button>
                    </div>
                </div>
                <div class="float-right tablenav-pages">
                    <span class="displaying-num"><?php echo $total; ?> items</span>
                    <nav aria-label="Page navigation example">
                        <?php echo $this->pagination->create_links(); ?>
                    </nav>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="list_table table-responsive">
                <table  id="category_id_data" class="table table-striped product_table_wrapper head_height_table">
                    <colgroup>
                        <col width="2%">
                        <col>
                        <col width="20%">
                        <col width="10%">
                        <col width="10%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
						<tr>
                            <th class="text-center check-column">
                                <div class="custom-control custom-checkbox page-custom-checkbox th-page-custom-checkbox">
                                    <input type="checkbox" class="custom-control-input selectall" name="selectAll" value="on" id="selectAll">
                                    <label class="custom-control-label" for="selectAll"></label>
                                </div>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('product_title', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/product', 'product_title', 'asc'); ?>">
                                    <span>Product</span>
                                </a>
                            </th>
							<th>Category</th>
                            <th class="sorted <?php echo get_sorted_class('product_price', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/product', 'product_price', 'asc'); ?>">
                                    <span>Price</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('product_price', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/product', 'product_price', 'asc'); ?>">
                                    <span>Discount Price</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('created_time', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/product', 'created_time', 'asc'); ?>">
                                    <span>Date</span>
                                </a>
                            </th>
                            <th class="text-center">&nbsp;</th>
						</tr>
                    </thead>
					<tbody>
						<?php
						$cat_url = isset($_GET['sortbycat']) ? '/?cat_url='.base_url().'admin/product/'.basename($_SERVER['REQUEST_URI']) : '/?cat_url='.base_url('admin/product/?t=');
						
						if(!empty($products))
						{
							$html=NULL;
							
						
							foreach($products as $prod)
							{
							    
							    //	print_r($prod->status);
                                $image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));

								$prod_cats = array();
								$product_terms = product_terms($prod->product_id);
								if($product_terms && is_array($product_terms))
								{
									foreach($product_terms as $pterm)
									{
										$prod_cats[] = get_category_title($pterm->term_id);
									}
								}

								?><tr>
                                    <td class="text-center">
                                         <div class="custom-control custom-checkbox page-custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="ids[]" value="<?php echo $prod->product_id ?>" id="ids_<?php echo $prod->product_id; ?>">
                                            <label class="custom-control-label" for="ids_<?php echo $prod->product_id; ?>"></label>
                                        </div>
                                    </td>
									<td>
                                        <img src="<?php echo get_photo((isset($image->media_path) ? $image->media_path : null), 'uploads/product/','mini_thumbs'); ?>" width="40"> &nbsp; <?php echo $prod->product_title; ?>
									</td>
									<td><?php echo implode(", ", $prod_cats); ?></td>
									<td>৳ <?php echo $prod->product_price; ?></td>
									<td>৳ <?php echo $prod->discount_price; ?></td>
                                    <td><?php echo $prod->created_time; ?></td>
									<td class="text-right">
									 <?php   if($this->session->user_type == 'super-admin' || $this->session->user_type == 'admin' ){
									     if($prod->status==0){
						    ?>
							     <a class="btn btn-success" href="<?php echo base_url().'admin/product/confirm_product/'.$prod->product_id; ?>">Confirm</a>
							     <?php  
									     }
							     } ?>
                                        <a class="btn btn-info" href="<?php echo base_url().'admin/product/update/'.$prod->product_id; ?>">Update</a>
                                        <a class="btn btn-danger" href="<?php echo base_url().'admin/product/delete/'.$prod->product_id; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
									</td>
								</tr><?php
							}
						}
						?>
					</tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">
                                 <div class="custom-control custom-checkbox page-custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="allcheck1">
                                     <label class="custom-control-label" for="allcheck1"></label>
                                </div>
                            </th>
                             <th class="text-center">
                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                            </th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th class="text-center">&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="tablenav top">
                <div class="float-right tablenav-pages">
                    <span class="displaying-num"><?php echo $total; ?> items</span>
                    <nav aria-label="Page navigation example">
                        <?php echo $this->pagination->create_links(); ?>
                    </nav>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>
    </div>
</div>
<span class="home_cat_content"></span>

<script>
    
    $('#category_id_byselect').on('change',function(){
                    var category_id=$(this).val();
                var user_id=$this->session->user_id;
                alert(user_id)

      $.ajax({
         type:'post',
         data:{category_id:category_id,user_id:user_id},
         url:'<?php echo base_url()?>admin/Product/category_wise_product',
         success:function (results){
             
             
             alert(results);
                  // $('#category_id_data').html(results.products);
                    	jQuery('#category_id_data').html(results);


 
             
         }
      });
    });
    
</script>