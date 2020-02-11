<div class="box">
	<div class="box-body">
		<form method="POST">
			<div class="result">
				<table id="dataTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th style="width:15%">Name</th>
						<th style="width:15%">Email</th>
						<th style="width:30%">Comment</th>
						<th style="width:25%">Product</th>
						<th style="width:12%">Review Date</th>
						<th class="text-right" style="width:3%">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT * FROM `review` ORDER BY review_id DESC";
					$result = get_result($sql);
					if(isset($result))
					{
						$html=NULL;
						foreach($result as $row)
						{
							$html.='<tr>
								<td>'.$row->name.'</td>
								<td>'.$row->email.'</td>
								<td>'.$row->comment.'</td>
								<td>'.get_product_title($row->product_id).'</td>
								<td>'.date("d-M-Y", strtotime($row->created_time)).'</td>
								<td class="action text-right">
									<a class="lnr lnr-trash delete" href="javascript:void(0);" data-row_id="'.$row->review_id.'" data-table="review">&nbsp;</a>
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