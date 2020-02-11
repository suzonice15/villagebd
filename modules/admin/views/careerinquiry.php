<div class="box">
	<div class="box-body">
		<form method="POST">
			<div class="btnarea">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12" style="text-align:right;">
						<input type="submit" name="delete" value="Delete" class="btn btn-default" id="del_all" data-table="career"/>
					</div>
				</div>
			</div>
			<div class="result">
				<table id="dataTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><input type="checkbox" id="checkAll"></th>
						<th>Name</th>
						<th>Email</th>
						<th>CV</th>
						<th>Date</th>
						<th class="text-right">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT * FROM `career` ORDER BY career_id DESC";
					$result = get_result($sql);
					if(isset($result))
					{
						$html=NULL;
						foreach($result as $row)
						{
							$cv_ext=explode("@",$row->email);
							
							$html.='<tr>
								<td>
									<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$row->career_id.'" />
								</td>
								<td>'.$row->name.'</td>
								<td>'.$row->email.'</td>
								<td><a href="'.base_url($row->cv).'" download="'.$cv_ext[0].'_cv">Download</a></td>
								<td>'.date("d-M-Y", strtotime($row->created_time)).'</td>
								<td class="action text-right">
									<a class="lnr lnr-trash delete" href="javascript:void(0);" data-row_id="'.$row->career_id.'" data-table="career">&nbsp;</a>
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