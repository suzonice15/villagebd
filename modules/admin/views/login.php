<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin<?php echo get_option('site_title'); ?> | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('adminfiles/bootstrap/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url('adminfiles/dist/css/AdminLTE.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('adminfiles/plugins/iCheck/square/blue.css'); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<b>Dashboard</b><br/>
		<?php echo get_option('site_title'); ?>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>
	
		<?php echo validation_errors('<p class="login-box-msg" style="color:#f00;text-align:center">', '</p>'); ?>

		<form action="<?php echo base_url(); ?>admin/login_verify" method="post">
			<div class="form-group has-feedback">
				<input type="email" name="user_email" class="form-control" value="<?php if(isset($_GET['user_email'])) echo $_GET['user_email']; ?>" placeholder="Email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="user_pass" class="form-control" value="<?php if(isset($_GET['user_pass'])) echo $_GET['user_pass']; ?>" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="<?php echo base_url('adminfiles/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?php echo base_url('adminfiles/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('adminfiles/plugins/iCheck/icheck.min.js'); ?>"></script>

<script>
$(function(){
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%'
	});
});
</script>
</body>
</html>