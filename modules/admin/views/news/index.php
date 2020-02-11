<table id="dataTable" class="table table-bordered table-striped">
<thead>
	<tr>
		<th><input type="checkbox" id="checkAll"></th>
		<th>News</th>
		<th hidden>News Name</th>
		<th>Created Date</th>
		<th class="text-right">&nbsp;</th>
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
					<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$row->news_id.'" />
				</td>
				<td>'.$row->news_title.'</td>
				<td hidden>'.$row->news_name.'</td>
				<td>'.date("d-M-Y", strtotime($row->created_time)).'</td>
				<td class="action text-right">
                    <a href="'.base_url().'admin/news/update/'.$row->news_id.'">Update</a>
                    <a href="'.base_url().'admin/news/delete/'.$row->news_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
				</td>
			</tr>';
		}
		
		echo $html;
	}
	?>
</tbody>
</table>