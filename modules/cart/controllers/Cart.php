<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('cart');
	}
	
	
	public function index()
	{
		$data = array();
		$this->load->view('header', $data);
		$this->load->view('cart', $data);
		$this->load->view('footer', $data);
	}
	
	public function update_cart()
	{
		if($this->input->post())
		{
			$data = $this->input->post();
			/*echo '<pre>'; print_r($data); echo '</pre>';*/
			
			if($this->cart->update($data))
			{
				redirect('cart');
			}
			else
			{
				redirect('cart');
			}
		}
		else
		{
			$data = array();
			$this->load->view('header', $data);
			$this->load->view('cart', $data);
			$this->load->view('footer', $data);
		}
	}
}