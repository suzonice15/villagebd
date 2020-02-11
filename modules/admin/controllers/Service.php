<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller
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
            redirect('/admin/login');
        }
	}

	public function index()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'service';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Services';

        $data['action_button'] = array('url'   => site_url('admin/service/add_new'),
            'title' => 'Add New Service'
        );

        // params
        $params = array('status' => 1);
        if ($this->input->get('query')) {
            $params['service_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'service.service_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'service.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('service', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/service', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('service', $params, '*', $limit_params, $order_by);

        // load the views
        $data['layout'] = $this->load->view('service/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'service';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Service';

        if($this->input->post())
        {
			$this->form_validation->set_rules('service_title', 'Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
			
				$row_data						=	array();
				$row_data['service_title']			=	$this->input->post('service_title');
				$row_data['service_name']			=	$this->input->post('service_name');
				$row_data['service_summary']		=	$this->input->post('service_summary');
				$row_data['created_time']		=	date('Y-m-d H:i:s');
				$row_data['modified_time']		=	date('Y-m-d H:i:s');
			
				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['service_title'] 	= $row_data['service_title'];
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
				
				if($this->global_model->insert('service', $row_data))
				{
					$this->session->set_flashdata('success_msg', 'Successfully created.');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to create.');
				}
				
				redirect('admin/service');
			}
        }

        // load the views
        $data['layout'] = $this->load->view('service/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($service_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'service';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Service';

		$data['data_row']		= $this->global_model->get_row('service', array('service_id' => $service_id));

		if($this->input->post())
		{
			$this->form_validation->set_rules('service_title', 'Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
					update_to_recycle_bin('service', $service_id);
				$row_data						=	array();
				$row_data['service_title']			=	$this->input->post('service_title');
				$row_data['service_name']			=	$this->input->post('service_name');
				$row_data['service_summary']		=	$this->input->post('service_summary');
				$row_data['modified_time']		=	date('Y-m-d H:i:s');
			
				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['service_title'] 	= $row_data['service_title'];
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
				
				if($this->global_model->update('service', $row_data, array('service_id' => $service_id)))
				{
					$this->session->set_flashdata('success_msg', 'Successfully updated.');
					redirect('admin/service');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to update.');
					redirect('admin/service/update/'.$service_id);
				}
			}
		}
		
        // load the views
        $data['layout'] = $this->load->view('service/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($service_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('service', array('status' => '0'), array('service_id' => $service_id));

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

            add_to_recycle_bin('service', $service_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/service');
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

                foreach ($this->input->post('ids') as $service_id)
                {
                    if($this->global_model->update('service', array('status' => '0'), array('service_id' => $service_id)))
                    {
                        add_to_recycle_bin('service', $service_id);

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

        redirect('admin/service');
    }
}