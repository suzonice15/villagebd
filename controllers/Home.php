<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");
		
		$this->load->library('cart');
	}
	
	public function index()
	{
		$data = array();
		$data['page_name']      = $this->session->user_id ? 'home account logged' : 'home';
		$data['seo_title']		= get_option('home_seo_title');
		$data['seo_keywords']	= get_option('home_seo_keywords');
		$data['seo_content']	= get_option('home_seo_content');

		// sliders
		$data['homesliders'] = $this->global_model->get('homeslider', array('status' => 1,'slider_position'=>'main'), 'homeslider_banner,target_url,homeslider_title', array('limit'=>4), array('field' => 'homeslider_id', 'order' => 'DESC'));
		$data['leftsliders'] = $this->global_model->get('homeslider', array('status' => 1,'slider_position'=>'left'), 'homeslider_banner,target_url,homeslider_title', array('limit'=>1), array('field' => 'homeslider_id', 'order' => 'DESC'));
		$data['rightsliders'] = $this->global_model->get('homeslider', array('status' => 1,'slider_position'=>'right'),'homeslider_banner,target_url,homeslider_title', array('limit'=>1), array('field' => 'homeslider_id', 'order' => 'DESC'));
		$data['bottom_sliders'] = $this->global_model->get('adds', array('adds_type'=>'slider'),'adds_title,adds_link,media_id', array('limit'=>4), array('field' => 'adds_id', 'order' => 'DESC'));

$query="SELECT product_id,product_title,product_name,product_price,discount_price FROM `product` WHERE product_type='home' ORDER BY `product`.`modified_time` desc,`product`.`product_order`  asc limit 16
";
	$data['products'] =get_result($query);
	
$cat_query="SELECT category_price,category_icon,category_title,category_name FROM `category` where parent_id=0 order by category_id asc limit 12
";
	$data['categories'] =get_result($cat_query);
/*echo '<pre>';

print_r(		$data['products']);
exit();*/
		$this->load->view('header', $data);
		$this->load->view('home', $data);
		$this->load->view('footer', $data);
	}
}