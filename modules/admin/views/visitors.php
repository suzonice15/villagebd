<?php
$visitor_by_date = date("Y-m-d");

if(isset($_POST['visitor_by_date']))
{
	$visitor_by_date = date("Y-m-d", strtotime($_POST['visitor_by_date']));
}

$visitors = get_hitcounters($visitor_by_date);
?>

<div class="box">
	<div class="box-body">
		<form method="POST">
			<div class="row">
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-9">
							<div class="input-group date" style="float:left;width:250px;">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								
								<?=form_input(array('name'=>'visitor_by_date', 'class'=>'form-control pull-right datepicker'))?>
							</div>
						</div>
						<div class="col-sm-3">
							<input type="submit" value="Visitor by Date" class="btn btn-default"/>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br/>
		<div class="row">
			<div class="col-sm-12">
				<div style="font-size:20px;">
					Total Visitor<?=count($visitors) > 1 ? 's' : NULL?> on <?=$visitor_by_date?>: &nbsp;&nbsp; <?=count($visitors)?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="box">
	<div class="box-body">
		<h3 style="margin-top:0px;font-size:20px;font-weight:600;">Visitors by Date Limit</h3>
		<form method="POST">
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-9">
							<div class="form-group" style="float:left;width:250px;">
								<label>Date From</label><br/>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									
									<?=form_input(array('name'=>'visitor_by_date_from', 'class'=>'form-control pull-right datepicker'))?>
								</div>
							</div>
							
							<div class="form-group" style="float:left;width:250px;margin-left:10px;">
								<label>Date To</label><br/>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									
									<?=form_input(array('name'=>'visitor_by_date_to', 'class'=>'form-control pull-right datepicker'))?>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>&nbsp;</label><br/>
								<input type="submit" name="visitor_by_date_limit" value="Visitors by Date Limit" class="btn btn-default"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br/>
		<div class="row">
			<div class="col-sm-12">
				<div style="font-size:20px;">
					<?php
					if(isset($_POST['visitor_by_date_limit']) && isset($_POST['visitor_by_date_from']) && isset($_POST['visitor_by_date_to']))
					{
						$visitor_by_date_from = date("Y-m-d", strtotime($_POST['visitor_by_date_from']));
						$visitor_by_date_to = date("Y-m-d", strtotime($_POST['visitor_by_date_to']));
						
						$visitors = get_hitcounters_by_limit($visitor_by_date_from, $visitor_by_date_to); ?>
						
						Total Visitor<?=count($visitors) > 1 ? 's' : NULL?> between <?=$visitor_by_date_from?> to <?=$visitor_by_date_to?>: &nbsp;&nbsp; <?=count($visitors)?><?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>