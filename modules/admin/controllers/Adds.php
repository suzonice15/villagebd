<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adds extends CI_Controller
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
        $data['menu_group']  	= 'adds';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Ads';

        $data['action_button'] = array('url'   => site_url('admin/adds/add_new'),
            'title' => 'Add New Ad'
        );

        // params
        $params = array('status' => 1);
        if ($this->input->get('query')) {
            $params['adds_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'adds.adds_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'adds.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('adds', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/adds', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('adds', $params, '*', $limit_params, $order_by);
			
        // load the views
        $data['layout'] = $this->load->view('adds/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'adds';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Adds';

		if($this->input->post())
		{
			$this->form_validation->set_rules('adds_title', 'Adds Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$row_data					=	array();
				$row_data['adds_title']	=	$this->input->post('adds_title');
				$row_data['adds_link']	=	$this->input->post('adds_link');
				$row_data['adds_type']	=	$this->input->post('adds_type');
			
				if(isset($_FILES["media_file"]))
				{
					$uploaded_image_path = "./uploads/".$_FILES["media_file"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["media_file"]["name"];
					move_uploaded_file($_FILES["media_file"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['adds_title'];
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
				
				if(isset($row_data['media_id']) && !empty($row_data['media_id']))
				{
					if($this->global_model->insert('adds', $row_data))
					{
						redirect('admin/adds');
					}
					else
					{
						redirect('admin/adds');
					}
				}
				else
				{
					$this->load->view('header', $data);
					$this->load->view('adds_new', $data);
					$this->load->view('footer', $data);
				}
			}
		}
		
        // load the views
        $data['layout'] = $this->load->view('adds/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($adds_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'adds';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Ad';

		$data['row']			= $this->global_model->get_row('adds', array('adds_id' => $adds_id));
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('adds_title', 'Adds Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
						       	update_to_recycle_bin('adds', $adds_id);
				$row_data					=	array();
				$row_data['adds_title']	=	$this->input->post('adds_title');
				$row_data['adds_link']	=	$this->input->post('adds_link');
				$row_data['adds_type']	=	$this->input->post('adds_type');
			
				if(isset($_FILES["media_file"]) && $_FILES["media_file"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["media_file"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["media_file"]["name"];
					move_uploaded_file($_FILES["media_file"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['adds_title'];
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
				
				if($this->global_model->update('adds', $row_data, array('adds_id' => $adds_id)))
				{
            		$this->session->set_flashdata('success_msg', 'Successfully updated.');
					redirect('admin/adds');
				}
				else
				{
            		$this->session->set_flashdata('error_msg', 'Failed to updated.');
					redirect('admin/adds/update/'.$adds_id);
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('adds/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($adds_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('adds', array('status' => '0'), array('adds_id' => $adds_id));

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

            add_to_recycle_bin('adds', $adds_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/adds');
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

                foreach ($this->input->post('ids') as $adds_id)
                {
                    if($this->global_model->update('adds', array('status' => '0'), array('adds_id' => $adds_id)))
                    {
                        add_to_recycle_bin('adds', $adds_id);

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

        redirect('admin/adds');
    }
}