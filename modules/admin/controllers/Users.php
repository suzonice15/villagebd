<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
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
        $data['menu_group']  	= 'users';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Users';

        $data['action_button'] = array('url' => site_url('admin/users/add_new'), 'title' => 'Add New User');

        // get the roles
        $data['roles'] = get_user_roles();

        // where clause params
        $params = array('users.status' => '1');
        if ($this->input->get('query')) {
            $params['users.user_name like'] = '%' . $this->input->get('query') . '%';
        }
        if ($this->input->get('user_type') && $this->input->get('user_type') != 'all') {
            $params['users.user_type'] = $this->input->get('user_type');
        }

        // order by
        $order_by = array('field' => 'users.user_id', 'order' => 'DESC');

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'users.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('users', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/users', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('users', $params, '*', $limit_params, $order_by);
			
        // load the views
        $data['layout'] = $this->load->view('users/manage', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'users';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'New User';

		if($this->input->post())
		{
			$this->form_validation->set_rules('user_name', 'name', 'trim|required');
			$this->form_validation->set_rules('user_email', 'email', 'trim|required|is_unique[users.user_email]');
			$this->form_validation->set_rules('user_type', 'role', 'trim|required');
			$this->form_validation->set_rules('user_pass', 'password', 'trim|required');

			if ($this->form_validation->run())
			{
				$row_data = array();
				$row_data['user_name']			= $this->input->post('user_name');
				$row_data['user_email']			= $this->input->post('user_email');
				$row_data['user_login']			= $this->input->post('user_email');
				$row_data['user_type']			= $this->input->post('user_type');
				$row_data['user_pass']			= md5($this->input->post('user_pass'));
				$row_data['registered_date']	= date('Y-m-d H:i:s');
				$row_data['updated_date']		= date('Y-m-d H:i:s');
				
				if($user_id = $this->global_model->insert('users', $row_data))
				{
					if($this->input->post('categories'))
					{
						foreach($this->input->post('categories') as $term_id)
						{
							$access_term_row_data			 = array();
							$access_term_row_data['user_id'] = $user_id;
							$access_term_row_data['term_id'] = $term_id;

							$this->global_model->insert('product_manager_access_terms ', $access_term_row_data);
						}
					}

					$this->session->set_flashdata('success_msg', 'New user successfully created');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'New user failed to create');
				}
				
				redirect('admin/users');
			}
		}

        // load the views
        $data['layout'] = $this->load->view('users/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($user_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'users';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update User';

		$data['result']       = $this->global_model->get_row('users', array('user_id' => $user_id));
		$data['assign_terms'] = $this->global_model->get('product_manager_access_terms', array('user_id' => $user_id));

		if($this->input->post())
		{
			$this->form_validation->set_rules('user_name', 'name', 'trim|required');
			$this->form_validation->set_rules('user_email', 'email', 'trim|required');
			$this->form_validation->set_rules('user_type', 'role', 'trim|required');
			
			if ($this->form_validation->run())
			{
			    	update_to_recycle_bin('users', $user_id);
				$row_data					= array();
				$row_data['user_name']		= $this->input->post('user_name');
				$row_data['user_email']		= $this->input->post('user_email');
				$row_data['user_login']		= $this->input->post('user_email');
				$row_data['user_type']		= $this->input->post('user_type');
				$user_pass					= $this->input->post('user_pass');
				$row_data['updated_date']	= date('Y-m-d H:i:s');

				if(!empty($user_pass))
				{
					$row_data['user_pass']	= md5($this->input->post('user_pass'));
				}

				if($this->global_model->update('users', $row_data, array('user_id' => $user_id)))
				{
					$this->global_model->delete('product_manager_access_terms ', array('user_id' => $user_id));
					
					if($this->input->post('categories'))
					{
						foreach($this->input->post('categories') as $term_id)
						{
							$access_term_row_data = array();
							$access_term_row_data['user_id']	= $user_id;
							$access_term_row_data['term_id']	= $term_id;

							$this->global_model->insert('product_manager_access_terms ', $access_term_row_data);
						}
					}

					$this->session->set_flashdata('success_msg', 'user successfully updated');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'user failed to update');
				}
				
				redirect('admin/users');
			}
		}

        // load the views
        $data['layout'] = $this->load->view('users/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($user_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('users', array('status' => '0'), array('user_id' => $user_id));

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

			add_to_recycle_bin('users', $user_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
        	redirect('admin/users');
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

                foreach ($this->input->post('ids') as $id)
                {
                    if($this->global_model->update('users', array('status' => '0'), array('user_id' => $id)))
                    {
                    	add_to_recycle_bin('users', $id);

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

        redirect('admin/users');
    }
}