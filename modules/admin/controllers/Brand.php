<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller
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
            redirect('admin/login');
        }
	}

	public function index()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'brand';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Brands';

        $data['action_button'] = array('url'   => site_url('admin/brand/add_new'),
            'title' => 'Add New Brand'
        );

        // params
        $params = array('status' => 1);
        if ($this->input->get('query')) {
            $params['brand_name like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'brand.brand_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'brand.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('brand', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/brand', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('brand', $params, '*', $limit_params, $order_by);
			
        // load the views
        $data['layout'] = $this->load->view('brand/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'brand';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Brand';
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('brand_name', 'name', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$row_data						= array();
				$row_data['brand_name']			= $this->input->post('brand_name');
				$row_data['created_time']		= date('Y-m-d H:i:s');
				$row_data['modified_time']		= date('Y-m-d H:i:s');

				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_name = 'brand_'.time().'_'.$_FILES["featured_image"]["name"];
					$uploaded_image_path = './uploads/'.$uploaded_image_name;
					$uploaded_file_path = 'uploads/'.$uploaded_image_name;

					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);

					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['brand_name'];
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
				
				if($this->global_model->insert('brand', $row_data))
				{
					$this->session->set_flashdata('success_msg', 'Successfully created.');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to create.');
				}
				
				redirect('admin/brand');
			}
		}

        // load the views
        $data['layout'] = $this->load->view('brand/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($brand_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'brand';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Brand';

		$data['data_row']		= $this->global_model->get_row('brand', array('brand_id' => $brand_id));
		
		if($this->input->post())
		{
			$row_data					= array();
			$row_data['brand_name']		= $this->input->post('brand_name');
			$row_data['modified_time']	= date('Y-m-d H:i:s');
			
			$this->form_validation->set_rules('brand_name', 'Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
				
							    	update_to_recycle_bin('brand', $brand_id);

				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_name = 'brand_'.time().'_'.$_FILES["featured_image"]["name"];
					$uploaded_image_path = './uploads/'.$uploaded_image_name;
					$uploaded_file_path = 'uploads/'.$uploaded_image_name;

					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);

					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['brand_name'];
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
				
				if($this->global_model->update('brand', $row_data, array('brand_id' => $brand_id)))
				{
					$this->session->set_flashdata('success_msg', 'Successfully updated.');
					redirect('admin/brand');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to update.');
					redirect('admin/brand/update/'.$brand_id);
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('brand/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($brand_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('brand', array('status' => '0'), array('brand_id' => $brand_id));

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE)
        {
            $this->db->trans_rollback();

            $this->session->set_flashdata('error_msg', 'Failed to delete!');
            redirect($this->_module);
        }
        else
        {
            $this->db->trans_commit();

            add_to_recycle_bin('brand', $brand_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/brand');
        }
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

                foreach ($this->input->post('ids') as $brand_id)
                {
                    if($this->global_model->update('brand', array('status' => '0'), array('brand_id' => $brand_id)))
                    {
                        add_to_recycle_bin('brand', $brand_id);

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

        redirect('admin/brand');
    }
}