<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('ProductModel', 'prod');
	}

	public function front_view($product_name)
	{
		$data = array();
		$data['prod_row']		= $this->prod->front_view($product_name);
		$data['page_title']		= $data['prod_row']->product_title;
		$data['page_name'] 		= 'single product';

		$data['seo_title']		= $data['prod_row']->seo_title;
		$data['seo_keywords']	= $data['prod_row']->seo_keywords;
		$data['seo_content']	= $data['prod_row']->seo_content;

		$data['sidebar']		= $this->load->view('sidebar', $data, true);

		$this->load->view('header', $data);
		$this->load->view('product_front_view', $data);
		$this->load->view('footer', $data);
	}


	public function quick_view($product_id)
	{
		$data = array();
		$data['prod_row']		= $this->prod->quick_view($product_id);
		$data['page_title']		= $data['prod_row']->product_title;
		$data['sidebar']		= $this->load->view('sidebar', $data, true);
		
	
	
		
		$this->load->view('header', $data);
		$this->load->view('product_quick_view', $data);
		$this->load->view('footer', $data);
	}
	
}