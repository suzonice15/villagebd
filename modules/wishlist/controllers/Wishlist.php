<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Wishlist extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->model('WishlistModel', 'wlist');
	}

	public function index()
	{
		$data=array();
		$data['page_title']='Wishlist';
		$data['products']=array();

		if($this->session->userdata('wishlist'))
		{
			$wishlist=$this->session->userdata('wishlist');
			$data['products']=$this->wlist->get_products($wishlist);
		}

		$this->load->view('header', $data);
		$this->load->view('wishlist', $data);
		$this->load->view('footer', $data);
	}
}