<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
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

		$this->load->model('AdminModel', 'admin');
	}

	public function index()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Academic Classes';
			
        // load the views
        $data['layout'] = $this->load->view('home', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function inquiry()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'inquiry';
		$data['page_title']		= 'Customer Inquiry';

        // load the views
        $data['layout'] = $this->load->view('inquiry', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function inquiry_view($inquiry_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'inquiry';
		$data['page_title']		= 'Customer Inquiry';

		$data['inquiry_row']	= $this->admin->inquiry_result_by_id($inquiry_id);

        // load the views
        $data['layout'] = $this->load->view('inquiry_view', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function feedback()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'feedback';
		$data['page_title']		= 'Customer Feedback';

        // load the views
        $data['layout'] = $this->load->view('feedback', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function feedback_view($feedback_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'feedback';
		$data['page_title']		= 'Customer Feedback';

		$data['feedback_row']	= $this->admin->feedback_result_by_id($feedback_id);

        // load the views
        $data['layout'] = $this->load->view('feedback_view', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	public function careerinquiry()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'careerinquiry';
		$data['page_title']		= 'Customer Inquiry';
			
        // load the views
        $data['layout'] = $this->load->view('careerinquiry', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function options()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'options';
		$data['page_title']		= 'Options';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/options');
		}

        // load the views
        $data['layout'] = $this->load->view('options', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function homesettings()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'homesettings';
		$data['page_title']		= 'Home Page Settings';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/homesettings');
		}

        // load the views
        $data['layout'] = $this->load->view('homesettings', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function brands_tab()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'brands_tab';
		$data['page_title']		= 'Brands';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/brands_tab');
		}

        // load the views
        $data['layout'] = $this->load->view('brands_tab', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function about()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'about';
		$data['page_title']		= 'About Us';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/about');
		}

        // load the views
        $data['layout'] = $this->load->view('about', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function career()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'career';
		$data['page_title']		= 'Career';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/career');
		}

        // load the views
        $data['layout'] = $this->load->view('career', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function terms()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'terms';
		$data['page_title']		= 'Terms and Conditions';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/terms');
		}

        // load the views
        $data['layout'] = $this->load->view('terms', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function deliveryinfo()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'deliveryinfo';
		$data['page_title']		= 'Delivery Informations';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/deliveryinfo');
		}

        // load the views
        $data['layout'] = $this->load->view('deliveryinfo', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function warrantypolicy()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'warrantypolicy';
		$data['page_title']		= 'Warranty Policy';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/warrantypolicy');
		}

        // load the views
        $data['layout'] = $this->load->view('warrantypolicy', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function contact()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'contact';
		$data['page_title']		= 'Contact Us';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/contact');
		}

        // load the views
        $data['layout'] = $this->load->view('contact', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function findshop()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'findshop';
		$data['page_title']		= 'Find Shop';
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			$this->session->set_flashdata('success_msg', 'Changes saved');
			redirect('admin/findshop');
		}

        // load the views
        $data['layout'] = $this->load->view('findshop', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function visitors()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'visitors';
		$data['page_title']		= 'Visitors';
		
        // load the views
        $data['layout'] = $this->load->view('visitors', $data, TRUE);
        $this->load->view('template', $data);
	}

	public function permission($role = 'super-admin') {
		if($this->session->user_type != 'super-admin')
		{
			redirect('admin/permission_denied');
		}

		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'permission';
		$data['page_title']		= 'User Permission';

		$data['role'] = $role;

        if ($this->input->post()) {
            foreach (getModules() as $module) {
                $has_checked = $this->input->post($module->module_name) ? $this->input->post($module->module_name) : array();

                $action_list = getActions(array('module_id' => $module->module_id));
                if ($action_list) {
                    foreach ($action_list as $actions) {
                        $aPermission = $this->global_model->get_row('permissions', array('role' => $role, 'module' => $module->module_name, 'action' => $actions->action_name));
                        if ($aPermission) {
                            $values      = (in_array($actions->action_name, $has_checked)) ? 'yes' : 'no';
                            $update_data = array(
                                'have_access' => $values
                            );
                            $this->global_model->update('permissions', $update_data, array('id' => $aPermission->id));
                        } else {
                            $values    = (in_array($actions->action_name, $has_checked)) ? 'yes' : 'no';
                            $save_data = array(
                                'role'        => $role,
                                'module'      => $module->module_name,
                                'action'      => $actions->action_name,
                                'have_access' => $values
                            );
                            $this->global_model->insert('permissions', $save_data);
                        }
                    }
                }
            }
            $this->session->set_flashdata('success_msg', 'Change save successfully');
            redirect('admin/permission/' . $role);
        }

        // load the views
        $data['layout'] = $this->load->view('permission', $data, TRUE);
        $this->load->view('template', $data);
    }

    public function permission_denied() {
		$data 					= array();
        $data['menu_group']  	= 'admin';
        $data['page_active'] 	= 'permission_denied';
		$data['page_title']		= 'Permission Denied';

        // load the views
        $data['layout'] = $this->load->view('permission_denied', $data, TRUE);
        $this->load->view('template', $data);
    }
}