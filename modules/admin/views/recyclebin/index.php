<div class="row">
    <div class="col-md-12">
        <div class="subsubsub_wrapper">
             <a href="<?php echo base_url()?>/admin/recyclebin/notification_delete " class="btn btn-danger pull-left" onclick="return confirm('Are you confirm to delete?')">Update Notification Delete</a>
            <div class="float-right search-box">
                	
                <form action="" method="get">
                    <input class="form-control search_field" type="search" name="query" value="<?php echo $this->input->get('query'); ?>" placeholder="Table name here..."/>
                    <button type="submit" class="btn admin_cus_btn search_field_btn">Search</button>
                </form>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="tablenav top">
            <div class="float-right tablenav-pages">
                <span class="displaying-num"><?php echo $total; ?> items</span>
                <nav aria-label="Page navigation example">
                    <?php echo $this->pagination->create_links(); ?>
                </nav>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="list_table table-responsive">
            <table class="table table-striped product_table_wrapper head_height_table">
                <colgroup>
                    <col width="10%">
                    <col>
                    <col width="10%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
					<tr>
                        <th>Table Name</th>
                        <th>Deleted Data</th>
                        <th>Name</th>
                        <th>Date & Time</th>
                        <th>Status</th>
					</tr>
                </thead>
				<tbody>
					<?php
					if(!empty($results))
					{
						foreach($results as $row)
						{
                            $table_data = '---';

                            $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name='.$row->table_name.'_id&table_id='.$row->table_id);
                            
                            $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name='.$row->table_name.'_id&table_id='.$row->table_id);

                            if($row->table_name == 'users')
                            {
                                $table_info = $this->global_model->get_row('users', array('user_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->user_name.'</span><br/>
                                    <span>Phone: '.$table_info->user_phone.'</span><br/>
                                    <span>Email: '.$table_info->user_email.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=user_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=user_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'adds')
                            {
                                $table_info = $this->global_model->get_row('adds', array('adds_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->adds_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=adds_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=adds_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'blog')
                            {
                                $table_info = $this->global_model->get_row('blog', array('blog_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->blog_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=blog_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=blog_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'brand')
                            {
                                $table_info = $this->global_model->get_row('brand', array('brand_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->brand_name.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=brand_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=brand_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'career')
                            {
                                $table_info = $this->global_model->get_row('career', array('career_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->name.'</span><br/>
                                    <span>Email: '.$table_info->email.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=career_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=career_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'category')
                            {
                                $table_info = $this->global_model->get_row('category', array('category_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->category_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=category_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=category_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'homeslider')
                            {
                                $table_info = $this->global_model->get_row('homeslider', array('homeslider_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->homeslider_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=homeslider_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=homeslider_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'media')
                            {
                                $table_info = $this->global_model->get_row('media', array('media_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->media_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=media_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=media_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'news')
                            {
                                $table_info = $this->global_model->get_row('news', array('news_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->news_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=news_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=news_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'offer')
                            {
                                $table_info = $this->global_model->get_row('offer', array('offer_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->offer_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=offer_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=offer_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'order')
                            {
                                $table_info = $this->global_model->get_row('order', array('order_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>Order: '.$table_info->order_id.'</span><br/>
                                    <span>Name: '.$table_info->billing_name.'</span><br/>
                                    <span>Phone: '.$table_info->billing_phone.'</span><br/>
                                    <span>Email: '.$table_info->billing_email.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=order_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=order_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'post')
                            {
                                $table_info = $this->global_model->get_row('post', array('post_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->post_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=post_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=post_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'product')
                            {
                                $table_info = $this->global_model->get_row('product', array('product_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->product_title.'</span>
                                </p>';

                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=product_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=product_id&table_id='.$row->table_id);
                            }
                            elseif($row->table_name == 'service')
                            {
                                $table_info = $this->global_model->get_row('service', array('service_id' => $row->table_id));

                                $table_data = '<p>
                                    <span>'.$table_info->service_title.'</span>
                                </p>';
                                
                                $restore_url = base_url('admin/recyclebin/restore/?table_name='.$row->table_name.'&field_name=service_id&table_id='.$row->table_id);
                                $delete_url = base_url('admin/recyclebin/confirm_delete/?table_name='.$row->table_name.'&field_name=service_id&table_id='.$row->table_id);
                            }

                            // deleted by
                            $user_data = '';
                            $user_info = $this->global_model->get_row('users', array('user_id' => $row->user_id));
                            if(!empty($user_info))
                            {
                                $user_data = '<p>
                                    <span>'.$user_info->user_name.'</span><br/>
                                    <span>Phone: '.$user_info->user_phone.'</span><br/>
                                    <span>Email: '.$user_info->user_email.'</span>
                                    <span>User Role: '.$user_info->user_type.'</span>
                                </p>';
                            }

							?><tr>
								<td><?php echo $row->table_name; ?></td>
                                <td><?php echo $table_data; ?></td>
                                <td><?php echo $user_data; ?></td>
								<td><?php echo date("M d, Y H:i a", strtotime($row->created_time)); ?></td>
								<?php if($row->recyclebin_status==0):?>
								<td class="action text-right">
                                    <a href="<?php echo $restore_url; ?>" onclick="return confirm('Are you confirm to restore?')">Restore</a>
                                    <a href="<?php echo $delete_url; ?>" onclick="return confirm('Are you confirm to delete?')">Confirm</a>
								</td>
								<?php else :?>
									<td class="action text-right">
								<input type="button" class="btn  btn-success" value="Updated Data">
							
									</td>
								<?php endif;?>
							</tr><?php
						}
					}
                    else
                    {
                        echo '<tr><td colspan="4">No data found!</td></tr>';
                    }
					?>
				</tbody>
                <tfoot>
					<tr>
                        <th>Table Name</th>
                        <th>Deleted Data</th>
                        <th>Name</th>
                        <th>Date & Time</th>
                      
                        <th>Status</th>
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
    </div>
</div>