<?php
class Custom404 extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->model('CategoryModel', 'cat');
	}
 
	public function index()
	{
	    
	   
		$uri_string = explode("/", uri_string());
		$uri_string_end = end($uri_string);
		if(is_numeric($uri_string_end))
		{
			$page = $uri_string_end;
			$post_name = $uri_string[count($uri_string)-2];
			$post = get_uri_not_found_data($post_name);
			$data['post'] = $post;
		}
		else
		{
			$page = 1;
			$post = get_uri_not_found_data(end($uri_string));
			$data['post'] = $post;
		}

		if(sizeof($post)>0)
		{
			if(isset($post->product_id))
			{
				$data['prod_row'] = $post;
				
				$data['page_title']		=	$post->product_title;
				$data['page_name']		=	'single product';

				$data['seo_title']		=	$post->seo_title;
				$data['seo_keywords']	=	$post->seo_keywords;
				$data['seo_content']	=	$post->seo_content;

				$this->load->view('header', $data);
				$this->load->view('product/product_front_view', $data);
				$this->load->view('footer', $data);
			}
			elseif(isset($post->category_id))
			{
				$cat=$post->category_name;

				$sortby = 'price_asc';
				$price_from = '';
				$price_to = '';

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
				
				$category_id 				= 	$post->category_id;
				$category_title				=	get_category_title($category_id);
				$category_name				=	get_category_name($category_id);
				$catinfo					=	get_category_info($category_id);

				$data['products']			=	$this->cat->archive_product($category_id, 20, $page, $sortby, $price_from, $price_to);
				$data['total_rows']			=	$this->cat->total_rows($category_id);
				
				if(sizeof($data['products'])==0)
				{
					$sortby = 'default';
					$data['products']		=	$this->cat->archive_product($category_id, 20, $page, $sortby, $price_from, $price_to);
				}
				
				$data['page_title']			=	ucwords(str_replace("-", " ", $cat));
				$data['page_name'] 			= 	'archive';

				$data['seo_title']			=	$catinfo->seo_meta_title;
				$data['seo_keywords']		=	$catinfo->seo_keywords;
				$data['seo_content']		=	$catinfo->seo_meta_content;

				$data['category_title']		=	$category_title;
				$data['category_id']		=	$category_id;
				$data['category_name']		=	$category_name;
				$data['catinfo']			=	$catinfo;

				$data['sidebar']			=	$this->load->view('sidebar', $data, true);
				
			

				$this->load->view('header', $data);
				$this->load->view('category/archive_product', $data);
				$this->load->view('footer', $data);
			}
			else
			{
				$data['page_title']		=	$post->post_title;
				$data['page_name']		=	$post->post_title;
				$data['seo_title']		=	get_post_meta($post->post_id, 'seo_title');
				$data['seo_keywords']	=	get_post_meta($post->post_id, 'seo_keywords');
				$data['seo_content']	=	get_post_meta($post->post_id, 'seo_content');

				$template = get_post_meta($post->post_id, 'template');
				$template = $template == 'default' ? 'page' : $template;

				$this->load->view('header', $data);
				$this->load->view($template, $data);
				$this->load->view('footer', $data);
			}
		}
		else
		{
			$data['page_title']='Not Found';
			$data['page_name']='not-found';
			
			$this->load->view('header', $data);
			$this->load->view('custom404', $data);
			$this->load->view('footer', $data);
		}
	}
}