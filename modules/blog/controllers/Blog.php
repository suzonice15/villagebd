<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
	}

	public function index()
	{
		$data 				= array();
		$data['page_name']  = 'blog';
		$data['page_title'] = 'Blog';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		
		// blogs
		$data['blogs'] = $this->global_model->get('blog', array('status' => 1), '*', false, array('field' => 'blog_id', 'order' => 'DESC'));

		$this->load->view('header', $data);
		$this->load->view('archive', $data);
		$this->load->view('footer', $data);
	}

	public function front_view($blog_id)
	{
		// get blog info
		$data_row = $this->global_model->get_row('blog', array('blog_id' => $blog_id));

		$data 				= array();
		$data['page_name']	= 'single-blog';
		$data['page_title'] = $data_row->blog_title;
		$data['page_type']  = 'single_blog';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		$data['data_row'] 	= $data_row;
		
		$this->load->view('header', $data);
		$this->load->view('front_view', $data);
		$this->load->view('footer', $data);
	}
}