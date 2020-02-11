<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
	}

	public function index()
	{
		$data 				= array();
		$data['page_name']  = 'news';
		$data['page_title'] = 'News';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		
		// newses
		$data['newses'] = $this->global_model->get('news', array('status' => 1), '*', false, array('field' => 'news_id', 'order' => 'DESC'));

		$this->load->view('header', $data);
		$this->load->view('archive', $data);
		$this->load->view('footer', $data);
	}

	public function front_view($news_id)
	{
		// get news info
		$data_row = $this->global_model->get_row('news', array('news_id' => $news_id));

		$data 				= array();
		$data['page_name']  = 'single-news';
		$data['page_title'] = $data_row->news_title;
		$data['page_type']	= 'single_news';
		$data['sidebar']	= $this->load->view('sidebar', $data, true);
		$data['data_row']   = $data_row;

		
		$this->load->view('header', $data);
		$this->load->view('front_view', $data);
		$this->load->view('footer', $data);
	}
}