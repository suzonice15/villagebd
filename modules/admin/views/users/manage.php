<div class="row">
    <div class="col-md-12">
        <div class="subsubsub_wrapper">
            <ul class="float-left subsubsub">
                <li><a href="<?php echo site_url('admin/users?user_type=all'); ?>" <?php if (!$this->input->get('user_type') || $this->input->get('user_type') == 'all') { ?> class="current" <?php } ?>>All <span class="count">(<?php echo $this->global_model->get_count('users', array('status!=' => 'deleted')); ?>)</span></a></li>

                <?php
                foreach($roles as $role_key=>$role_label)
                {
                    ?><li> | <a href="<?php echo site_url('admin/users?user_type=' . $role_key); ?>" <?php if($this->input->get('user_type', 'all') == $role_key){ ?> class="current" <?php } ?>><?php echo $role_label; ?> <span class="count">(<?php echo $this->global_model->get_count('users', array('user_type' => $role_key, 'status!=' => 'deleted')); ?>)</span></a></li><?php
                }
                ?>  
            </ul>
            <div class="float-right search-box">
                <form action="" method="get">
                    <input class="form-control search_field" type="search" name="query" value="<?php echo $this->input->get('query'); ?>" />
                    <button type="submit" class="btn admin_cus_btn search_field_btn">Search</button>
                </form>
            </div>
        </div>

        <div class="clearfix"></div>

        <form action="<?php echo site_url('admin/users/bulk_action'); ?>" method="post">
            <div class="tablenav top">
                <div class="float-left bulkactions_wrapper">
                    <div class="alignleft actions bulkactions">
                        <select class="form-control search_field" name="action">
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
                <table class="table table-striped product_table_wrapper head_height_table">
                    <colgroup>
                        <col width="2%">
                        <col>
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="13%">
                    </colgroup>
                    <thead>
						<tr>
                            <th class="text-center check-column">
                                <input type="checkbox" class="custom-control-input selectall" name="selectAll" value="on" id="selectAll">
                            </th>
                            <th class="sorted <?php echo get_sorted_class('user_name', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'user_name', 'asc'); ?>">
                                    <span>Name</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('user_type', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'user_type', 'asc'); ?>">
                                    <span>User Type</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('user_email', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'user_email', 'asc'); ?>">
                                    <span>Email</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('registered_date', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'registered_date', 'asc'); ?>">
                                    <span>Registered Date</span>
                                </a>
                            </th>
							<th class="text-center">&nbsp;</th>
						</tr>
                    </thead>
					<tbody>
						<?php
						if(!empty($results))
						{
							foreach($results as $result)
							{
								?><tr>
									<td>
										<input type="checkbox" name="ids[]" id="checkbox[]" class="checkbox1" value="<?php echo $result->user_id; ?>"/>
									</td>
									<td><?php echo $result->user_name; ?></td>
									<td><?php echo ucwords(str_replace("-", " ", $result->user_type)); ?></td>
									<td><?php echo $result->user_email; ?></td>
									<td><?php echo date("d-M-Y", strtotime($result->registered_date)); ?></td>
									<td class="action text-right">
										<a href="<?php echo base_url().'admin/users/update/'.$result->user_id; ?>">Update</a>
                                        <a href="<?php echo base_url().'admin/users/delete/'.$result->user_id; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
									</td>
								</tr><?php
							}
						}
                        else
                        {
                            echo '<tr><td colspan="6">No data found!</td></tr>';
                        }
						?>
					</tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center check-column">
                                <input type="checkbox" class="custom-control-input selectall" name="selectAll" value="on" id="selectAll">
                            </th>
                            <th class="sorted <?php echo get_sorted_class('user_name', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'user_name', 'asc'); ?>">
                                    <span>Name</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('user_type', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'user_type', 'asc'); ?>">
                                    <span>User Type</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('user_email', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'user_email', 'asc'); ?>">
                                    <span>Email</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('registered_date', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/users', 'registered_date', 'asc'); ?>">
                                    <span>Registered Date</span>
                                </a>
                            </th>
							<th class="text-center" width="7%">&nbsp;</th>
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