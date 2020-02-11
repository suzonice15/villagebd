<div class="row">
    <div class="col-md-12">
        <div class="subsubsub_wrapper">
            <div class="float-right search-box">
                <form action="" method="get">
                    <input class="form-control search_field" type="search" name="query" value="<?php echo $this->input->get('query'); ?>" />
                    <button type="submit" class="btn admin_cus_btn search_field_btn">Search Slider</button>
                </form>
            </div>
        </div>

        <div class="clearfix"></div>

        <form action="<?php echo site_url('blog/bulk_action'); ?>" method="post">
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
                <table class="table table-striped product_table_wrapper head_height_table">
                    <colgroup>
                        <col width="2%">
                        <col width="75%">
                        <col width="15%">
                        <col width="8%">
                    </colgroup>
                    <thead>
						<tr>
                            <th class="text-center check-column">
                                <input type="checkbox" class="custom-control-input selectall" name="selectAll" value="on" id="selectAll">
                            </th>
                            <th class="sorted <?php echo get_sorted_class('blog_title', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/blog', 'blog_title', 'asc'); ?>">
                                    <span>Title</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('created_time', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/blog', 'created_time', 'asc'); ?>">
                                    <span>Date</span>
                                </a>
                            </th>
							<th class="text-center" width="7%">&nbsp;</th>
						</tr>
                    </thead>
					<tbody>
						<?php
						if(isset($results))
						{
							$html=NULL;
							foreach($results as $row)
							{
								$media_path = get_media_path($row->media_id);
								
								$html.='<tr>
									<td>
										<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$row->blog_id.'" />
									</td>
									<td>
										<img src="'.$media_path.'" width="30" height="30"> &nbsp; '.$row->blog_title.'
									</td>
									<td class="action text-right">
										<a href="'.base_url().'admin/blog/update/'.$row->blog_id.'">Update</a>
										<a href="'.base_url().'admin/blog/delete/'.$row->blog_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
									</td>
								</tr>';
							}
							echo $html;
						}
						?>
					</tbody>
                    <tfoot>
						<tr>
                            <th class="text-center check-column">
                                <input type="checkbox" class="custom-control-input selectall" name="selectAll" value="on" id="selectAll">
                            </th>
                            <th class="sorted <?php echo get_sorted_class('blog_title', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/blog', 'blog_title', 'asc'); ?>">
                                    <span>Title</span>
                                </a>
                            </th>
                            <th class="sorted <?php echo get_sorted_class('created_time', 'asc'); ?>">
                                <a href="<?php echo get_sorted_url('admin/blog', 'created_time', 'asc'); ?>">
                                    <span>Date</span>
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