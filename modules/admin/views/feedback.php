<div class="box">
	<div class="box-body">
		<form method="POST">
			<div class="btnarea">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12" style="text-align:right;">
						<input type="submit" name="delete" value="Delete" class="btn btn-default" id="del_all" data-table="feedback"/>
					</div>
				</div>
			</div>
			<div class="result">
				<table id="dataTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><input type="checkbox" id="checkAll"></th>
						<th>Page</th>
						<th>Email or Phone</th>
						<th>Rating Date</th>
						<th class="text-right">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT * FROM `feedback` ORDER BY feedback_id DESC";
					$result = get_result($sql);
					if(isset($result))
					{
						$html=NULL;
						foreach($result as $row)
						{
							$html.='<tr>
								<td>
									<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$row->feedback_id.'" />
								</td>
								<td>
									<a href="'.base_url().'admin/feedback/view/'.$row->feedback_id.'">'.$row->page.'</a>
								</td>
								<td>
									<a href="'.base_url().'admin/feedback/view/'.$row->feedback_id.'">'.$row->email_or_phone.'</a>
								</td>
								<td>
									<a href="'.base_url().'admin/feedback/view/'.$row->feedback_id.'">'.date("d-M-Y", strtotime($row->created_time)).'</a>
								</td>
								<td class="action text-right">
									<a href="'.base_url().'admin/feedback/view/'.$row->feedback_id.'">Update</a>
									<a href="'.base_url().'admin/feedback/delete/'.$row->feedback_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
								</td>
							</tr>';
						}
						echo $html;
					}
					?>
				</tbody>
				</table>
			</div>
		</form>
	</div>
</div>