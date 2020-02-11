<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneratePdf extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('tcpdf');
	}
	
	public function index()
	{
		$columns = array(
			'Component',
			'Image',
			'Product Name',
			'Price'
		);

		$this->tcpdf->setcolumns($columns);
	}
}
