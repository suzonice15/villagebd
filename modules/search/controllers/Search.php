<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
        date_default_timezone_set("Asia/Dhaka");

		$this->load->library('cart');
        $this->load->library('pagination');
        $this->load->model('SearchModel', 'pagi');
	}
	
	/*### search ###*/
	public function index($page=1)
    {
    	$cat 	= isset($_GET['cat']) ? $_GET['cat'] : null;
    	$search = isset($_GET['q']) ? $_GET['q'] : null;

        $config['base_url']			= site_url('search/index');
        $config['total_rows'] 		= $this->pagi->get_products_count($search, $cat);
        $config['per_page']			= 48;
        //$config["uri_segment"]	= 3;
        $choice						= $config["total_rows"]/$config["per_page"];
        $config["num_links"]		= floor($choice);
		$config['use_page_numbers'] = true;

        $config['full_tag_open']	= '<ul class="pagination">';
        $config['full_tag_close']	= '</ul>';
        $config['first_link']		= false;
        $config['last_link']		= false;
        $config['first_tag_open']	= '<li>';
        $config['first_tag_close']	= '</li>';
        $config['prev_link']		= '«';
        $config['prev_tag_open']	= '<li class="prev">';
        $config['prev_tag_close']	= '</li>';
        $config['next_link']		= '»';
        $config['next_tag_open']	= '<li>';
        $config['next_tag_close']	= '</li>';
        $config['last_tag_open']	= '<li>';
        $config['last_tag_close']	= '</li>';
        $config['cur_tag_open']		= '<li class="active"><a href="#">';
        $config['cur_tag_close']	= '</a></li>';
        $config['num_tag_open']		= '<li>';
        $config['num_tag_close']	= '</li>';
        $config['suffix']			= '/?'.http_build_query($_GET, '', "&");
        $this->pagination->initialize($config);

		$data 						= array();
		$data['page_title'] 		= 'Search: '.$search;
		$data['sidebar'] 			= $this->load->view('sidebar', $data, true);

        $data['page']       = $page;
        $data['products']   = $this->pagi->get_products($config["per_page"], $data['page'], $search, $cat);
        $data['pagination'] = $this->pagination->create_links();
		$data['sidebar']	= $this->load->view('sidebar', $data, true);

		$this->load->view('header', $data);
		$this->load->view('search', $data);
		$this->load->view('footer', $data);
    }
}