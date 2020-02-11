<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=get_option('site_title')?> | Dashboard</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/iCheck/flat/blue.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/morris/morris.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?=base_url()?>adminfiles/custom/css/style.css">

	<script src="<?php echo base_url(); ?>adminfiles/plugins/jQuery/jquery-2.2.3.min.js"></script>

	<script>var ci_version = '<?=CI_VERSION?>';</script>
	<script>var base_url = '<?=base_url()?>';</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<header class="main-header">
		<a href="<?=base_url('admin')?>" class="logo">
			<span class="logo-mini"><b><?=get_option('site_title')?></b></span>
			<span class="logo-lg"><b><?=get_option('site_title')?></b></span>
		</a>
		<nav class="navbar navbar-static-top">
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?=base_url()?>" target="_blank"><i class="fa fa-home"></i></a>
					</li>
					<li>
						<a href="<?=base_url('admin/logout')?>"><i class="fa fa-sign-out"></i></a>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<aside class="main-sidebar">
		<section class="sidebar">
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?=base_url()?>adminfiles/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p><?=$this->session->user_name?></p>
					<p>Role: <?=ucwords($this->session->user_type)?></p>
				</div>
			</div>
			
			<ul class="sidebar-menu">
				<li class="header">MAIN NAVIGATION</li>
                <?php
                if(has_permission('users', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/users'); ?>" class="<?php echo (isset($menu_group) && $menu_group == 'users') ? 'active' : ''; ?>">
                        	<i class="fa fa-users"></i>  Users
                        </a>                           
                    </li><?php
                }
                
                if(has_permission('order', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/order'); ?>" class="<?php echo (isset($menu_group) && $menu_group == 'order') ? 'active' : ''; ?>">
                        	<i class="fa fa-shopping-bag"></i>  Orders
                        </a>                           
                    </li><?php
                }
                ?>

                <?php
                if(has_permission('product', 'index'))
            	{
            		?><li class="treeview">
                        <a href="<?php echo site_url('admin/product'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-product-hunt"></i>  Products
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
						<ul class="treeview-menu">
			                <?php
			                if(has_permission('product', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/product'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Manage Products
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('product', 'add_new'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/product/add_new'); ?>" class="<?php echo (isset($page_active) && $page_active == 'add_new') ? 'active' : ''; ?>">
			                        	Add New Product
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('category', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/category'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Category
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('brand', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/brand'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Brands
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('product', 'review'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/product/review'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Product Reviews
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('product', 'top_view_product'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/product/top_view_product'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Top View Products
			                        </a>                           
			                    </li><?php
			                }
			                ?>
						</ul>
                    </li><?php
                }

                if(has_permission('service', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/service'); ?>" class="<?php echo (isset($page_active) && $page_active == 'service') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i> Service
                        </a>                           
                    </li><?php
                }

                if(has_permission('admin', 'brands_tab'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/brands_tab'); ?>" class="<?php echo (isset($page_active) && $page_active == 'brands_tab') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i> Brands Tab
                        </a>                           
                    </li><?php
                }

                if(has_permission('blog', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/blog'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i> ICT Topics
                        </a>                           
                    </li><?php
                }

                if(has_permission('news', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/news'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i> News
                        </a>                           
                    </li><?php
                }

                if(has_permission('offer', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/offer'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i> Offer
                        </a>                           
                    </li><?php
                }

                if(has_permission('admin', 'inquiry'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/inquiry'); ?>" class="<?php echo (isset($page_active) && $page_active == 'inquiry') ? 'active' : ''; ?>">
                        	<i class="fa fa-envelope"></i>  Inquiries
                        </a>                           
                    </li><?php
                }

                if(has_permission('admin', 'feedback'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/feedback'); ?>" class="<?php echo (isset($page_active) && $page_active == 'feedback') ? 'active' : ''; ?>">
                        	<i class="fa fa-envelope"></i>  Feedback
                        </a>                           
                    </li><?php
                }

                if(has_permission('admin', 'careerinquiry'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/careerinquiry'); ?>" class="<?php echo (isset($page_active) && $page_active == 'careerinquiry') ? 'active' : ''; ?>">
                        	<i class="fa fa-envelope"></i>  Career Inquiries
                        </a>                           
                    </li><?php
                }

                if(has_permission('pcbuilder', 'settings'))
            	{
            		?><li class="treeview">
                        <a href="<?php echo site_url('admin/pcbuilder/settings'); ?>" class="<?php echo (isset($page_active) && $page_active == 'settings') ? 'active' : ''; ?>">
                        	<i class="fa fa-shopping-bag"></i> PC Builder
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
						<ul class="treeview-menu">
			                <?php
			                if(has_permission('pcbuilder', 'settings'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/pcbuilder/settings'); ?>" class="<?php echo (isset($page_active) && $page_active == 'settings') ? 'active' : ''; ?>">
			                        	Settings
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('pcbuilder', 'product_mapping'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/pcbuilder/product_mapping'); ?>" class="<?php echo (isset($page_active) && $page_active == 'product_mapping') ? 'active' : ''; ?>">
			                        	Product Mapping
			                        </a>                           
			                    </li><?php
			                }
			                
			                if(has_permission('pcbuilder', 'admin_quote'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/pcbuilder/admin_quote'); ?>" class="<?php echo (isset($page_active) && $page_active == 'admin_quote') ? 'active' : ''; ?>">
			                        	Quote
			                        </a>                           
			                    </li><?php
			                }
			                ?>
						</ul>
                    </li><?php
                }

                if(has_permission('admin', 'visitors'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/visitors'); ?>" class="<?php echo (isset($page_active) && $page_active == 'visitors') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i>  Visitors
                        </a>                           
                    </li><?php
                }

                if(has_permission('media', 'index'))
            	{
            		?><li class="treeview">
                        <a href="<?php echo site_url('admin/media'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-shopping-bag"></i> Media
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
						<ul class="treeview-menu">
			                <?php
			                if(has_permission('media', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/media'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Media Files
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('homeslider', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/homeslider'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Sliders
			                        </a>                           
			                    </li><?php
			                }
			                
			                if(has_permission('adds', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/adds'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
			                        	Ads
			                        </a>                           
			                    </li><?php
			                }
			                ?>
						</ul>
                    </li><?php
                }

                if(has_permission('recyclebin', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/recyclebin'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i>  Recycle Bin
                        </a>                           
                    </li><?php
                }

                if(has_permission('page', 'index'))
            	{
            		?><li>
                        <a href="<?php echo site_url('admin/page'); ?>" class="<?php echo (isset($page_active) && $page_active == 'manage') ? 'active' : ''; ?>">
                        	<i class="fa fa-circle-o"></i>  Pages
                        </a>                           
                    </li>
                    
                    
                    <?php
                }
                #  if(has_permission('admin', 'options') || permission('admin', 'homesettings') || $this->session->user_type == 'super-admin')

                if(has_permission('Coupon', 'index') || has_permission('Coupon', 'add_new') )
            	{
            		?><li class="treeview">
                        <a href="<?php echo site_url('admin/options'); ?>" class="<?php echo (isset($page_active) && $page_active == 'options') ? 'active' : ''; ?>">
                        	<i class="fa fa-wrench"></i> Coupons
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
						<ul class="treeview-menu">
			                <?php
			                if(has_permission('Coupon', 'add_new'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/Coupon/add_new'); ?>" class="<?php echo (isset($page_active) && $page_active == 'add_new') ? 'active' : ''; ?>">
			                        	Add Coupon
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('Coupon', 'index'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/Coupon/index'); ?>" class="<?php echo (isset($page_active) && $page_active == 'index') ? 'active' : ''; ?>">
			                        View Coupons
			                        </a>                           
			                    </li><?php
			                }
			                
			            		?>
						</ul>
                    </li><?php
                }
                ?>
                    
                    <?php
               
                #  if(has_permission('admin', 'options') || permission('admin', 'homesettings') || $this->session->user_type == 'super-admin')

                if(has_permission('admin', 'options') || has_permission('admin', 'homesettings') || $this->session->user_type == 'super-admin')
            	{
            		?><li class="treeview">
                        <a href="<?php echo site_url('admin/options'); ?>" class="<?php echo (isset($page_active) && $page_active == 'options') ? 'active' : ''; ?>">
                        	<i class="fa fa-wrench"></i> Setting Options
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
						<ul class="treeview-menu">
			                <?php
			                if(has_permission('admin', 'options'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/options'); ?>" class="<?php echo (isset($page_active) && $page_active == 'options') ? 'active' : ''; ?>">
			                        	Default Settings
			                        </a>                           
			                    </li><?php
			                }

			                if(has_permission('admin', 'homesettings'))
			            	{
			            		?><li>
			                        <a href="<?php echo site_url('admin/homesettings'); ?>" class="<?php echo (isset($page_active) && $page_active == 'homesettings') ? 'active' : ''; ?>">
			                        	Home Settings
			                        </a>                           
			                    </li><?php
			                }
			                
							if($this->session->user_type == 'super-admin')
							{
			            		?><li>
			                        <a href="<?php echo site_url('admin/permission'); ?>" class="<?php echo (isset($page_active) && $page_active == 'permission') ? 'active' : ''; ?>">
			                        	User Permission
			                        </a>                           
			                    </li><?php
			                }
			                ?>
						</ul>
                    </li><?php
                }
                ?>
			</ul>
		</section>
	</aside>

	<div class="content-wrapper">
		<section class="content-header">
            <h1 class="page_title">
                <?php echo $page_title; ?>
                
                <?php
                if (isset($action_button))
                {
                	?><a href="<?php echo (isset($action_button['url'])) ? $action_button['url'] : 'javascript:void(0)'; ?>" class="page-title-action"><?php echo (isset($action_button['title'])) ? $action_button['title'] : 'undefine'; ?></a><?php
                }
                ?>
			</h1>

            <?php if (validation_errors()) { ?>
                <div class="cus_alert alert alert-warning alert-dismissible show" role="alert">
                    <?php echo validation_errors(); ?>
                </div>
            <?php } ?>
			
			<?php
			// error message view section
			$view_error_msg = '';
			if ($this->session->flashdata('error_msg') != '')
			$view_error_msg .= $this->session->flashdata('error_msg');
			if (isset($error_msg))
			$view_error_msg .= $error_msg;
			if(!empty($view_error_msg))
			{
				?><div class="cus_alert alert alert-danger alert-dismissible show" role="alert">
					<?php echo $view_error_msg; ?>
				</div><?php
			}

			// success message section
			$view_success_msg = '';
			if ($this->session->flashdata('success_msg') != '')
			$view_success_msg = $this->session->flashdata('success_msg');
			if (isset($success_msg))
			$view_success_msg .= $success_msg;
			if (!empty($view_success_msg))
			{
				?><div class="cus_alert alert alert-success alert-dismissible show" role="alert">
					<?php echo $view_success_msg; ?>
				</div><?php
			}
			?>
		</section>
		
		<section class="content">
			<?php echo!empty($layout) ? $layout : ''; ?>
		</section>
	</div>

	<footer class="main-footer">
		<strong>Copyright &copy; 2017 <a href="#">isolutionsbd</a>.</strong> All rights reserved.
	</footer>
	
	<div id="confirmAlertBox" style="display:none;">
		<div class="modal-header">CONFIRMATION</div>
		<div class="message">Are you sure to process?</div>
		<a id="yesConfirm">Yes</a>
		<a id="noConfirm">No</a>
	</div>
</div>


<script src="<?php echo base_url(); ?>adminfiles/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/dist/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/datepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/plugins/datepicker/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>adminfiles/custom/js/admin.js"></script>

<script>
$(document).ready(function(){
	$('#dataTable').DataTable({
		responsive: true,
		"pageLength": 100,
		"lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]]
	});
    $("#close").click(function(){
		$("#message").addClass("hidden");
    });
	$('.checkConfirm').click(function(){
        var answer = confirm("Are You Sure to Process?");
        return !!answer;
    });
	$('.checkReUpload').click(function(){
		$('.oldImage').prev().show();
    });
});


$('#datepicker').datepicker({
	autoclose: true
});
$('.datepicker').datepicker({
	autoclose: true
});
$('.datetimepicker').datetimepicker({
    defaultDate: "<?php echo date('Y-m-d H:i'); ?>"    
});


$("#checkAll").change(function()
{
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});


jQuery(function()
{
	jQuery(".select2").select2();
});


$('.datepicker').datepicker({
  autoclose: true
});


jQuery(document).ready(function()
{
	jQuery('.the_title').on('input', function(){
		//alert('changed');
		var this_val = jQuery(this).val().toLowerCase();
		var this_val2 = jQuery(this).val().toLowerCase();
		this_val = this_val.replace(/\s/g,"-");

		var inputString = "~!@#$%^&*()_+=`{}[]|\:;'<>, "+this_val2,
		outputString = inputString.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'');
		
		/*alert(outputString);*/
		jQuery('.the_name').val(outputString);
	});
});


/*# produt sort by cat for admin #*/
jQuery('.sortbycat select').change(function(e)
{
	var current_url = '<?=base_url('admin/product')?>';
	
	var sortbycat = jQuery('.sortbycat select').val().trim();
	
	if(sortbycat)
	{
		location.replace(current_url+'/?sortbycat='+sortbycat);
		
		return false;
	}
});


/*# order sort by date time #*/
jQuery('.sortbytime select').change(function(e)
{
	if(window.location.hostname=='localhost')
	{
		var current_url = 'http://'+window.location.hostname+window.location.pathname;
	}
	else
	{
		var current_url = 'https://'+window.location.hostname+window.location.pathname;
	}
	
	var sortbytime = jQuery('.sortbytime select').val().trim();
	
	if(sortbytime)
	{
		location.replace(current_url+'?sortbytime='+sortbytime);
		
		return false;
	}
});


/*### pc builder settings ###*/
jQuery('body').on('click', '.component_closer', function()
{
	jQuery(this).parents('.box.box-warning').remove();
});

jQuery('.components-group a.add_another_component').on('click', function(e)
{
	var this_component		= jQuery(this);
	var component_no 		= jQuery('.components-group input[name=component_no]').val();
	var component_no 		= parseInt(component_no);
	var next_component_no 	= component_no+1;

	jQuery('.components-group input[name=component_no]').val(next_component_no);
	
	var html_val = '<div class="box box-warning" style="border-color:#f39c12;"><div class="box-header"><h3 class="box-title">Component '+component_no+'</h3><div class="component_closer">x</div></div><div class="box-body"><div class="form-group"><div class="row"><div class="col-sm-4"><label>Component Name</label><input type="text" class="form-control" name="component['+component_no+'][component_name]"></div><div class="col-sm-4"><label>Component ID</label><input type="text" class="form-control" name="component['+component_no+'][component_id]"></div><div class="col-sm-4"><label>Is Required to Choose <small>0/1</small></label><input type="number" class="form-control" name="component['+component_no+'][required]" max="1" min="0"></div></div></div></div></div>';
	
	jQuery('.components-group .components-inner').append(html_val);
	
	return false;
});
</script>
</body>
</html>