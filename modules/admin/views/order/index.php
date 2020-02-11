<div class="row">
    <div class="col-md-12">
        <div class="subsubsub_wrapper">
            <ul class="float-left subsubsub">
                <li><a href="<?php echo site_url('admin/order?status=all'); ?>" <?php if (!$this->input->get('status') || $this->input->get('status') == 'all') { ?> class="current" <?php } ?>>All <span class="count">(<?php echo $this->global_model->get_count('order', array('status' => '1')); ?>)</span></a></li>

                <?php
                foreach($order_status as $status_key=>$status_label)
                {
                    ?><li> | <a href="<?php echo site_url('admin/order?status=' . $status_key); ?>" <?php if($this->input->get('status', 'all') == $status_key){ ?> class="current" <?php } ?>><?php echo $status_label; ?> <span class="count">(<?php echo $this->global_model->get_count('order', array('order_status' => $status_key, 'status' => '1')); ?>)</span></a></li><?php
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

        <form action="<?php echo site_url('admin/order/bulk_action'); ?>" method="post">
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
							<th>Customer</th>
							<th>Items</th>
							<th class="text-center">Total</th>
							<th class="text-center">Order Time</th>
							<th class="text-left">&nbsp;</th>
						</tr>
                    </thead>
					<tbody>
						<?php
						if(!empty($results))
						{
							$html=NULL;
							
							foreach($results as $row)
							{
								$product_items = unserialize($row->products);
								$total_items = count($product_items['items']);
								if($total_items<10){ $total_items = '0'.$total_items; }
								
								$style = ($row->view_status == 'unread') ? 'font-weight:bold;' : '';

								$html.='<tr>
									<td>
										<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$row->order_id.'" />
									</td>
									<td style="'.$style.'">'.$row->billing_name.'('.$row->billing_phone.')</td>
									<td style="'.$style.'">'.$total_items.'</td>
									<td style="'.$style.'" class="text-center">৳ '.$row->order_total.'</td>
									<td style="'.$style.'" class="text-center">'.date("d-M-Y h:i:s a", strtotime($row->created_time)).'</td>
									<td class="action text-center">
                                        <a href="'.base_url().'admin/order/order_view/'.$row->order_id.'">Update</a>
                                        <a href="'.base_url().'admin/order/delete/'.$row->order_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
									</td>
								</tr>';
							}
							echo $html;
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
							<th>Customer</th>
							<th>Items</th>
							<th class="text-center">Total</th>
							<th class="text-center">Order Time</th>
							<th class="text-left">&nbsp;</th>
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