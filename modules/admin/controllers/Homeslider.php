<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homeslider extends CI_Controller
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
        $data['menu_group']  	= 'homeslider';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Sliders';

        $data['action_button'] = array('url' => site_url('admin/homeslider/add_new'), 'title' => 'Add New Slider');

        // params
        $params = array('status' => 1);
        if ($this->input->get('query')) {
            $params['media_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'homeslider.homeslider_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'homeslider.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('homeslider', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/homeslider', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('homeslider', $params, '*', $limit_params, $order_by);
			
        // load the views
        $data['layout'] = $this->load->view('homeslider/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'homeslider';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Slider';
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('homeslider_title', 'Slider Title', 'trim|required');
			if ($this->form_validation->run())
			{
				$row_data						= array();
				$row_data['homeslider_title']	= $this->input->post('homeslider_title');
				$homeslider_banner				= $this->input->post('homeslider_banner');
				$row_data['target_url']			= $this->input->post('target_url');
								$row_data['slider_position']			= $this->input->post('slider_position');

				$row_data['created_time']		= date("Y-m-d H:i:s");
				$row_data['modified_time']		= date("Y-m-d H:i:s");
			
				if(empty(trim($homeslider_banner)))
				{
					if((($_FILES["featured_image"]["type"]=="image/jpg") || ($_FILES["featured_image"]["type"]=="image/jpeg") || ($_FILES["featured_image"]["type"]=="image/png") || ($_FILES["featured_image"]["type"]=="image/gif")))
					{
						if($_FILES["featured_image"]["error"] > 0)
						{
							echo "Return Code: " . $_FILES["featured_image"]["error"] . "<br />";
						}
						else
						{
							$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
							$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
							move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
							
							$data['homeslider_banner'] = $uploaded_file_path;
							$row_data['homeslider_banner'] = $uploaded_file_path;
						}
					}
				}
				else
				{
					$data['homeslider_banner'] = $homeslider_banner;
					$row_data['homeslider_banner'] = $homeslider_banner;
				}
				
				if(!empty($row_data['homeslider_banner']))
				{
					if($this->global_model->insert('homeslider', $row_data))
					{
						$this->session->set_flashdata('success_msg', 'You have successfully created.');
					}
					else
					{
						$this->session->set_flashdata('error_msg', 'You have failed to create.');
					}
					
					redirect('admin/homeslider');
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('homeslider/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($homeslider_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'homeslider';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Slider';
		
		$data['prod_row']		= $this->global_model->get_row('homeslider', array('homeslider_id' => $homeslider_id));
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('homeslider_title', 'Slider Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$row_data						= array();
				$row_data['homeslider_title']	= $this->input->post('homeslider_title');
				$homeslider_banner				= $this->input->post('homeslider_banner');
				$row_data['target_url']			= $this->input->post('target_url');
												$row_data['slider_position']			= $this->input->post('slider_position');

				$row_data['created_time']		= date("Y-m-d H:i:s");
				$row_data['modified_time']		= date("Y-m-d H:i:s");
				
				if(empty(trim($homeslider_banner)))
				{
					if((($_FILES["featured_image"]["type"]=="image/jpg") || ($_FILES["featured_image"]["type"]=="image/jpeg") || ($_FILES["featured_image"]["type"]=="image/png") || ($_FILES["featured_image"]["type"]=="image/gif")))
					{
						if($_FILES["featured_image"]["error"] > 0)
						{
							echo "Return Code: " . $_FILES["featured_image"]["error"] . "<br />";
						}
						else
						{
							$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
							$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
							move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
							
							$data['homeslider_banner'] = $uploaded_file_path;
							$row_data['homeslider_banner'] = $uploaded_file_path;
						}
					}
				}
				else
				{
					$data['homeslider_banner'] = $homeslider_banner;
					$row_data['homeslider_banner'] = $homeslider_banner;
				}
				
				if(!empty($row_data['homeslider_banner']))
				{
					if($this->global_model->update('homeslider', $row_data, array('homeslider_id' =>$homeslider_id)))
					{
						$this->session->set_flashdata('success_msg', 'You have successfully udated.');
						redirect('admin/homeslider');
					}
					else
					{
						$this->session->set_flashdata('error_msg', 'You have failed to udate.');
						redirect('admin/homeslider/update/'.$homeslider_id);
					}
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('homeslider/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($homeslider_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('homeslider', array('status' => '0'), array('homeslider_id' => $homeslider_id));

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

            add_to_recycle_bin('homeslider', $homeslider_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/homeslider');
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

                foreach ($this->input->post('ids') as $homeslider_id)
                {
                    if($this->global_model->update('homeslider', array('status' => '0'), array('homeslider_id' => $homeslider_id)))
                    {
                        add_to_recycle_bin('homeslider', $homeslider_id);

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

        redirect('admin/homeslider');
    }
}