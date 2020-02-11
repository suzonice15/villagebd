<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pcbuilder extends CI_Controller
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
        
		$this->load->model('PcbuilderModel', 'pcbuilder');
	}

	public function settings()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'pcbuilder';
        $data['page_active'] 	= 'settings';
		$data['page_title']		= 'PC Builder Settings';
		
		if($this->input->post())
		{
			$row_data						= array();
			$amd_motherboard_ids			= $this->input->post('amd_motherboard_ids');
			$amd_ram_ids					= $this->input->post('amd_ram_ids');
			$intel_motherboard_ids			= $this->input->post('intel_motherboard_ids');
			$intel_ram_ids					= $this->input->post('intel_ram_ids');
			$cpu_id							= $this->input->post('cpu_id');
			$componentes					= $this->input->post('component');

			$row_data['amd_motherboard_ids']	= $amd_motherboard_ids;
			$row_data['amd_ram_ids']			= $amd_ram_ids;
			$row_data['intel_motherboard_ids']	= $intel_motherboard_ids;
			$row_data['intel_ram_ids']			= $intel_ram_ids;
			$row_data['cpu_id']					= $cpu_id;

			$row_data['pcbuilder_settings']	= serialize($componentes);
			$data['componentes']			= $componentes;
			
			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			redirect('admin/pcbuilder/settings/?message=success&purpose=update+options', 'refresh');
		}

        // load the views
        $data['layout'] = $this->load->view('pcbuilder/settings', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function product_mapping()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'pcbuilder';
        $data['page_active'] 	= 'product_mapping';
		$data['page_title']		= 'PC Builder Product Mapping';

		$cpu_id 				= get_option('cpu_id');

		$data['cpu_products']   = $this->pcbuilder->get_products(null, null, null, $cpu_id);
		
		if($this->input->post())
		{
			$row_data = $this->input->post();

			foreach($row_data as $key=>$val)
			{
				update_option($key, $val);
			}
			
			redirect('admin/pcbuilder/product_mapping/?message=success&purpose=update+product+mapping', 'refresh');
		}

        // load the views
        $data['layout'] = $this->load->view('pcbuilder/product_mapping', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function admin_quote()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'pcbuilder';
        $data['page_active'] 	= 'admin_quote';
		$data['page_title']		= 'PC Builder Quote';

		$data['quotes']			= $this->global_model->get('quote');
		
        // load the views
        $data['layout'] = $this->load->view('pcbuilder/quote', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function admin_quote_view($quote_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'pcbuilder';
        $data['page_active'] 	= 'admin_quote_view';
		$data['page_title']		= 'PC Builder Quote: '.$quote_id;
		$data['quote']			= $this->global_model->get_row('quote', array('quote_id' => $quote_id));
			
        // load the views
        $data['layout'] = $this->load->view('pcbuilder/quote_view', $data, TRUE);;
        $this->load->view('template', $data);
	}
}