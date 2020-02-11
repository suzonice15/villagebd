<?php //echo '<pre>'; print_r($products); echo '</pre>'; ?>
<?php if(isset($user_sidebar)) echo $user_sidebar; ?>

<div class="content-wrapper">
	<section class="content-header">
		<h1><?=$page_title?></h1>
		<ol class="breadcrumb">
			<li><a href=""<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?=$page_title?></li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
						<form method="POST">
							<div class="btnarea">
								<div class="row">
									<div class="col-md-8 col-sm-6 col-xs-12">
										<?php echo get_req_message(); ?>
									</div>
									<div class="col-md-4 col-sm-6 col-xs-12" style="text-align:right;">
										<input type="submit" name="delete" value="Delete" class="btn btn-default" id="del_all" data-table="quote"/>
									</div>
								</div>
							</div>
							<div class="result">
								<table id="dataTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th><input type="checkbox" id="checkAll"></th>
										<th>#</th>
										<th colspan="3">Customer</th>
										<th>Quote Time</th>
										<th class="text-right">&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($quotes))
									{
										$html = null;

										$i = 1;

										foreach($quotes as $quote)
										{
											$slr = $i < 10 ? '0'.$i : $i;

											$user_data 	= get_row('users', 'user_id', $quote->user_id);
											
											$user_name = $user_email = $user_phone = null;

											if($user_data)
											{
												$user_name 	= $user_data->user_name;
												$user_email = $user_data->user_email;
												$user_phone = $user_data->user_phone;
											}

											$class 		= ($quote->email_send == 'no') ? 'unread' : 'read';

											$html.='<tr>
												<td>
													<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$quote->quote_id.'" />
												</td>
												<td class="'.$class.'">'.$slr.'</td>
												<td class="'.$class.'">'.$user_name.'</td>
												<td class="'.$class.'">'.$user_email.'</td>
												<td class="'.$class.'">'.$user_phone.'</td>
												<td class="'.$class.'">'.date("d-M-Y h:i:s a", strtotime($quote->created_time)).'</td>
												<td class="action text-right">
													<a class="lnr lnr-eye" href="'.base_url().'admin/pcbuilder/quote/view/'.$quote->quote_id.'">&nbsp;</a>
													<a class="lnr lnr-trash delete" href="javascript:void(0);" data-row_id="'.$quote->quote_id.'" data-table="quote">&nbsp;</a>
												</td>
											</tr>';

											$i++;
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
			</div>
		</div>
	</section>
</div>