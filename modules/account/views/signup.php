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
			
			?><div id="signup">
				<div class="signup-title">Signup to Computer Village</div>
				
				<?=validation_errors('<p class="required-error text-center" style="margin-bottom:5px;">', '</p>')?>
				
				<form class="form-signup mt30" method="POST" action="<?=base_url('account/signup_process')?>">
					<div class="form-group <?=form_error('user_name') ? 'has-error' : ''?>">
						<label for="user_name">Name</label>
						<input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo set_value('user_name'); ?>">
					</div>
					<div class="form-group <?=form_error('user_email') ? 'has-error' : ''?>">
						<label for="user_email">Email</label>
						<input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo set_value('user_email'); ?>">
					</div>
					<div class="form-group <?=form_error('user_phone') ? 'has-error' : ''?>">
						<label for="user_phone">Phone</label>
						<input type="text" class="form-control" name="user_phone" id="user_phone" value="<?php echo set_value('user_phone'); ?>">
					</div>
					<div class="form-group <?=form_error('user_pass') ? 'has-error' : ''?>">
						<label for="user_pass">Password</label>
						<input type="password" class="form-control" name="user_pass" id="user_pass">
					</div>
					<div class="form-action">
						<button type="submit" class="btn btn-primary">Signup</button>
					</div>
				</form>
				<div class="login-wrap">
					<div class="title">Already have account?</div>
					<a class="login-action" href="<?=base_url('account/')?>">Login Now</a>
				</div>
			</div><?php
		}
		else
		{
			$customer_avatar = get_user_meta($user_id, 'customer_avatar');
			if(!$customer_avatar)
			{
				$customer_avatar = base_url('images/avtar.jpg');
			}
			
			?><div class="profile">
				<div class="row">
					<div class="col-sm-3 account-sidebar">
						<div class="innerbox">
							<div class="coverphoto">
								<img class="avatar" src="<?=$customer_avatar?>">
								<div class="name"><?=$user_name?></div>
							</div>
							<ul class="nav">
								<li>
									<a href="<?=base_url('account/')?>">
										<span class="glyphicon glyphicon-cog"></span> My Profile
									</a>
								</li>
								<li>
									<a href="?page=myprod">
										<span class="glyphicon glyphicon-briefcase"></span> My Courses
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-sm-9 account-content">
						<div class="page-header">
							<h1>My Profile</h1>
						</div>
						
						<p class="success-txt" hidden>Save Changes</p>
						<p class="failed-txt" hidden>Save Not Changes</p>
						
						<div class="innerbox editbox">
							<form method="post" id="useredit" enctype="multipart/form-data">
								<div class="row">
									<div class="col-sm-8">
										<div class="box">
											<div class="txtinfo">
												<div class="form-group">
													<label for="user_name">Name</label>
													<input type="text" name="user_name" id="user_name" class="form-control" value="<?=$user_name?>">
												</div>
												<div class="form-group">
													<label for="user_email">Email</label>
													<input type="text" name="user_email" id="user_email" class="form-control" value="<?=$user_email?>">
												</div>
												<div class="form-group">
													<label for="upass">Password</label>
													<input type="text" name="upass" id="upass" class="form-control">
												</div>
												<div class="form-group">
													<label for="user_phone">Phone</label>
													<input type="text" name="user_phone" id="user_phone" class="form-control" value="<?=$user_phone?>">
												</div>
												<div class="form-group">
													<label for="user_address">Address</label>
													<input type="text" name="user_address" id="user_address" class="form-control" value="">
												</div>
												<div class="form-group">
													<label for="user_city">City</label>
													<input type="text" name="user_city" id="user_city" class="form-control" value="">
												</div>
												<div class="form-group">
													<label for="user_state">State</label>
													<input type="text" name="user_state" id="user_state" class="form-control" value="">
												</div>
												<div class="form-group">
													<label for="user_country">Country</label>
													<input type="text" name="user_country" id="user_country" class="form-control" value="">
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-primary">Save Changes</button>
									</div>
									<div class="col-sm-4">
										<div class="box picture">
											<img src="https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/11667501_1455437001444293_7200907047077946509_n.jpg?oh=05fb7c639a217a6a91b584fd50d611c0&amp;oe=5979A445" width="100" height="100" alt="">
											<label class="btn btn-primary">
												<span>Change Photo</span>
												<input type="file" name="avatar" id="avatar">
												<p>Size: 100x100</p>
											</label>
										</div>
										<div class="box account-activation">
											<label class="btn btn-primary">
												<span>Change Photo</span>
												<input type="file" name="avatar" id="avatar">
												<p>Size: 100x100</p>
											</label>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div><?php
		}
		?>
	</div>
</div>