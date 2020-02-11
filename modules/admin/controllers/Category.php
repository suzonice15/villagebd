<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");
		
        if (ENVIRONMENT == 'development' || $this->input->get('profiler')) {
            $this->output->enable_profiler(TRUE);
        }

        if(!check_admin_login())
        {
            $this->session->set_userdata('return_url', current_url());
            $this->session->set_flashdata('error_msg', 'Please login first!!');
            redirect('/');
        }
	}

	public function index()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'category';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Categories';
		
        $data['action_button'] = array('url'   => site_url('admin/category/add_new'),
            'title' => 'Add New Category'
        );

        // where clause params
        $params = array('status' => 1);
        if ($this->input->get('query')) {
            $params['category_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'category_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => $this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // get total rows
        $data['total'] = $total_rows = $this->global_model->get_count('category', $params);

        // get the results
        $data['results'] = $this->global_model->get('category', $params, '*', FALSE, $order_by);

        // load the views
        $data['layout'] = $this->load->view('category/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'category';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Category';

        $data['action_button'] = array('url'   => site_url('admin/category'),
            'title' => 'Manage Categories'
        );

		if($this->input->post())
		{

			$this->form_validation->set_rules('category_title', 'Category Title', 'trim|required');
			$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$row_data						= array();
				$row_data['category_title']		= $this->input->post('category_title');
				$row_data['category_name']		= $this->input->post('category_name');
				$row_data['rank']				= $this->input->post('rank') ? $this->input->post('rank') : 0;
				$row_data['parent_id']			= $this->input->post('parent_id');
				
				$row_data['pcbuilder_category']	= $this->input->post('pcbuilder_category');

				$row_data['banner_target_url']	= $this->input->post('banner_target_url');
				$row_data['banner_target_url2']	= $this->input->post('banner_target_url2');
				$row_data['target_url1']		= $this->input->post('target_url1');
				$row_data['target_url2']		= $this->input->post('target_url2');
				$row_data['target_url3']		= $this->input->post('target_url3');
								$row_data['category_price']		= $this->input->post('category_price');
									$row_data['category_icon']		= $this->input->post('category_icon');



				$row_data['seo_title']			= $this->input->post('seo_title');
				$row_data['seo_meta_title']		= $this->input->post('seo_meta_title');
				$row_data['seo_keywords']		= $this->input->post('seo_keywords');
				$row_data['seo_content']		= $this->input->post('seo_content');
				$row_data['seo_meta_content']	= $this->input->post('seo_meta_content');

				$row_data['created_time']		= date("Y-m-d H:i:s");
				$row_data['modified_time']		= date("Y-m-d H:i:s");

				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$media_id = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['media_id'] = $media_id;
				}
				
				if(isset($_FILES["category_banner"]) && $_FILES["category_banner"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_banner"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_banner"]["name"];
					move_uploaded_file($_FILES["category_banner"]["tmp_name"], $uploaded_image_path);
					$category_banner = get_media_id($uploaded_file_path);
					
					if(!$category_banner)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'].' Gallery1';
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_banner = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_banner'] = $category_banner;
				}
				
				if(isset($_FILES["category_banner2"]) && $_FILES["category_banner2"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_banner2"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_banner2"]["name"];
					move_uploaded_file($_FILES["category_banner2"]["tmp_name"], $uploaded_image_path);
					$category_banner2 = get_media_id($uploaded_file_path);
					
					if(!$category_banner2)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'].' Gallery1';
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_banner2 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_banner2'] = $category_banner2;
				}
				
				if(isset($_FILES["category_gallery1"]) && $_FILES["category_gallery1"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_gallery1"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_gallery1"]["name"];
					move_uploaded_file($_FILES["category_gallery1"]["tmp_name"], $uploaded_image_path);
					$category_gallery1 = get_media_id($uploaded_file_path);
					
					if(!$category_gallery1)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'].' Gallery1';
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_gallery1 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_gallery1'] = $category_gallery1;
				}
				
				if(isset($_FILES["category_gallery2"]) && $_FILES["category_gallery2"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_gallery2"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_gallery2"]["name"];
					move_uploaded_file($_FILES["category_gallery2"]["tmp_name"], $uploaded_image_path);
					$category_gallery2 = get_media_id($uploaded_file_path);
					
					if(!$category_gallery2)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'].' Gallery1';
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_gallery2 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_gallery2'] = $category_gallery2;
				}
				
				if(isset($_FILES["category_gallery3"]) && $_FILES["category_gallery3"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_gallery3"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_gallery3"]["name"];
					move_uploaded_file($_FILES["category_gallery3"]["tmp_name"], $uploaded_image_path);
					$category_gallery3 = get_media_id($uploaded_file_path);
					
					if(!$category_gallery3)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'].' Gallery1';
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_gallery3 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_gallery3'] = $category_gallery3;
				}
				
				if($this->global_model->insert('category', $row_data))
				{
					$this->session->set_flashdata('success_msg', 'You have successfully created new category.');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'You have failed to create new category.');
				}
				
				redirect('admin/category');
			}
		}
		
        // load the views
        $data['layout'] = $this->load->view('category/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($category_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'category';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Category';

        $data['action_button'] = array('url'   => site_url('admin/category'),
            'title' => 'Manage Categories'
        );

		$data['cat_row'] = $this->global_model->get_row('category', array('category_id' => $category_id));

		if($this->input->post())
		{
			$this->form_validation->set_rules('category_title', 'Category Title', 'required');
			$this->form_validation->set_rules('category_name', 'Category Name', 'required');
			
			if ($this->form_validation->run())
			{
					    	update_to_recycle_bin('category', $category_id);

				$row_data						= array();
				$row_data['category_title']		= $this->input->post('category_title');
				$row_data['category_name']		= $this->input->post('category_name');
				$row_data['rank']				= $this->input->post('rank') ? $this->input->post('rank') : 0;
				$row_data['parent_id']			= $this->input->post('parent_id');

				$row_data['pcbuilder_category']	= $this->input->post('pcbuilder_category');

				$row_data['banner_target_url']	= $this->input->post('banner_target_url');
				$row_data['banner_target_url2']	= $this->input->post('banner_target_url2');
				$row_data['target_url1']		= $this->input->post('target_url1');
				$row_data['target_url2']		= $this->input->post('target_url2');
				$row_data['target_url3']		= $this->input->post('target_url3');
												$row_data['category_price']		= $this->input->post('category_price');
	$row_data['category_icon']		= $this->input->post('category_icon');
				
				$row_data['seo_title']			= $this->input->post('seo_title');
				$row_data['seo_meta_title']		= $this->input->post('seo_meta_title');
				$row_data['seo_keywords']		= $this->input->post('seo_keywords');
				$row_data['seo_content']		= $this->input->post('seo_content');
				$row_data['seo_meta_content']	= $this->input->post('seo_meta_content');
			
				$row_data['modified_time']		= date("Y-m-d H:i:s");

				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$media_id = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['media_id'] = $media_id;
				}
				
				if(isset($_FILES["category_banner"]) && $_FILES["category_banner"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_banner"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_banner"]["name"];
					move_uploaded_file($_FILES["category_banner"]["tmp_name"], $uploaded_image_path);
					$category_banner = get_media_id($uploaded_file_path);
					
					if(!$category_banner)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_banner = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_banner'] = $category_banner;
				}
				
				if(isset($_FILES["category_banner2"]) && $_FILES["category_banner2"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_banner2"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_banner2"]["name"];
					move_uploaded_file($_FILES["category_banner2"]["tmp_name"], $uploaded_image_path);
					$category_banner2 = get_media_id($uploaded_file_path);
					
					if(!$category_banner2)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_banner2 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_banner2'] = $category_banner2;
				}
				
				if(isset($_FILES["category_gallery1"]) && $_FILES["category_gallery1"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_gallery1"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_gallery1"]["name"];
					move_uploaded_file($_FILES["category_gallery1"]["tmp_name"], $uploaded_image_path);
					$category_gallery1 = get_media_id($uploaded_file_path);
					
					if(!$category_gallery1)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_gallery1 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_gallery1'] = $category_gallery1;
				}
				
				if(isset($_FILES["category_gallery2"]) && $_FILES["category_gallery2"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_gallery2"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_gallery2"]["name"];
					move_uploaded_file($_FILES["category_gallery2"]["tmp_name"], $uploaded_image_path);
					$category_gallery2 = get_media_id($uploaded_file_path);
					
					if(!$category_gallery2)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_gallery2 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_gallery2'] = $category_gallery2;
				}
				
				if(isset($_FILES["category_gallery3"]) && $_FILES["category_gallery3"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["category_gallery3"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["category_gallery3"]["name"];
					move_uploaded_file($_FILES["category_gallery3"]["tmp_name"], $uploaded_image_path);
					$category_gallery3 = get_media_id($uploaded_file_path);
					
					if(!$category_gallery3)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['category_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$category_gallery3 = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['category_gallery3'] = $category_gallery3;
				}
				
				if($this->global_model->update('category', $row_data, array('category_id' => $category_id)))
				{
					$this->session->set_flashdata('success_msg', 'You have successfully updated category.');
					redirect('admin/category');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'You have failed to update category.');
					redirect('admin/category/update/'.$category_id);
				}
			}
		}
		
        // load the views
        $data['layout'] = $this->load->view('category/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($category_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->global_model->update('category', array('status' => 0), array('category_id' => $category_id));

		add_to_recycle_bin('category', $category_id);

        $category_info = $this->global_model->get_row('category', array('category_id' => $category_id));
        
        if(!empty($category_info) && !empty($category_info->parent_id))
        {
    		$child_categories = $this->global_model->get('category', array('parent_id' => $category_info->category_id));

    		if(!empty($child_categories))
	        {
	        	foreach ($child_categories as $child_cat)
	        	{
    				$this->global_model->update('category', array('status' => 0), array('category_id' => $child_cat->category_id));

					add_to_recycle_bin('category', $child_cat->category_id);
	        	}
	        }
        }
        
        $this->session->set_flashdata('success_msg', 'Deleted successfully!');
    	redirect('admin/category');
    }

    public function bulk_action()
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method()))
        {
            redirect('admin/permission_denied');
        }

        if ($this->input->post('action'))
        {
            if ($this->input->post('ids'))
            {
            	$items = 0;

                foreach ($this->input->post('ids') as $id)
                {
                    if($this->global_model->update('category', array('status' => 0), array('category_id' => $id)))
                    {
                    	add_to_recycle_bin('category', $id);

				        $category_info = $this->global_model->get_row('category', array('category_id' => $category_id));
				        
				        if(!empty($category_info) && !empty($category_info->parent_id))
				        {
			        		$child_categories = $this->global_model->get('category', array('parent_id' => $category_info->category_id));

			        		if(!empty($child_categories))
					        {
					        	foreach ($child_categories as $child_cat)
					        	{
			        				$this->global_model->update('category', array('status' => 0), array('category_id' => $child_cat->category_id));

                					add_to_recycle_bin('category', $child_cat->category_id);
					        	}
					        }
				        }

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

        redirect('admin/category');
    }
}