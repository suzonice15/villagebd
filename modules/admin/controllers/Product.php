<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller
{
    public $_file_dir	= 'uploads/product';
    public $_file_path	= './uploads/product/';

    private $_image_size       = array(
        'width'   => 480,
        'height'  => 480,
        'quality' => 60,
        'crop'    => FALSE,
        'rgb'     => '0xFFFFFF'
    );

    private $_list_image_size  = array(
    	'width'   => 181,
        'height'  => 181,
        'quality' => 60,
        'crop'    => FALSE,
        'rgb'     => '0xFFFFFF'
    );
    
    private $_mini_list_image_size  = array(
    	'width'   => 157,
        'height'  => 157,
        'quality' => 60,
        'crop'    => FALSE,
        'rgb'     => '0xFFFFFF'
    );

    private $_thumb_image_size = array(
    	'width'   => 100,
        'height'  => 100,
        'quality' => 80,
        'crop'    => FALSE,
        'rgb'     => '0xFFFFFF'
    );

    private $_mini_thumb_image_size = array(
    	'width'   => 50,
        'height'  => 50,
        'quality' => 80,
        'crop'    => FALSE,
        'rgb'     => '0xFFFFFF'
    );

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");
		
        if (ENVIRONMENT == 'development' || $this->input->get('profiler')) {
            $this->output->enable_profiler(TRUE);
        }
        
        if(!check_admin_login()) {
            $this->session->set_userdata('return_url', current_url());
            $this->session->set_flashdata('error_msg', 'Please login first !!');
            redirect('admin/login');
        }

        if(!file_exists($this->_file_dir)) {
            mkdir($this->_file_dir, 0777, TRUE);
        }
	}

	public function index()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'product';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Products';

        $data['action_button'] = array('url'   => site_url('admin/product/add_new'),
            'title' => 'Add New Product'
        );

        // where clause params
		$join_term = false;
        $params = array('status' => 1);
        if($this->input->get('sortbycat')) {
            $params['term_relation.term_id'] = $this->input->get('sortbycat');
            $join_term = TRUE;
        }

        if($this->session->user_type == 'product-manager')
        {
            $join_term = TRUE;
        }

        if($this->input->get('query')) {
            $params['product_title like'] = '%' . $this->input->get('query') . '%';
        }

        // where_in_parmas
        $where_in_parmas = array();
        if($this->session->user_type == 'product-manager')
        {
	        $where_in_parmas[] = array(
	        	'key' => 'term_relation.term_id',
	        	'values' => get_assign_terms($this->session->user_id)
	        );
	    }

        // join_parmas
        $join_parmas[] = array(
        	'table' => 'term_relation',
        	'relation' => 'product.product_id = term_relation.product_id',
        	'type' => 'left'
        );

        // order by
        $order_by = array('field' => 'product.product_id',
            'order' => 'DESC'
        );

        if($this->input->get('orderby')) {
            $order_by = array('field' => 'product.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination args
        $per_page      = 20;
        $offset        =($this->input->get('page')) ?($per_page *($this->input->get('page') - 1)) : 0;

        // count total rows
        $product_count = $this->global_model->get_join('product', $params, 'product.*', false, false, $where_in_parmas, $join_parmas, 'product.product_id');
        $data['total'] = $total_rows = !empty($product_count) ? count($product_count) : 0;

		// limit params
        $limit_params = array('limit' => $per_page, 'start' => $offset);

		// generate pagination
        createPagging('admin/product', $total_rows, $per_page);

        // get the results
        $data['products'] = $this->global_model->get_join('product', $params, 'product.*', $limit_params, $order_by, $where_in_parmas, $join_parmas, 'product.product_id');
			
        // load the views
        $data['layout'] = $this->load->view('product/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
       //check the permission
      if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
           redirect('admin/permission_denied');
        }
		
		$data 					= array();
        $data['menu_group']  	= 'product';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New';
		$data['coupons'] = $this->global_model->get('coupon');
        $data['action_button'] = array('url' => site_url('admin/product'), 'title' => 'Manage Products');

        // category
		if($this->session->user_type == 'product-manager')
		{
        	$data['category_list_products'] = $this->global_model->get('category', false, '*', false, false, array('key' => 'category_id', 'values' => get_assign_terms($this->session->user_id)));
		}
		else
		{
        	$data['category_list'] = $this->global_model->get('category');
        
		}

		if($this->input->post())
		{			
			$this->form_validation->set_rules('product_title', 'product title', 'trim|required');
			$this->form_validation->set_rules('product_name', 'product name', 'trim|required|is_unique[product.product_name]');
			$this->form_validation->set_rules('product_summary', 'product summary', 'trim|required');
			$this->form_validation->set_rules('featured_image', 'featured image', 'callback_file_validate[yes.featured_image.jpg,gif,png,jpeg]');
			
			if($this->form_validation->run())
			{
				$row_data						  = array();
				$row_data['product_title']		  = $this->input->post('product_title');
				$row_data['product_name']		  = $this->input->post('product_name');

				if($this->input->post('product_price'))
				{
					$row_data['product_price'] = $this->input->post('product_price');					
				}
				if($this->input->post('discount_price'))
				{
					$row_data['discount_price'] = $this->input->post('discount_price');					
				}
				if($this->input->post('discount_date_from'))
				{
					$row_data['discount_date_from'] = date("Y-m-d H:i:s", strtotime($this->input->post('discount_date_from')));
				}
				if($this->input->post('discount_date_to'))
				{
					$row_data['discount_date_to'] = date("Y-m-d H:i:s", strtotime($this->input->post('discount_date_to')));
				}
						if($this->session->user_type == 'product-manager'){
						    	$row_data['status']	  = 1;
						}
						  $row_data['coupon_code']		  = $this->input->post('coupon_code');
				$row_data['coupon_price']		  = $this->input->post('coupon_price');
				$row_data['coupon_status']		  = $this->input->post('coupon_status');
				
					$total_product_price_=0;
				
					$product_price = $this->input->post('product_price');
				$discount_price = $this->input->post('discount_price');
					$coupon_price = $this->input->post('coupon_price');
						$total_product_price_=$product_price;
				
				if($discount_price){
				    	$total_product_price_=$discount_price;
				}
				
				
					$discount=0;
						if($coupon_price >0){ 
							  	//  $discount_product_price_minus= $total_product_price_-$coupon_price;
							  $discount= round(($coupon_price*100)/$total_product_price_);
						}		   
						
						
							
				$row_data['coupon_percentage']		  = $discount;




				$row_data['product_summary']	  = $this->input->post('product_summary');
					$row_data['product_order']	  = $this->input->post('product_order');
				
				$row_data['product_description']  = $this->input->post('product_description');
				$row_data['product_type']		  = $this->input->post('product_type');
				$row_data['product_video']		  = $this->input->post('product_video');
				$row_data['is_live_promo'] 		  = $this->input->post('is_live_promo');
				$row_data['product_availability'] = $this->input->post('product_availability');
				$row_data['seo_title']			  = $this->input->post('seo_title');
				$row_data['seo_keywords']		  = $this->input->post('seo_keywords');
				$row_data['seo_content']		  = $this->input->post('seo_content');
				$row_data['created_time']		  = date("Y-m-d H:i:s");
				$row_data['modified_time']		  = date("Y-m-d H:i:s");
				
			  
				$product_specification 	= array();
				$specification_key 		= $this->input->post('specification_key');
				$specification_value 	= $this->input->post('specification_value');
				$specification_value 	= array_filter(array_values($specification_value));
				$spval 					= $this->input->post('specification_value');
				
				if(count($specification_value)>0)
				{
					$ki=0; foreach($specification_key as $spkey)
					{
						if(!empty($spkey) && !empty($spval[$ki]))
						{
							$product_specification[$spkey]=$spval[$ki];
						}
						
						$ki++;
					}
				}
				
				$row_data['product_specification'] = json_encode($product_specification);
				
			
			
				
				if($product_id = $this->global_model->insert('product', $row_data))
				{
	                // product main image
	                $this->upload_featured_image($product_id, $this->input->post('product_title'), 'featured_image');

	                // product gallery image
	                $this->upload_product_gallery_image($product_id, $this->input->post('product_title'), 'product_image');

					/*# term relation #*/
					$categories = $this->input->post('categories');
					
					if($categories && is_array($categories))
					{
						$term_data['product_id'] = $product_id;
						
						foreach($categories as $cat)
						{
							$term_data['term_id'] = $cat;
							
							$this->global_model->insert('term_relation', $term_data);
						}
					}
					
					$this->session->set_flashdata('success_msg', 'Successfully created');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to create');
				}

				redirect('admin/product');
			}
		}

        // load the views
        $data['layout'] = $this->load->view('product/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($product_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
		
		$data 					= array();
        $data['menu_group']  	= 'product';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update';
		$data['coupons'] = $this->global_model->get('coupon');

        $data['action_button'] = array('url'   => site_url('admin/product'),
            'title' => 'Manage Products'
        );

        // get the result
		$data['prod_row']		= $this->global_model->get_row('product', array('product_id' => $product_id));
		$data['product_terms']	= $this->global_model->get('term_relation', array('product_id' => $product_id));
		
        // category
		if($this->session->user_type == 'product-manager')
		{
        	$data['category_list'] = $this->global_model->get('category', false, '*', false, false, array('key' => 'category_id', 'values' => get_assign_terms($this->session->user_id)));
		}
		else
		{
        	$data['category_list'] = $this->global_model->get('category');
		}

		if($this->input->post())
		{
			$this->form_validation->set_rules('product_title', 'product title', 'trim|required');
			$this->form_validation->set_rules('product_name', 'product name', 'trim|required');
			$this->form_validation->set_rules('product_summary', 'product summary', 'trim|required');
			
			if($this->form_validation->run())
			{
			    
			    						update_to_recycle_bin('product', $product_id);

				$data['cat_url'] = $this->input->post('cat_url');
				
				$row_data						  = array();
				$row_data['product_title']		  = $this->input->post('product_title');
				$row_data['product_name']		  = $this->input->post('product_name');
				$row_data['product_price']		  = $this->input->post('product_price');
				$row_data['discount_price']		  = $this->input->post('discount_price');
				$row_data['discount_date_from']	  = date("Y-m-d H:i:s", strtotime($this->input->post('discount_date_from')));
				$row_data['discount_date_to']	  = date("Y-m-d H:i:s", strtotime($this->input->post('discount_date_to')));
				$row_data['product_summary']	  = $this->input->post('product_summary');
				$row_data['product_description']  = $this->input->post('product_description');
				$row_data['product_type']		  = $this->input->post('product_type');
				$row_data['product_video']		  = $this->input->post('product_video');
				$row_data['is_live_promo'] 		  = $this->input->post('is_live_promo');
				$row_data['product_availability'] = $this->input->post('product_availability');
				$row_data['seo_title']			  = $this->input->post('seo_title');
				$row_data['seo_keywords']		  = $this->input->post('seo_keywords');
				$row_data['seo_content']		  = $this->input->post('seo_content');
				$row_data['modified_time']		  = date("Y-m-d H:i:s");
									$row_data['product_order']	  = $this->input->post('product_order');

				 $row_data['coupon_code']		  = $this->input->post('coupon_code');
				$row_data['coupon_price']		  = $this->input->post('coupon_price');
				$row_data['coupon_status']		  = $this->input->post('coupon_status');
				$total_product_price_=0;
				
					$product_price = $this->input->post('product_price');
				$discount_price = $this->input->post('discount_price');
					$coupon_price = $this->input->post('coupon_price');
						$total_product_price_=$product_price;
				
				if($discount_price){
				    	$total_product_price_=$discount_price;
				}
				
				
					$discount=0;
						if($coupon_price >0){ 
							  	//  $discount_product_price_minus= $total_product_price_-$coupon_price;
							  $discount= round(($coupon_price*100)/$total_product_price_);
						}
							 
						
						
							
				$row_data['coupon_percentage']		  = $discount;

				
				$product_specification 	= array();
				$specification_key 		= $this->input->post('specification_key');
				$specification_value 	= $this->input->post('specification_value');
				$specification_value 	= array_filter(array_values($specification_value));
				$spval 					= $this->input->post('specification_value');
				
				if(count($specification_value)>0)
				{
					$ki=0; foreach($specification_key as $spkey)
					{
						if(!empty($spkey) && !empty($spval[$ki]))
						{
							$product_specification[$spkey]=$spval[$ki];
						}
						
						$ki++;
					}
				}
				
				$row_data['product_specification'] = json_encode($product_specification);
					
				if($this->global_model->update('product', $row_data, array('product_id' => $product_id)))
				{
	                // product main image
	                $this->upload_featured_image($product_id, $this->input->post('product_title'), 'featured_image');

	                // product gallery image
	                $this->upload_product_gallery_image($product_id, $this->input->post('product_title'), 'product_image');

					/*# term relation #*/
					$this->global_model->delete('term_relation', array('term_relation.product_id' => $product_id));

					$categories = $this->input->post('categories');
					
					$term_data['product_id'] = $product_id;
					
					foreach($categories as $cat)
					{
						$term_data['term_id'] = $cat;
						
						$this->global_model->insert('term_relation', $term_data);
					}

					$this->session->set_flashdata('success_msg', 'Product successfully updated');
					
					if($this->input->post('cat_url'))
					{
						redirect($this->input->post('cat_url'));
					}
					else
					{
						redirect('admin/product/update/'.$product_id);
					}
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Product failed to update');
					redirect('admin/product/update/'.$product_id);
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('product/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($product_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('product', array('status' => '0'), array('product_id' => $product_id));

        $this->db->trans_complete();

        if($this->db->trans_status() == FALSE)
        {
            $this->db->trans_rollback();

            $this->session->set_flashdata('error_msg', 'Failed to delete!');
        	redirect('admin/product');
        }
        else
        {
            $this->db->trans_commit();

			add_to_recycle_bin('product', $product_id);

			

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
        	redirect('admin/product');
        }
    }

    public function bulk_action()
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method()))
        {
            redirect('admin/permission_denied');
        }

        if($this->input->post('action'))
        {
            if($this->input->post('ids'))
            {
            	$items = 0;

                foreach($this->input->post('ids') as $product_id)
                {
                    if($this->global_model->update('product', array('status' => '0'), array('post_id' => $product_id)))
                    {
                    	add_to_recycle_bin('product', $product_id);

                    	$items++;
                    }
                }

                if(!empty($items))
                {
                	$this->session->set_flashdata('success_msg', $items . ' item(s) deleted successfully');
                }
                else
                {
                	$this->session->set_flashdata('error_msg', 'Failed to delete');
                }
            }
        }

        redirect('admin/product');
    }

    public function remove_gallery_img($product_id, $media_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method()))
        {
            //redirect('admin/permission_denied');
        }

        if($this->global_model->update('media', array('status' => '0'), array('media_id' => $media_id)))
        {
        	add_to_recycle_bin('media', $media_id);
			$this->session->set_flashdata('success_msg', 'Successfully deleted');
        }
        else
        {
			$this->session->set_flashdata('error_msg', 'Failed to delete');
        }

        redirect('admin/product/update/'.$product_id);
    }

	public function top_view_product()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'product';
        $data['page_active'] 	= 'top_view_product';
		$data['page_title']		= 'Top View Products';

        // params
        $params = array();
        if($this->input->get('query')) {
            $params['product.product_title like'] = '%' . $this->input->get('query') . '%';
        }

        // join parmas
        $join_parmas[] = array(
        	'table' => 'product',
        	'relation' => 'top_view_product.product_id=product.product_id',
        	'type' => 'left'
        );

        // order by
        $order_by = array('field' => 'top_view_product.view_id','order' => 'DESC');

        // pagination
        $per_page      = 2;
        $offset        =($this->input->get('page')) ?($per_page *($this->input->get('page') - 1)) : 0;

        // count total rows
        $data['total'] = $total_rows = $this->global_model->get_count('top_view_product', $params, 'top_view_product.view_id', false, $join_parmas, 'product.product_id');

		// limit params
        $limit_params = array('limit' => $per_page, 'start' => $offset);

        // generate pagination
        createPagging('product/top_view_product', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get_join('top_view_product', $params, 'product.*, COUNT(top_view_product.view_id) as top_view', $limit_params, $order_by, false, $join_parmas, 'product.product_id');
			
        // load the views
        $data['layout'] = $this->load->view('product/top_view_product', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function review()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'product';
        $data['page_active'] 	= 'review';
		$data['page_title']		= 'Product Reviews';
		
        // load the views
        $data['layout'] = $this->load->view('product/review', $data, TRUE);
        $this->load->view('template', $data);
	}

    // file validation
    public function file_validate($fieldValue, $params) {
        // get the parameter as variable
        list($require, $field_name, $type) = explode('.', $params);

        // get the file field name
        $file_name = isset($_FILES[$field_name]['name']) ? $_FILES[$field_name]['name'] : NULL;

        if($file_name == '' && $require == 'yes') {
            $this->form_validation->set_message('file_validate', 'The %s field is required');

            return FALSE;
        } elseif($type != '' && $file_name != '') {
            // get the extention
            $ext = strtolower(substr(strrchr($file_name, '.'), 1));

            // get the type as array
            $types = explode(',', $type);

            if(!in_array($ext, $types)) {
                $this->form_validation->set_message('file_validate', 'The %s field must be ' . implode(' OR ', $types) . ' !!');

                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    // upload product image
    private function upload_featured_image($product_id, $product_title, $field_name, $old_file = '')
    {
        $photo = $old_file;

        if(isset($_FILES[$field_name]["name"]) && $_FILES[$field_name]["name"])
        {
            $this->load->library('file_processing');
            $featured_image_name = url_title($product_title, '-', TRUE) . '-' . time();
            $photo = $this->file_processing->image_upload($field_name, $this->_file_path . 'orginal/', 'size[2000,2000]', 'jpg|jpeg|png|gif', $featured_image_name);

            if($photo != '')
            {
                $ini_path = $this->_file_path . 'orginal/' . $photo;
                img_resize($ini_path, $this->_file_path . $photo, $this->_image_size);
                img_resize($ini_path, $this->_file_path . 'thumbs/' . $photo, $this->_thumb_image_size);
                img_resize($ini_path, $this->_file_path . 'mini_thumbs/' . $photo, $this->_mini_thumb_image_size);
                img_resize($ini_path, $this->_file_path . 'list/' . $photo, $this->_list_image_size);
                img_resize($ini_path, $this->_file_path . 'mini_list/' . $photo, $this->_mini_list_image_size);

				$media_data 				= array();
				$media_data['relation_id'] 	= $product_id;
				$media_data['media_title'] 	= $product_title;
				$media_data['media_type'] 	= 'product_image';
				$media_data['media_path'] 	= $photo;

                $media_exists_params = array(
                	'media_type'  => 'product_image',
                    'relation_id' => $product_id
                );

                if($this->global_model->haveExists('media', $media_exists_params))
                {
					$media_data['modified_time']= date("Y-m-d H:i:s");

                    $this->global_model->update('media', $media_data, $media_exists_params);
                }
                else
                {
					$media_data['created_time']	= date("Y-m-d H:i:s");
					$media_data['modified_time']= date("Y-m-d H:i:s");

                    $this->global_model->insert('media', $media_data);
                }
            }

            // delele old if found
            if($photo != '' & $old_file != '')
            {
                $this->delete_photo($old_file);
            }
        }
    }

    // upload gallery image
    private function upload_product_gallery_image($product_id, $product_title, $field_name, $old_file = '')
    {
        $this->load->library('file_processing');
        $photo         = $old_file;

        // product gallery
        $gallery_items = isset($_FILES[$field_name]) ? count($_FILES[$field_name]['name']) : 0;

        $gallery_image = array();

        for($gi = 0; $gi < $gallery_items; $gi++)
        {
            if(!empty($_FILES[$field_name]['name'][$gi]))
            {
                $_FILES['pgallery']['name']     = $_FILES[$field_name]['name'][$gi];
                $_FILES['pgallery']['type']     = $_FILES[$field_name]['type'][$gi];
                $_FILES['pgallery']['tmp_name'] = $_FILES[$field_name]['tmp_name'][$gi];
                $_FILES['pgallery']['error']    = $_FILES[$field_name]['error'][$gi];
                $_FILES['pgallery']['size']     = $_FILES[$field_name]['size'][$gi];

                $gallery_image_name = url_title($product_title, '-', TRUE) . '-' . time();
                // upload file
                $photo              = $this->file_processing->image_upload('pgallery', $this->_file_path . 'orginal/', 'size[2000,2000]', 'jpg|jpeg|png|gif', $gallery_image_name);

                if($photo != '')
                {
                    $ini_path = $this->_file_path . 'orginal/' . $photo;
                    img_resize($ini_path, $this->_file_path . $photo, $this->_image_size);
                    img_resize($ini_path, $this->_file_path . 'thumbs/' . $photo, $this->_thumb_image_size);
                	img_resize($ini_path, $this->_file_path . 'mini_thumbs/' . $photo, $this->_mini_thumb_image_size);
                    img_resize($ini_path, $this->_file_path . 'list/' . $photo, $this->_list_image_size);
                	img_resize($ini_path, $this->_file_path . 'mini_list/' . $photo, $this->_mini_list_image_size);
					
					$media_data = array();
					$media_data['relation_id'] 	= $product_id;
					$media_data['media_title'] 	= $product_title;
					$media_data['media_path'] 	= $photo;
					$media_data['media_type'] 	= 'product_gallery';
					$media_data['created_time']	= date("Y-m-d H:i:s");
					$media_data['modified_time']= date("Y-m-d H:i:s");

					$this->global_model->insert('media', $media_data);
                }

                // delele old if found
                if($photo != '' & $old_file != '')
                {
                    $this->delete_photo($old_file);
                }
            }
        }
    }

    // delete product image
    private function delete_photo($file_name = '')
    {
        if($file_name != '')
        {
            $this->load->library('file_processing');
            $this->file_processing->delete_multiple($file_name, $this->_file_path);
            $this->file_processing->delete_file($file_name, $this->_file_path . 'orginal/');
            $this->file_processing->delete_file($file_name, $this->_file_path . 'list/');
        }
    }

    // regenerate thumbnails
    public function regeneratethumbs()
    {
        $this->load->library('file_processing');

        $total_process = 0;
        $total_success = 0;
        $per_page      = $this->input->get('limit') ? $this->input->get('limit') : 100;
        $offset   	   =($this->input->get('page')) ?($per_page *($this->input->get('page') - 1)) : 0;
        $limit_params  = array('limit' => $per_page, 'start' => $offset);
        $products      = $this->global_model->get('product', false, 'product_id, product_title', $limit_params);

		if(!empty($products))
		{
			foreach($products as $product)
			{
				$media_id   = get_product_meta($product->product_id, 'featured_image');
				$media_info = $this->global_model->get_row('media', array('media_id' => $media_id), 'media_path');

				if(!empty($media_info) && file_exists($media_info->media_path))
				{
                    $ini_path = './'.$media_info->media_path;
                    $photo = str_replace('uploads/', '', $media_info->media_path);
	                img_resize($ini_path, $this->_file_path . $photo, $this->_image_size);
	                img_resize($ini_path, $this->_file_path . 'thumbs/' . $photo, $this->_thumb_image_size);
	                img_resize($ini_path, $this->_file_path . 'mini_thumbs/' . $photo, $this->_mini_thumb_image_size);
	                img_resize($ini_path, $this->_file_path . 'list/' . $photo, $this->_list_image_size);
	                img_resize($ini_path, $this->_file_path . 'mini_list/' . $photo, $this->_mini_list_image_size);

					$media_data 				= array();
					$media_data['relation_id'] 	= $product->product_id;
					$media_data['media_title'] 	= $product->product_title;
					$media_data['media_type'] 	= 'product_image';
					$media_data['media_path'] 	= $photo;
					$media_data['created_time']	= date("Y-m-d H:i:s");
					$media_data['modified_time']= date("Y-m-d H:i:s");
					$this->global_model->insert('media', $media_data);

					$this->global_model->delete('media', array('media_id' => $media_id));

					unlink($ini_path);

            		$total_success++;
				}

				// gallery image
				$gallery_image = explode(",", get_product_meta($product->product_id, 'gallery_image'));
				if(count($gallery_image)>0)
				{
					foreach($gallery_image as $media_id)
					{
						$media_info = $this->global_model->get_row('media', array('media_id' => $media_id), 'media_path');

						if(!empty($media_info) && file_exists($media_info->media_path))
						{
		                    $ini_path = './'.$media_info->media_path;
		                    $photo = str_replace('uploads/', '', $media_info->media_path);
			                img_resize($ini_path, $this->_file_path . $photo, $this->_image_size);
			                img_resize($ini_path, $this->_file_path . 'thumbs/' . $photo, $this->_thumb_image_size);
			                img_resize($ini_path, $this->_file_path . 'mini_thumbs/' . $photo, $this->_mini_thumb_image_size);
			                img_resize($ini_path, $this->_file_path . 'list/' . $photo, $this->_list_image_size);
			                img_resize($ini_path, $this->_file_path . 'mini_list/' . $photo, $this->_mini_list_image_size);

							$media_data 				= array();
							$media_data['relation_id'] 	= $product->product_id;
							$media_data['media_title'] 	= $product->product_title;
							$media_data['media_type'] 	= 'product_gallery';
							$media_data['media_path'] 	= $photo;
							$media_data['created_time']	= date("Y-m-d H:i:s");
							$media_data['modified_time']= date("Y-m-d H:i:s");
							$this->global_model->insert('media', $media_data);

							$this->global_model->delete('media', array('media_id' => $media_id));

							unlink($ini_path);

	                		$total_success++;
						}
					}
				}

            	$total_process++;
			}
		}

        if ($total_process > 0) {
            echo '<META http-equiv="refresh" content="10;URL=' . site_url() . 'admin/product/regeneratethumbs?limit=' . ($this->input->get('limit')) . '&page=' . ($this->input->get('page') + 1) . '"> ';
        }

        echo "<h2>Total Process Data : " . $total_process . "</h2>";
        echo "<h2>Total Success Data : " . $total_success . "</h2>";
        die();
    }

    // copy product meta
    public function product_meta_copy_table()
    {
        $total_process = 0;
        $total_success = 0;
        $per_page      = $this->input->get('limit') ? $this->input->get('limit') : 100;
        $offset   	   =($this->input->get('page')) ?($per_page *($this->input->get('page') - 1)) : 0;
        $limit_params  = array('limit' => $per_page, 'start' => $offset);
        $products      = $this->global_model->get('product', false, 'product_id, product_title', $limit_params);

		if(!empty($products))
		{
			foreach($products as $product)
			{
				$product_meta_list  = $this->global_model->get('productmeta', array('product_id' => $product->product_id));

				if(!empty($product_meta_list))
				{
					foreach ($product_meta_list as $meta)
					{
						if($meta->meta_key != 'featured_image' && $meta->meta_key != 'gallery_image')
						{
							$this->global_model->update('product', array($meta->meta_key => $meta->meta_value), array('product_id' => $product->product_id));
						}
					}
				}

				/*echo '<pre>';
				print_r($product_meta_list);
				echo '</pre>';*/

            	$total_process++;
			}
		}

        if ($total_process > 0) {
            echo '<META http-equiv="refresh" content="10;URL=' . site_url() . 'admin/product/product_meta_copy_table?limit=' . ($this->input->get('limit')) . '&page=' . ($this->input->get('page') + 1) . '"> ';
        }

        echo "<h2>Total Process Data : " . $total_process . "</h2>";
        //echo "<h2>Total Success Data : " . $total_success . "</h2>";
        die();
    }
    public function category_wise_product(){
        
$user_id= $this->session->user_id;
$category_id= $this->input->post('category_id');


     
$products=get_result("SELECT * FROM `product` JOIN  term_relation on term_relation.product_id=product.product_id
join  category on category.category_id=term_relation.term_id
join  product_manager_access_terms on product_manager_access_terms.term_id=category.category_id
WHERE category_id=$category_id and user_id=$user_id");
$html="";
foreach ($products as $product){
    $html .=$product->product_id;
}
   
    echo $html; 
						
    }
    
    public function confirm_product($id){
        $row_data['status']=1;
        	if($this->global_model->update('product', $row_data, array('product_id' => $id)))
				{
				  	$this->session->set_flashdata('success_msg', 'Product successfully Published');
						redirect('admin/product/');
				 
				    
				    
				} else {
				    	$this->session->set_flashdata('error_msg', 'Failed to Published');
				    
				}
        
    }
}