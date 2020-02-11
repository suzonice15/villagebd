<div class="box">
	<div class="box-body">
		<div class="result view">
			<table class="table table-bordered table-striped">
				<tr>
					<td>Page</td>
					<td><?=$feedback_row->page?></td>
				</tr>
				<tr>
					<td>Email or Phone</td>
					<td><?=$feedback_row->email_or_phone?></td>
				</tr>
				<tr>
					<td>Purpose of Visit</td>
					<td><?=$feedback_row->purpose_of_visit?></td>
				</tr>
				<tr>
					<td>Ability to complete the purpose of visit</td>
					<td><?=$feedback_row->where_of_visit?></td>
				</tr>
				<tr>
					<td>Often of visit</td>
					<td><?=$feedback_row->how_of_visit?></td>
				</tr>
				<tr>
					<td>Content Rating</td>
					<td><?=$feedback_row->content_rating?></td>
				</tr>
				<tr>
					<td>Design Rating</td>
					<td><?=$feedback_row->design_rating?></td>
				</tr>
				<tr>
					<td>Easy of Use Rating</td>
					<td><?=$feedback_row->easy_use_rating?></td>
				</tr>
				<tr>
					<td>Overall Rating</td>
					<td><?=$feedback_row->overall_rating?></td>
				</tr>
				<tr>
					<td>Review</td>
					<td><?=$feedback_row->review?></td>
				</tr>
				<tr>
					<td>Date</td>
					<td><?=date("d-M-Y", strtotime($feedback_row->created_time))?></td>
				</tr>
			</table>
		</div>
	</div>
</div>