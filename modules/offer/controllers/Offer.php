<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('Offer_model','offer');
	}

	public function index()
	{
		$data 				= array();
		$data['page_name']  = 'offer';
		$data['page_title'] = 'Offer';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		
		// offers
		$data['offers'] = $this->global_model->get('offer', array('status' => 1), '*', false, array('field' => 'offer_id', 'order' => 'DESC'));

		$this->load->view('header', $data);
		$this->load->view('archive', $data);
		$this->load->view('footer', $data);
	}

	public function front_view($offer_id)
	{
		// get offer info
		$data_row = $this->global_model->get_row('offer', array('offer_id' => $offer_id));

		$data 				= array();
		$data['page_name']	= 'single-offer';
		$data['page_title'] = $data_row->offer_title;
		$data['page_type']  = 'single_offer';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		$data['data_row'] 	= $data_row;
		
		$this->load->view('header', $data);
		$this->load->view('front_view', $data);
		$this->load->view('footer', $data);
	}
	
	public function coupon_offer(){
	    
	 
		$data 				= array();
		$data['page_name']	= 'single-offer';
		$data['page_title'] = $data_row->offer_title;
		$data['page_type']  = 'single_offer';
	//	$data['sidebar']    = $this->load->view('sidebar', $data, true);
	
//	 $today = date("Y-m-d");
	// $query="SELECT * FROM `product` join coupon on coupon.coupon_id=product.coupon_code WHERE coupon_start >='$today' and coupon_end <='$today'";
//	$result= $this->db->query($query)->result();
	$result=$this->offer->offer_data();
       
		$data['data_row'] 	= $data_row;
		$data['products'] 	= $result;
		
		
		$this->load->view('header', $data);
		$this->load->view('coupon_offer', $data);
		$this->load->view('footer', $data);
	}
	
		public function crazy(){
	    
	 
		$data 				= array();
		$data['page_name']	= 'single-offer';
		$data['page_title'] = $data_row->offer_title;
		$data['page_type']  = 'single_offer';
	//	$data['sidebar']    = $this->load->view('sidebar', $data, true);
	
//	 $today = date("Y-m-d");
	// $query="SELECT * FROM `product` join coupon on coupon.coupon_id=product.coupon_code WHERE coupon_start >='$today' and coupon_end <='$today'";
//	$result= $this->db->query($query)->result();
	$result=$this->offer->crazy();
       
		$data['data_row'] 	= $data_row;
		$data['products'] 	= $result;
		
		
		$this->load->view('header', $data);
		$this->load->view('coupon_offer', $data);
		$this->load->view('footer', $data);
	}
	
		public function twenty(){
	    
	 
		$data 				= array();
		$data['page_name']	= 'single-offer';
		$data['page_title'] = $data_row->offer_title;
		$data['page_type']  = 'single_offer';
	//	$data['sidebar']    = $this->load->view('sidebar', $data, true);
	
//	 $today = date("Y-m-d");
	// $query="SELECT * FROM `product` join coupon on coupon.coupon_id=product.coupon_code WHERE coupon_start >='$today' and coupon_end <='$today'";
//	$result= $this->db->query($query)->result();
	$result=$this->offer->twenty();
       
		$data['data_row'] 	= $data_row;
		$data['products'] 	= $result;
		
		
		$this->load->view('header', $data);
		$this->load->view('coupon_offer', $data);
		$this->load->view('footer', $data);
	}
}