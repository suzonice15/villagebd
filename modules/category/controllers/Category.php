<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('CategoryModel', 'cat');
	}

	public function archive($cat,$page=1)
	{
		$data = array();
		
		$sortby 		= 'price_asc';
		$price_from 	= '';
		$price_to 		= '';

		if(isset($_COOKIE['sortby']))
		{
			$sortby = $_COOKIE['sortby'];
		}
		
		if(isset($_GET['price_from']) && isset($_GET['price_to']))
		{
			$sortby = 'price_range';
			$price_from = $_GET['price_from'];
			$price_to = $_GET['price_to'];
		}
		
		$category_id 				= get_category_id($cat);
		$category_title				= get_category_title($category_id);
		$category_name				= get_category_name($category_id);
		$catinfo					= get_category_info($category_id);
		
		$data['products']			= $this->cat->archive_product($category_id,20,$page,$sortby,$price_from,$price_to);
		$data['total_rows']			= $this->cat->total_rows($category_id);
		
		if(sizeof($data['products'])==0)
		{
			$sortby = 'default';
			$data['products']		= $this->cat->archive_product($category_id,20,$page,$sortby,$price_from,$price_to);
		}
		
		$data['page_title']			= ucwords(str_replace("-", " ", $cat));

		$data['category_title']		= $category_title;
		$data['category_id']		= $category_id;
		$data['category_name']		= $category_name;
		$data['catinfo']			= $catinfo;

		$data['sidebar']			= $this->load->view('sidebar', $data, true);
		
		$this->load->view('header', $data);
		$this->load->view('archive_product', $data);
		$this->load->view('footer', $data);
	}
}