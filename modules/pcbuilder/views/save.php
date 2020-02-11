<section id="mpart">
	<div class="container">
		<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
			You are in: 
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?=base_url()?>" itemprop="item">
					<span itemprop="name">Home</span>
				</a>
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?=base_url('pcbuilder')?>" itemprop="item">
					<span itemprop="name">PC Builder</span>
				</a>
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name"><?=$page_title?></span>
			</li>
		</ul>

		<hr class="break break20">

		<?php
		$customer_avatar = get_user_meta($this->session->user_id, 'customer_avatar');
		if(!$customer_avatar)
		{
			$customer_avatar = base_url('images/avtar.jpg');
		}
		?>

		<div class="profile">
			<div class="row">
				<div class="col-sm-3 account-sidebar">
					<div class="innerbox">
						<div class="coverphoto">
							<img class="avatar" src="<?=$customer_avatar?>">
							<div class="name"><?=$this->session->user_name?></div>
						</div>
						<ul class="nav">
							<li>
								<a href="<?=base_url('account')?>">
									<span class="glyphicon glyphicon-cog"></span> My Profile
								</a>
							</li>
							<li>
								<a href="<?=base_url('account/?page=myorders')?>">
									<span class="glyphicon glyphicon-briefcase"></span> My Orders
								</a>
							</li>
							<li>
								<a href="<?=base_url('pcbuilder/savedpc')?>">
									<span class="glyphicon glyphicon-cog"></span> Saved PC
								</a>
							</li>
							<li>
								<a href="<?=base_url('account/?page=changepw')?>">
									<span class="glyphicon glyphicon-qrcode"></span> Change Password
								</a>
							</li>
							<li>
								<a href="<?=base_url('logout')?>">
									<span class="glyphicon glyphicon-log-out"></span> Logout
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-sm-9 account-content">
					<div class="row">
						<div class="col-sm-8">
							<div class="page-header">
								<h1><?=$page_title?></h1>
							</div>
						</div>
					</div>
						
					<div class="innerbox editbox">
						<form method="post" action="<?=base_url('pcbuilder/save')?>" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-8">
									<div class="box">
										<div class="txtinfo">
											<div class="field-required">
												<?=validation_errors()?>
											</div>

											<div class="form-group">
												<label for="name">Name<span class="field-required">*</span></label>
												<input type="text" name="name" id="name" class="form-control"/>
											</div>
											<div class="form-group">
												<label for="description">Description</label>
												<input type="text" name="description" id="description" class="form-control"/>
											</div>
										</div>
									</div>
									<a href="<?=base_url('pcbuilder')?>" class="btn btn-default">Back</a>
									<button type="submit" class="btn btn-primary pull-right">Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>