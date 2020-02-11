<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
	}

	public function index()
	{
		$data 				= array();
		$data['page_name']  = 'service';
		$data['page_title'] = 'Services';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		
		// services
		$data['services'] = $this->global_model->get('service', array('status' => 1), '*', false, array('field' => 'service_id', 'order' => 'DESC'));

		$this->load->view('header', $data);
		$this->load->view('archive', $data);
		$this->load->view('footer', $data);
	}

	public function front_view($service_id)
	{
		// get service info
		$data_row = $this->global_model->get_row('service', array('service_id' => $service_id));

		$data 				= array();
		$data['page_name']	= 'single-service';
		$data['page_title'] = $data_row->service_title;
		$data['page_type']  = 'single_service';
		$data['sidebar']    = $this->load->view('sidebar', $data, true);
		$data['data_row'] 	= $data_row;
		
		$this->load->view('header', $data);
		$this->load->view('front_view', $data);
		$this->load->view('footer', $data);
	}
}