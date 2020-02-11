<div class="body-wrapper">
	<div class="container">
		<?php		
		if(!$this->session->user_id)
		{
			$current_form = 'login';
			if(set_value('form_type') && set_value('form_type')=='signup')
			{
				$current_form = 'signup';
			}
			
			?><div id="login">
				<div class="login-title">Login with Computer Village</div>
				
				<?php if(validation_errors()) echo '<p class="required-error text-center" style="margin-bottom:5px;">Invalid Username or Password!</p>'; ?>
				
				<form class="form-login mt30" method="POST" action="<?=base_url('account/login_verify')?>">
					<div class="form-group">
						<label for="user_email">Email</label>
						<input type="text" class="form-control" name="user_email" id="user_email">
					</div>
					<div class="form-group">
						<label for="user_pass">Password</label>
						<input type="password" class="form-control" name="user_pass" id="user_pass">
					</div>
					<div class="form-action">
						<a href="<?=base_url('account/forgot-password/')?>">Forgot Password?</a>
						
						<?php
						if(isset($_GET['redirect_url']))
						{
							?><input type="hidden" name="redirect_url" value="<?=$_GET['redirect_url']?>"><?php
						}
						?>
						
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
				</form>
				<div class="signup-wrap">
					<div class="title">You have not acount yeat?</div>
					<a class="signup-action" href="<?=base_url('account/signup/')?>">Create New Account</a>
				</div>
			</div><?php
		}
		else
		{
			if(isset($_GET['page'])){ $page_type = $_GET['page']; }
			else{ $page_type = 'account'; }
			
			$customer_avatar = get_user_meta($this->session->user_id, 'customer_avatar');
			
			if(!$customer_avatar)
			{
				$customer_avatar = base_url('images/avtar.jpg');
			}
			
			$user_address 	= get_user_meta($this->session->user_id, 'user_address');
			$user_city 		= get_user_meta($this->session->user_id, 'user_city');
			$user_state 	= get_user_meta($this->session->user_id, 'user_state');
			$user_country 	= get_user_meta($this->session->user_id, 'user_country');
			
			?><div class="profile">
				<div class="row">
					<div class="col-sm-3 account-sidebar">
						<div class="innerbox">
							<div class="coverphoto">
								<img class="avatar" src="<?=$customer_avatar?>">
								<div class="name"><?=$this->session->user_name?></div>
							</div>
							<ul class="nav">
								<li>
									<a href="<?=base_url('account/')?>">
										<span class="glyphicon glyphicon-cog"></span> My Profile
									</a>
								</li>
								<li>
									<a href="?page=myorders">
										<span class="glyphicon glyphicon-briefcase"></span> My Orders
									</a>
								</li>
								<li>
									<a href="<?=base_url('pcbuilder/savedpc')?>">
										<span class="glyphicon glyphicon-cog"></span> Saved PC
									</a>
								</li>
								<li>
									<a href="?page=changepw">
										<span class="glyphicon glyphicon-qrcode"></span> Change Password
									</a>
								</li>
								<!--<li>
									<a href="?page=changephoto">
										<span class="glyphicon glyphicon-picture"></span> Change Photo
									</a>
								</li>-->
								<li>
									<a href="<?=base_url('logout')?>">
										<span class="glyphicon glyphicon-log-out"></span> Logout
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-sm-9 account-content">
						<p class="success-txt" hidden>Save Changes</p>
						<p class="failed-txt" hidden>Save Not Changes</p>
						
						<?php
						if($page_type=='changephoto')
						{
							?><div class="row">
								<div class="col-sm-8">
									<div class="page-header">
										<h1>Change Photo</h1>
									</div>
								</div>
							</div>
							
							<div class="innerbox editbox">
								<form method="post" id="changephoto" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-8">
											<div class="box">
												<div class="txtinfo">
													<div class="form-group">
														<label><input type="file" name="user_name" id="user_name" class="form-control" value="<?=$user_name?>"></label>
													</div>
												</div>
											</div>
											
											<input type="hidden" name="user_id" id="user_id" class="form-control" value="<?=$this->session->user_id?>">
											<button type="submit" class="btn btn-primary">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
							<?php
						}
						elseif($page_type=='myorders')
						{
							if(isset($_GET['view']) && !empty($_GET['view']))
							{
								$order_id = $_GET['view'];
								$result = get_result("SELECT * FROM `order` WHERE `order_id`=$order_id");
								//echo '<pre>'; print_r($result); echo '</pre>';
								
								if(isset($result) && count($result) > 0)
								{
									foreach($result as $order);
									
									?><div class="row">
										<div class="col-sm-12">
											<div class="page-header">
												<h1>My Orders <small>ID:<?=$order_id?></small></h1>
											</div>
										</div>
									</div>
									
									<div class="innerbox">
										<div class="row">
											<div class="col-md-6">
												<div class="box box-danger">
													<div class="box-header">
														<h3 class="box-title">Billing Info</h3>
													</div>
													<div class="box-body">
														<table class="table table-striped table-bordered table-hover">
														<tbody>
															<tr>
																<td>
																	<p><b>Name:</b> <?=$order->billing_name?></p>
																	<p><b>Phone:</b> <?=$order->billing_phone?></p>
																	
																	<?php if($order->payment_type=='direct_payment'){ ?>
																	
																		<p><b>Email:</b> <?=$order->billing_email?></p>
																		
																	<?php } ?>
																	
																	
																	<p>
																		<b>Address:</b><br/>
																		<?=$order->billing_address?>
																		
																		<?php
																		if($order->payment_type=='direct_payment')
																		{
																			?><br/><?=$order->billing_state?>, <?=$order->billing_country?><?php
																		}
																		?>
																	</p>
																</td>
															</tr>
														</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="box">
													<div class="box-header">
														<h3 class="box-title">Order Info</h3>
													</div>
													<div class="box-body">
														<table class="table table-striped table-bordered">
															<tr>
																<th class="name text-center">Product</th>
																<th class="image text-center">Image</th>
																<th class="quantity text-center">Qty</th>
																<th class="total text-right">Sub-Total</th>
															</tr>
															<?php
															$product_items = unserialize($order->products);
															//echo '<pre>'; print_r($product_items); echo '</pre>';
															
															foreach($product_items['items'] as $product_id=>$item)
															{
																$featured_image = isset($item['featured_image']) ? $item['featured_image'] : null;
																?><tr>
																	<td class="text-center">
																		<?=$item['name']?>
																	</td>
																	<td class="image text-center">
																		<img src="<?=$featured_image?>" height="50" width="50"/>
																	</td>
																	<td class="text-center">
																		<?=$item['qty']?>
																	</td>
																	<td class="text-right">
																		৳ <?=$item['subtotal']?>
																	</td>
																</tr><?php
															}
															?>
														</table>
														<table class="table table-striped table-bordered">
															<tbody>
																<tr>
																	<td>
																		<span class="extra bold totalamout">Total</span>
																	</td>
																	<td class="text-right">
																		<span class="bold totalamout">৳ <?=$order->order_total?></span>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="box box-primary">
													<div class="box-body">
														<div class="form-group">
															<label for="order_status">Order Status: </label>
															<?=ucwords($order->order_status)?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div><?php
								}
							}
							else
							{
								?><div class="row">
									<div class="col-sm-12">
										<div class="page-header">
											<h1>My Orders</h1>
										</div>
									</div>
								</div>
								
								<div class="innerbox">
									<table id="dataTable" class="table table-bordered table-striped">
									<tbody>
										<?php
										if(!isset($order_status) && empty($order_status)){
											$order_status = 'new';
										}

										$user_email = $this->session->user_email;
										
										$sql = "SELECT * FROM `order` WHERE `billing_email`='$user_email' ORDER BY order_id DESC";
										$result = get_result($sql);
										if(isset($result) && count($result) > 0)
										{
											$html=NULL;
											//echo '<pre>'; print_r($result); echo '</pre>';
											foreach($result as $row)
											{
												$html.='<tr>
													<td>'.$row->billing_name.'('.$row->billing_phone.')</td>
													<td class="text-center">৳ '.$row->order_total.'</td>
													<td class="action text-center">
														<a class="lnr lnr-eye" href="'.base_url().'account?page=myorders&view='.$row->order_id.'">View</a>
													</td>
												</tr>';
											}
											echo $html;
										}
										?>
									</tbody>
									</table>
								</div><?php
							}
						}
						elseif($page_type=='changepw')
						{
							?><div class="row">
								<div class="col-sm-8">
									<div class="page-header">
										<h1>Change Password</h1>
									</div>
								</div>
							</div>
							
							<div class="innerbox editbox">
								<form method="post" id="changepw" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-8">
											<div class="box">
												<div class="txtinfo">
													<div class="form-group">
														<label for="old_pass">Old Password</label>
														<input type="password" name="old_pass" id="old_pass" class="form-control"/>
													</div>
													<div class="form-group">
														<label for="user_pass">New Password</label>
														<input type="password" name="user_pass" id="user_pass" class="form-control"/>
													</div>
												</div>
											</div>
											
											<input type="hidden" name="user_id" id="user_id" class="form-control" value="<?=$this->session->user_id?>">
											<button type="submit" class="btn btn-primary">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
							<?php
						}
						else
						{
							$user_address = get_user_meta($this->session->user_id, 'user_address');
							$user_city = get_user_meta($this->session->user_id, 'user_city');
							$user_state = get_user_meta($this->session->user_id, 'user_state');
				
							?><div class="row">
								<div class="col-sm-8">
									<div class="page-header">
										<h1>My Profile</h1>
									</div>
								</div>
							</div>
							
							<div class="innerbox editbox">
								<form method="post" id="useredit" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-8">
											<div class="box">
												<div class="txtinfo">
													<div class="form-group">
														<label for="user_name">Name</label>
														<input type="text" name="user_name" id="user_name" class="form-control" value="<?=$this->session->user_name?>">
													</div>
													<div class="form-group">
														<label for="user_phone">Phone</label>
														<input type="text" name="user_phone" id="user_phone" class="form-control" value="<?=$this->session->user_phone?>">
													</div>
													<div class="form-group">
														<label for="user_email">Email</label>
														<input type="text" name="user_email" id="user_email" class="form-control" value="<?=$this->session->user_email?>">
													</div>
													<div class="form-group">
														<label for="user_address">Address</label>
														<input type="text" name="user_address" id="user_address" class="form-control" value="<?=$user_address?>">
													</div>
													<div class="form-group">
														<label for="user_city">City</label>
														<input type="text" name="user_city" id="user_city" class="form-control" value="<?=$user_city?>">
													</div>
													<div class="form-group">
														<label for="user_state">Division</label>
														<?php											
														echo form_dropdown('user_state', array(
															'Dhaka' => 'Dhaka',
															'Chittagong' => 'Chittagong',
															'Barisal' => 'Barisal',
															'Khulna' => 'Khulna',
															'Rajshahi' => 'Rajshahi',
															'Sylhet' => 'Sylhet',
															'Rangpur' => 'Rangpur',
														), $user_state, array('id'=>'user_state', 'class'=>'form-control'));
														?>
													</div>
												</div>
											</div>
											
											<input type="hidden" name="user_id" id="user_id" class="form-control" value="<?=$this->session->user_id?>">
											<button type="submit" class="btn btn-primary">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div><?php
		}
		?>
	</div>
</div>