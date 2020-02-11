<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
        
		$this->load->library('cart');
	}
	
	public function authentication_failure()
	{
		$data['page_title']		=	'Authentication Failure';
		$data['page_name']		=	'authentication-failure';
		
		$this->load->view('header', $data);
		$this->load->view('authentication_failure', $data);
		$this->load->view('footer', $data);
	}
}
