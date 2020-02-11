<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Compare extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('CompareModel', 'cpare');
	}

	public function index()
	{
		$data=array();
		$data['page_title']='Compare';
		$data['products']=array();
		
		if($this->session->userdata('compare'))
		{
			$compare=$this->session->userdata('compare');
			$data['products']=$this->cpare->get_products($compare);
		}

		$this->load->view('header', $data);
		$this->load->view('compare', $data);
		$this->load->view('footer', $data);
	}
}