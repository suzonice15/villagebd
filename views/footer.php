<?php
/*# create new visitor #*/
create_hitcounter();
?>

<footer id="footer">
	<div class="container">
		<div class="link-faprt">
			<div class="row seven-cols">
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address1')?>
				</div>
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address2')?>
				</div>
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address3')?>
				</div>
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address4')?>
				</div>
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address5')?>
				</div>
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address6')?>
				</div>
				<div class="col-md-1 link-faprt-box">
					<?=get_option('footer_address7')?>
				</div>
			</div>
		</div>
	</div>
	<div class="footernav">
		<div class="container">
			<?=get_option('footer_menu')?>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			<div class="row"> 
				<div class="col-sm-8">
					<div class="pull-left copy-text"><?=get_option('copyright')?> &copy; <?php echo  date('Y');?> || Powered By <a href="https://www.isolutionsbd.com/" target="_blank">iSolutions</a></div>
				</div>
				<div class="col-sm-4">
					<ul class="social-link pull-right">
						<li>
							<a class="round1" target="_blank">
								<img src="<?php echo base_url('images/blank-img.png'); ?>" class="tweet-icon"/>
							</a>
						</li>
						<li>
							<a href="<?=get_option('social_fb')?>" class="round2" target="_blank">
								<img src="<?php echo base_url('images/blank-img.png'); ?>" class="fb-icon"/>
							</a>
						</li>
						<li>
							<a class="round3" target="_blank">
								<img src="<?php echo base_url('images/blank-img.png'); ?>" class="gplus-icon"/>
							</a>
						</li>
						<li>
							<a class="round4" target="_blank">
								<img src="<?php echo base_url('images/blank-img.png'); ?>" class="link-icon"/>
							</a>
						</li>
						<li>
							<a href="<?=get_option('social_yt')?>" class="round5" target="_blank">
								<img src="<?php echo base_url('images/blank-img.png'); ?>" class="you-icon"/>
							</a>
						</li>
						<li>
							<a class="round5" target="_blank">
								<img src="<?php echo base_url('images/blank-img.png'); ?>" class="pn-icon"/>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>

<div class="footersticky">
	<div class="container">
		<div class="row">
			<div class="col-md-12 newssscroll">
				<marquee onmouseout="this.start()" onmouseover="this.stop()" scrolldelay="1" scrollamount="3" align="center" behavior="scroll">
					<?php
					$scroll_elm = base_url('images/sli.jpg');
					$latest_news = get_result("SELECT * FROM `news` where status=1 ORDER BY news_id DESC LIMIT 20");
					/*echo '<pre>'; print_r($rows); echo '</pre>';*/
					if(count($latest_news) > 0)
					{
						foreach($latest_news as $news)
						{
							echo '<a href="'.base_url('news/'.$news->news_id.'/'.$news->news_name).'"><i class="fa fa-circle-o"></i> '.$news->news_title.'</a>';
						}
					}
					?>
				</marquee>
			</div>
		</div>
	</div>
</div>


<div id="location_direction_modal_box" class="popup">
	<div class="popup-title">Page Ratings</div>
	<div class="innerbox">
		<iframe src="" width="100%" height="450" frameborder="0" style="border:0"></iframe>
	</div>
</div>


<div id="quickview" class="popup">
	<div class="innerbox">
		<iframe src="" width="100%" height="450" frameborder="0" style="border:0"></iframe>
	</div>
</div>


<div id="aside_social">
	<a href="<?=get_option('social_yt')?>" class="social_yt" target="_blank">
		<img src="<?=base_url('images/social-icons/yt.png')?>">
	</a>
	<a href="<?=get_option('social_fb')?>" class="social_fb" target="_blank">
		<img src="<?=base_url('images/social-icons/fb.png')?>">
	</a>
	<a class="social_gp" target="_blank">
		<img src="<?=base_url('images/social-icons/gp.png')?>">
	</a>
	<a class="social_tw" target="_blank">
		<img src="<?=base_url('images/social-icons/tw.png')?>">
	</a>
	<a class="social_pn" target="_blank">
		<img src="<?=base_url('images/social-icons/ins.gif')?>">
	</a>
</div>


<?php
$cart_items=$cart_total=0;
/*echo '<pre>'; print_r($this->cart->contents()); echo '</pre>';*/

foreach($this->cart->contents() as $key=>$val)
{
	if(!is_array($val) OR !isset($val['price']) OR ! isset($val['qty'])){ continue; }

	$cart_items += $val['qty'];
	$cart_total += $val['subtotal'];
}
?>

<aside id="minicart">
	<div class="closeCartBox cart-close">
		<i class="fa fa-chevron-right"></i>
	</div>
	<div class="innerbox">
		<table class="table table-striped table-bordered">
			<tr>
				<td colspan="3" class="cart-heading">
					<span class="itemno"><?=$cart_items?></span> ITEMS
				</td>
			</tr>
			<?php
			foreach($this->cart->contents() as $items)
			{
			//	$featured_image=get_post_meta($items['id'], 'featured_image');
			//	$featured_image=get_media_path($featured_image);
				$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $items['id']));
			$featured_image=get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list');
							
				
				?><tr>
					<td class="total text-center">
						<a class="remove_from_cart" data-rowid="<?=$items['rowid']?>"><i class="tooltip-test font24 fa fa-remove"></i></a>
					</td>
					<td class="product-item text-center">
						<a>
							<img src="<?=$featured_image?>" height="30" width="30"/>
						</a>
						<div class="item-name-and-price">
							<div class="item-name"><?=get_product_title($items['id'])?></div>
							<div class="item-price">
								৳ <?=$this->cart->format_number($items['price'])?> x <?=$items['qty']?>
								<div class="quantity-action" data-rowid="<?=$items['rowid']?>">
									<div class="qtyplus" data-action_type="plus">+</div>
									<div class="qtyminus" data-action_type="minus">-</div>
								</div>
							</div>
						</div>
					</td>
					<td>৳ <?=$this->cart->format_number($items['subtotal'])?></td>
				</tr><?php
			}
			
			if($cart_items!=0)
			{
				?><tr>
					<td colspan="3" class="cart-action">
						<a href="<?=base_url()?>">Continue Shopping</a>
						<a href="<?=base_url('checkout')?>">Place Order</a>
						<div class="cart-total text-right">৳ <?=$this->cart->format_number($this->cart->total())?></div>
					</td>
				</tr><?php
			}
			else
			{
				?><tr>
					<td colspan="3" class="cart-action">
						<a href="<?=base_url()?>" style="width:100%">Shop Now</a>
					</td>
				</tr><?php
			}
			?>
		</table>
	</div>
</aside>

<div id="feedback_modal_box" class="popup">
	<div class="popup-title">Page Ratings</div>
	<div class="innerbox">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						Content
					</div>
					<div class="col-sm-9">
						<div class="form-group form-radiobox-group field field-content-rating" isrequried="True">
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-1" name="content_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-2" name="content_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-2</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="Neutral" name="content_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">Neutral</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+1" name="content_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+2" name="content_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+2</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						Design
					</div>
					<div class="col-sm-9">
						<div class="form-group form-radiobox-group field field-design-rating" isrequried="True">
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-1" name="design_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-2" name="design_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-2</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="Neutral" name="design_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">Neutral</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+1" name="design_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+2" name="design_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+2</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						Easy Use
					</div>
					<div class="col-sm-9">
						<div class="form-group form-radiobox-group field field-easy-rating" isrequried="True">
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-1" name="easy_use_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-2" name="easy_use_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-2</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="Neutral" name="easy_use_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">Neutral</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+1" name="easy_use_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+2" name="easy_use_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+2</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						Overall
					</div>
					<div class="col-sm-9">
						<div class="form-group form-radiobox-group field field-overall-rating" isrequried="True">
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-1" name="overall_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="-2" name="overall_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">-2</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="Neutral" name="overall_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">Neutral</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+1" name="overall_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+1</span>
							</label>
							<label class="form-radiobox is-vertical text-center" style="width:18%">
								<input type="radio" value="+2" name="overall_rating" isrequried="True"><br/>
								<span class="form-radiobox-title">+2</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<select class="form-control field field-page" name="page">
				<option value="">Please choose page</option>
				<option value="Home Page">Home Page</option>
				<option value="Category Page">Category Page</option>
				<option value="Product Detail Page">Product Detail Page</option>
			</select>
		</div>
		<div class="form-group">
			<textarea class="form-control field field-review" name="review" placeholder="Write your comments hre..."></textarea>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					Provide your phone or email
				</div>
				<div class="col-sm-6">
					<input type="text" class="form-control field field-email" name="email_or_phone"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					Purpose of visit?
				</div>
				<div class="col-sm-6">
					<select class="form-control field field-purpose" name="purpose_of_visit">
						<option value="Purchase">Purchase</option>
						<option value="Compare">Compare</option>
						<option value="Looking for update news">Looking for update news</option>
						<option value="Just browsing">Just browsing</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					When do you able to complete the purpose of your visit?
				</div>
				<div class="col-sm-6">
					<select class="form-control field field-where" name="where_of_visit">
						<option value="After 5 minutes">After 5 minutes</option>
						<option value="After 10 minutes">After 10 minutes</option>
						<option value="After 30 minutes">After 30 minutes</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					How often do you visit
				</div>
				<div class="col-sm-6">
					<select class="form-control field field-how" name="how_of_visit">
						<option value="Once week">Once week</option>
						<option value="Twice week">Twice week</option>
						<option value="Once a month">Once a month</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-default form-control">Submit</button>
		</div>
	</div>
</div>


<div id="become_a_dealer" class="popup">
	<div class="popup-title">Apply as Dealer</div>
	<div class="innerbox">
		<form method="post" class="form-horizontal">
			<div class="form-group">
				<label for="dealer_name" class="col-sm-3 control-label">Name</label>
				<div class="col-sm-9">
					<input type="text" name="dealer_name" id="dealer_name" placeholder="Name" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="dealer_email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-9">
					<input type="text" name="dealer_email" id="dealer_email" placeholder="Email" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="dealer_phone" class="col-sm-3 control-label">Phone</label>
				<div class="col-sm-9">
					<input type="text" name="dealer_phone" id="dealer_phone" placeholder="Phone" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="dealer_address" class="col-sm-3 control-label">Address</label>
				<div class="col-sm-9">
					<input type="text" name="dealer_address" id="dealer_address" placeholder="Address" class="form-control">
				</div>
			</div>
			<div class="form-group directpay">
				<label for="dealer_state" class="col-sm-3 control-label">Division</label>
				<div class="col-sm-9">
					<?php											
					echo form_dropdown('dealer_state', array(
						'Dhaka' => 'Dhaka',
						'Chittagong' => 'Chittagong',
						'Barisal' => 'Barisal',
						'Khulna' => 'Khulna',
						'Rajshahi' => 'Rajshahi',
						'Sylhet' => 'Sylhet',
						'Rangpur' => 'Rangpur',
					), set_value('dealer_state'), array('id'=>'dealer_state', 'class'=>'form-control'));
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="dealer_comment" class="col-sm-3 control-label">Comment</label>
				<div class="col-sm-9">
					<textarea name="dealer_comment" id="dealer_comment" placeholder="Comment" class="form-control" rows="2"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-9 col-sm-offset-3">
					<button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
				</div>
			</div>
		</form>
	</div>
</div>
<a id="gotop"><i class="fa fa-arrow-circle-up"></i></a>

<!--
<div class="fbchat" hidden>
	<div class="fbchat-title">Leave a Message</div>
	<div class="fbchat-body">
		<script>
		window.fbAsyncInit = function()
		{
			FB.init({
				//appId      : '00095100348886',
				appId      : '142080836422229',
				xfbml      : true,
				version    : 'v2.6'
			});
		};

		(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>

		<div class="fb-page" 
		data-href="https://www.facebook.com/computer.village.bd/" 
		data-tabs="messages" 
		data-width="300" 
		data-height="300" 
		data-small-header="true">
			<div class="fb-xfbml-parse-ignore">
				<blockquote></blockquote>
			</div>
		</div>
	</div>
</div>
<div class="fbchatbtn"></div>


<!--Start of Zopim Live Chat Script
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3ttrMTprPoxN9vFOEYVrwfNqQSFJBL5X";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->


<script type="text/javascript" src="<?=base_url('js/jquery-ui.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.plugin.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.flexslider-min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.easing.min.js'); ?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.touchSwipe.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/flipclock.js'); ?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.cookie.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/zoomsl-3.0.min.js')?>"></script> 
<script type="text/javascript" src="<?=base_url('js/owl.carousel.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.validate.js')?>"></script> 
<script type="text/javascript" src="<?=base_url('js/jquery.number.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/lightslider.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/jquery.countdown.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/custom.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/mycustom.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/elevatezoom.js')?>"></script>

<script type="text/javascript">
jQuery('.carousel').carousel({
	interval: 1000 * 3
});

$(document).ready(function()
{
	var window_width = $(window).width();

	var live_no_of_items = 4;

	if(window_width<=375)
	{
		live_no_of_items = 1;
	}
	else if(window_width<=767)
	{
		live_no_of_items = 2;
	}

	$("#liveShoppingLightSlider").lightSlider({
        item: live_no_of_items,
		auto: true,
		loop: true,
		keyPress: true,
        pager: false,
        pauseOnHover: true,
        slideMargin: 0,
        autoWidth: false,

	});
	
	/*### live shopping countdown ###*/
	//var newYear = new Date('December 30, 2017 04:00:00');
	var newYear = new Date('<?php echo date('F d, Y H:i:s', strtotime(get_option('live_shopping_end_time'))); ?>');
	jQuery('#countdown').countdown({until: newYear});
});
</script>
</body>
</html>